<?php
namespace Xetaravel\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Xetaravel\Models\Presenters\ServerPresenter;
use Xetaravel\Models\Scopes\DisplayScope;
use Xetaravel\Models\Relations\HasManySyncable;

class Server extends Model implements HasMedia
{
    use ServerPresenter,
        InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'ip',
        'rcon_port',
        'password',
        'media'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'status',
        // Media Model
        'image_small',
        'image_medium',
        'image_big'
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new DisplayScope);
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function statutes()
    {
        return $this
            ->belongsToMany(Status::class)
            ->using(ServerStatus::class)
            ->withPivot([
                'id',
                'event_type',
                'was_forced',
                'finished_at'
            ])
            ->withTimestamps();
    }

    /**
     * Get the users for the server.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /*public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }*/

    /**
     * Get the players for the server.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany(ServerUser::class);
    }

    /**
     * Overrides the default Eloquent hasMany relationship to return a HasManySyncable.
     *
     * {@inheritDoc}
     * @return \Xetaravel\Models\Relations\HasManySyncable
     */
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(),
            $this,
            $instance->getTable() . '.' . $foreignKey,
            $localKey
        );
    }
}
