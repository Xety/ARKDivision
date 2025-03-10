<?php
namespace Xetaravel\Models\Presenters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Xetaravel\Models\Session;
use Xetaravel\Utility\UserUtility;

trait UserPresenter
{
    /**
     * The default avatar used when there is no avatar for the user.
     *
     * @var string
     */
    protected $defaultAvatar = '/images/avatar.png';

    /**
     * The default primary color used when there is no primary color defined.
     *
     * @var string
     */
    protected $defaultAvatarPrimaryColor = '#B4AEA4';

    /**
     * Get the user's username.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->trashed() ? 'Deleted' : $value
        );
    }

    /**
     * Get the member status of the user.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function isMember(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->member_expire_at <= Carbon::now() ? false : true
        );
    }

    /**
     * Get the account first name.
     *
     * @return string
     */
    public function getFirstNameAttribute(): string
    {
        return $this->parse($this->account, 'first_name');
    }

    /**
     * Get the account last name.
     *
     * @return string
     */
    public function getLastNameAttribute(): string
    {
        return $this->parse($this->account, 'last_name');
    }

    /**
     * Get whatever the user has rubies or not.
     *
     * @return boolean
     */
    public function getHasRubiesAttribute(): bool
    {
        return $this->rubies_total > 0 ? true : false;
    }

    /**
     * Get the account full name. Return the username if the user
     * has not set his first name and last name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        if ($this->trashed()) {
            return $this->username;
        }

        $fullName = $this->parse($this->account, 'first_name') . ' ' . $this->parse($this->account, 'last_name');

        if (empty(trim($fullName))) {
            return $this->username;
        }

        return $fullName;
    }

    /**
     * Get the Discord nickname.
     *
     * @return string
     */
    public function getDiscordNicknameAttribute(): string
    {
        $nickname = $this->parse($this->account, 'discord_username') . '#' .
                                $this->parse($this->account, 'discord_discriminator');

        return $nickname;
    }

    /**
     * Get the Steam nickname.
     *
     * @return string
     */
    public function getSteamNicknameAttribute(): string
    {
        $nickname = $this->parse($this->account, 'steam_username');

        return $nickname;
    }

    /**
     * Get the Twitch nickname.
     *
     * @return string
     */
    public function getTwitchNicknameAttribute(): string
    {
        $nickname = $this->parse($this->account, 'twitch_username');

        return $nickname;
    }

    /**
     * Get the experiences total formated.
     *
     * @return integer
     */
    public function getExperiencesTotalAttribute($experiencesTotal): int
    {
        return number_format($experiencesTotal, 0, ".", " ");
    }

    /**
     * Get the account facebook.
     *
     * @return string
     */
    public function getFacebookAttribute(): string
    {
        return $this->parse($this->account, 'facebook');
    }

    /**
     * Get the account twitter.
     *
     * @return string
     */
    public function getTwitterAttribute(): string
    {
        return $this->parse($this->account, 'twitter');
    }

    /**
     * Get the account biography.
     *
     * @return string
     */
    public function getBiographyAttribute(): string
    {
        return $this->parse($this->account, 'biography');
    }

    /**
     * Get the account signature.
     *
     * @return string
     */
    public function getSignatureAttribute(): string
    {
        return $this->parse($this->account, 'signature');
    }

    /**
     * Get the small avatar.
     *
     * @return string
     */
    public function getAvatarSmallAttribute(): string
    {
        return $this->parseMedia('thumbnail.small');
    }

    /**
     * Get the medium avatar.
     *
     * @return string
     */
    public function getAvatarMediumAttribute(): string
    {
        return $this->parseMedia('thumbnail.medium');
    }

    /**
     * Get the big avatar.
     *
     * @return string
     */
    public function getAvatarBigAttribute(): string
    {
        return $this->parseMedia('thumbnail.big');
    }

    /**
     * Get the profile background.
     *
     * @return string
     */
    public function getProfileBackgroundAttribute(): string
    {
        return UserUtility::getProfileBackground();
    }

    /**
     * Get the profile url.
     *
     * @return string
     */
    public function getProfileUrlAttribute(): string
    {
        if (!isset($this->slug)) {
            return '';
        }

        if ($this->trashed()) {
            return route('users.user.show', ['slug' => strtolower($this->username)]);
        }

        return route('users.user.show', ['slug' => $this->slug]);
    }

    /**
     * Get the primary color detected in the avatar.
     *
     * @return string
     */
    public function getAvatarPrimaryColorAttribute(): string
    {
        if (isset($this->getMedia('avatar')[0]) && $this->getMedia('avatar')[0]->hasCustomProperty('primaryColor')) {
            return $this->getMedia('avatar')[0]->getCustomProperty('primaryColor');
        }

        return $this->defaultAvatarPrimaryColor;
    }

    /**
     * We must decrement the post count due to the first post being counted.
     *
     * @param int $count The actual post count cache.
     *
     * @return int
     */
    public function getDiscussPostCountAttribute($count): int
    {
        return $count - $this->discuss_conversation_count;
    }

    /**
     * Get the status of the user : online or offline
     *
     * @return string
     */
    public function getOnlineAttribute(): string
    {
        $online = Session::expires()->where('user_id', $this->id)->first();

        return is_null($online) ? false : true;
    }

    /**
     * Parse a media and return it if isset or return the default avatar.
     *
     * @param string $type The type of the media to get.
     *
     * @return string
     */
    protected function parseMedia(string $type): string
    {
        if (isset($this->getMedia('avatar')[0])) {
            return $this->getMedia('avatar')[0]->getUrl($type);
        }

        return $this->defaultAvatar;
    }

    /**
     * Parse an attribute and return its value or empty if null.
     *
     * @param Object|null $relation The relation or the user object.
     *       Can be `$this` or `$this->account` for exemple
     * @param string|null $attribute The attribute to parse.
     *
     * @return string
     */
    protected function parse($relation, $attribute): string
    {
        if ($relation === null || $relation->{$attribute} === null) {
            return '';
        }

        return $relation->{$attribute};
    }
}
