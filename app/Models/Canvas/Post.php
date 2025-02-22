<?php

namespace App\Models\Canvas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Canvas;
use App\Models\Canvas\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
// use App\Traits\HasUuid;
use Illuminate\Support\Str;
use App\Traits\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\File;

class Post extends Model implements HasMedia
{
    use HasFactory, HasTranslations, SoftDeletes, InteractsWithMedia;

    public $translatable = ['body', 'title', 'slug', 'featured_image_caption', 'summary'];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'website_posts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'read_time',
    ];

    /**
     * Get the tags relationship.
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'website_posts_tags',
            'post_id',
            'tag_id'
        );
    }

    public function scopeRelated($query, array $args) {

        return $query->whereHas('topic', function($query) use ($args){
            $query->whereIn('topic_id', $args);
        })->latest()->take(3)->get();
    }

    /**
     * Get the topic relationship.
     *
     * @return BelongsToMany
     */
    public function topic(): BelongsToMany
    {
        return $this->belongsToMany(
            Topic::class,
            'website_posts_topics',
            'post_id',
            'topic_id'
        );
    }

    /**
     * Get the user relationship.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['type'] ?? null, function ($query, $type) {
            if ($type === 'draft') {
                return $query->draft();
            }

            return $query->published();
        })->when($filters['topic'] ?? null, function ($query, $topic) {
            return $query->whereHas('topic', function($query, $topic) {
                $query->where('topic_id', $topic);
            });
        })->when($filters['range'] ?? null, function ($query) {
            $query->whereBetween(
                'created_at',
                [
                    Carbon::parse(collect(explode(',', request('range')))->first())->startOfDay(),
                    Carbon::parse(collect(explode(',', request('range')))->last())->endOfDay()
                ]);
        });
    }

    /**
     * Get the views relationship.
     *
     * @return HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    /**
     * Get the visits relationship.
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Check to see if the post is published.
     *
     * @return bool
     */
    public function getPublishedAttribute(): bool
    {
        return ! is_null($this->published_at) && $this->published_at <= now()->toDateTimeString();
    }

    /**
     * Get the human-friendly estimated reading time of a post.
     *
     * @return string
     */
    public function getReadTimeAttribute(): string
    {
        // Only count words in our estimation
        $words = str_word_count(strip_tags($this->body));

        // Divide by the average number of words per minute
        $minutes = ceil($words / 250);

        // The user is optional since we append this attribute
        // to every model and we may be creating a new one
        return sprintf('%d %s %s',
            $minutes,
            Str::plural(trans('canvas::app.min', [], optional($this->user)->locale), $minutes),
            trans('canvas::app.read', [], optional($this->user)->locale)
        );
    }

    /**
     * Get the 10 most popular reading times rounded to the nearest 30 minutes.
     *
     * @return array
     */
    public function getPopularReadingTimesAttribute(): array
    {
        // Get the views associated with the post
        $data = $this->views;

        // Filter the view data to only include hours:minutes
        $collection = collect();
        $data->each(function ($item, $key) use ($collection) {
            $collection->push($item->created_at->minute(0)->format('H:i'));
        });

        // Count the unique values and assign to their respective keys
        $filtered = array_count_values($collection->toArray());

        $popularReadingTimes = collect();
        foreach ($filtered as $key => $value) {
            // Use each given time to create a 60 min range
            $start = Date::createFromTimeString($key);
            $end = $start->copy()->addMinutes(60);

            // Find the percentage based on the value
            $percentage = number_format($value / $data->count() * 100, 2);

            // Get a human-readable hour range and floating percentage
            $popularReadingTimes->put(
                sprintf('%s - %s', $start->format('g:i A'), $end->format('g:i A')),
                $percentage
            );
        }

        // Cast the collection to an array
        $array = $popularReadingTimes->toArray();

        // Only return the top 5 reading times and percentages
        $sliced = array_slice($array, 0, 5, true);

        // Sort the array in a descending order
        arsort($sliced);

        return $sliced;
    }

    /**
     * Get the top referring websites for a post.
     *
     * @return array
     */
    public function getTopReferersAttribute(): array
    {
        // Get the views associated with the post
        $data = $this->views;

        // Filter the view data to only include referrers
        $collection = collect();
        $data->each(function ($item, $key) use ($collection) {
            if (empty(Canvas::trim($item->referer))) {
                $collection->push(trans('canvas::app.other', [], $this->user->locale));
            } else {
                $collection->push(Canvas::trim($item->referer));
            }
        });

        // Count the unique values and assign to their respective keys
        $array = array_count_values($collection->toArray());

        // Only return the top N referrers with their view count
        $sliced = array_slice($array, 0, 10, true);

        // Sort the array in a descending order
        arsort($sliced);

        return $sliced;
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished($query): Builder
    {
        return $query->where('published_at', '<=', now()->toDateTimeString());
    }

    /**
     * Scope a query to only include drafted posts.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDraft($query): Builder
    {
        return $query->where('published_at', null)->orWhere('published_at', '>', now()->toDateTimeString());
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($item) {
    //         $item->tags()->detach();
    //         $item->topic()->detach();
    //     });
    // }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif',
                ])
            ->useFallbackUrl('/images/avatar-1.jpg')
            ->useFallbackPath(public_path('/images/avatar-1.jpg'))
            ->singleFile();

        $this->addMediaCollection('featured_images')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif',
                ])
            ->useFallbackUrl('/images/avatar-1.jpg')
            ->useFallbackPath(public_path('/images/avatar-1.jpg'))
            ->singleFile();
            
            $this->addMediaCollection('documents');     
    }
}
