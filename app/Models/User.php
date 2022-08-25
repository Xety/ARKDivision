<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\Sluggable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Xetaravel\Models\Presenters\UserPresenter;
use Xetaravel\Notifications\Auth\VerifyEmail;
use Xetaravel\Notifications\Auth\ResetPassword;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    HasRoleAndPermissionContract,
    HasMedia,
    MustVerifyEmailContract
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        Notifiable,
        Sluggable,
        HasRoleAndPermission,
        InteractsWithMedia,
        UserPresenter,
        MustVerifyEmail,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'slug',
        'discord_id',
        'register_ip',
        'transaction_count',
        'last_login_ip',
        'last_login',
        'email_verified_at',
        'claimed_coffre_count_total',
        'claimed_coffre_bonus_5_count_total',
        'claimed_coffre_bonus_10_count_total',
        'claimed_coffre_bonus_15_count_total',
        'claimed_coffre_bonus_20_count_total',
        'claimed_coffre_bonus_25_count_total',
        'claimed_coffre_bonus_30_count_total',
        'claimed_coffre_count_monthly'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_background',
        'profile_url',

        // Media Model
        'avatar_small',
        'avatar_medium',
        'avatar_big',
        'avatar_primary_color',

        // Account Model
        'first_name',
        'last_name',
        'full_name',
        'discord_nickname',
        'steam_nickname',
        'twitch_nickname',
        'is_member'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_login',
        'member_expire_at',
        'last_claimed_coffre'
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
        return 'username';
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
     * Get the Quests Stats for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function questStats()
    {
        return $this->hasOne(LethalquestsStat::class);
    }

    /**
     * Get the account for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    /**
     * Get the badges for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    /**
     * Get the notifications for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
                        ->orderByRaw("case when read_at IS NULL then 0 else 1 end")
                        ->orderBy('created_at', 'desc');
    }

    /**
     * Get the server for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function server()
    {
        return $this->hasOne(Server::class);
    }

    /**
     * Get the paypal for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paypal()
    {
        return $this->hasOne(PaypalUser::class);
    }

    /**
     * Get the transactions for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(TransactionUser::class, 'user_id', 'id');
    }

    /**
     * Get the rewards for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rewards()
    {
        return $this->belongsToMany(Reward::class)
            ->using(RewardUser::class)
            ->withPivot([
                'id',
                'read_at',
                'was_used',
                'used_at'
            ])
            ->withTimestamps();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Get all permissions from roles.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rolePermissions(): Builder
    {
        $permissionModel = app(config('roles.models.permission'));

        return $permissionModel
            ::select([
                'permissions.*',
                'permission_role.created_at as pivot_created_at',
                'permission_role.updated_at as pivot_updated_at'
            ])
            ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
            ->join('roles', 'roles.id', '=', 'permission_role.role_id')
            ->whereIn('roles.id', $this->getRoles()->pluck('id')->toArray())
            ->orWhere('roles.level', '<', $this->level())
            ->groupBy([
                'permissions.id',
                'permissions.name',
                'permissions.slug',
                'permissions.description',
                'permissions.model',
                'permissions.created_at',
                'permissions.updated_at',
                'permissions.is_deletable',
                'pivot_created_at',
                'pivot_updated_at'
            ]);
    }
}
