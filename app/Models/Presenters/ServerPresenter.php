<?php
namespace Xetaravel\Models\Presenters;

use Xetaravel\Models\Status;

trait ServerPresenter
{
    /**
     * Get the actual status of the server.
     *
     * @return string
     */
    public function getStatusAttribute(): Status
    {
        return $this->statutes()->orderBy('pivot_created_at', 'desc')->first();
    }

    /**
     * Get the small server image.
     *
     * @return string
     */
    public function getImageSmallAttribute(): string
    {
        return $this->parseMedia('thumbnail.small');
    }

    /**
     * Get the medium server image.
     *
     * @return string
     */
    public function getImageMediumAttribute(): string
    {
        return $this->parseMedia('thumbnail.medium');
    }

    /**
     * Get the big server image.
     *
     * @return string
     */
    public function getImageBigAttribute(): string
    {
        return $this->parseMedia('thumbnail.big');
    }

    /**
     * Parse a mdedia and return it if isset or return the default avatar.
     *
     * @param string $type The type of the media to get.
     *
     * @return string
     */
    protected function parseMedia(string $type): string
    {
        if (isset($this->getMedia('server')[0])) {
            return $this->getMedia('server')[0]->getUrl($type);
        }

        return $this->defaultAvatar;
    }
}
