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

class CoursePlan extends Model implements HasMedia
{
    use SoftDeletes, HasTranslations, InteractsWithMedia;

    public $translatable = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'website_css';
    protected $dates = [];

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

    /**
     * Get the course relationship.
     *
     * @return BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the subject relationship.
     *
     * @return BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the semester relationship.
     *
     * @return BelongsTo
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->WhereHas('course', function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('subject', function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('semester', function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
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

    public function registerMediaCollections(): void
    {       
        $this->addMediaCollection('documents');     
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
