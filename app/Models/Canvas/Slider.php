<?php

namespace App\Models\Canvas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use App\Traits\HasTranslations;
use Carbon\Carbon;

class Slider extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable = ['title', 'description'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'website_sliders';

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
     * Get the page relationship.
     *
     * @return BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the page relationship.
     *
     * @return hasMany
     */
    public function images()
    {
        return $this->hasMany(SliderImage::class);
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
