<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Server extends Model implements HasMedia
{
    use InteractsWithMedia,
        Sluggable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        // Media Model
        'server_small',
        'server_medium',
        'server_big'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generated the slug before updating.
        static::updating(function ($model) {
            $model->generateSlug();
        });
    }

    /**
     * Return the field to slug.
     *
     * @return string
     */
    public function slugStrategy(): string
    {
        return 'name';
    }

    /**
     * Register the related to the Model.
     *
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail.small')
                ->width(100)
                ->height(100)
                ->keepOriginalImageFormat();

        $this->addMediaConversion('thumbnail.medium')
                ->width(200)
                ->height(200)
                ->keepOriginalImageFormat();

        $this->addMediaConversion('thumbnail.big')
                ->width(300)
                ->height(300)
                ->keepOriginalImageFormat();

        $this->addMediaConversion('original')
                ->keepOriginalImageFormat();
    }

    /**
     * The statutes that belong to the server.
     */
    public function statutes()
    {
        return $this->belongsToMany(Status::class)->using(ServerStatus::class)->withTimestamps();
    }
}
