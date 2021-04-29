<?php

namespace App\Models\Canvas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use App\Traits\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\File;
use Carbon\Carbon;

class RecruitmentPublication extends Model implements HasMedia
{
    use SoftDeletes, HasTranslations, InteractsWithMedia;

    public $translatable = ['title', 'description', 'requirements', 'slug'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'website_rec_pubs';
    protected $dates = ['start_date', 'end_date'];

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


    public function scopeOrderByTitle($query)
    {
        $query->orderBy('title');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
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
     * Get the category relationship.
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(RecruitmentCategory::class);
    }

    /**
     * Get the submissions relationship.
     *
     * @return BelongsTo
     */
    public function submissions()
    {
        return $this->hasMany(RecruitmentSubmission::class, 'pub_id');
    }

    public function registerMediaCollections(): void
    {       
        $this->addMediaCollection('documents');     
    }

    /**
     * Scope a query to only include published posts.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished($query)
    {
        return $query->where('start_date', '<=', now()->format('Y-m-d'))
                        ->where('end_date', '>=', now()->format('Y-m-d'));
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
    //         $item->posts()->detach();
    //     });
    // }
}
