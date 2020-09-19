<?php
namespace Xetaravel\Models\Presenters;

trait PaypalUserPresenter
{

    /**
     * Get the hashtag of the user. Return the username if the user
     * has not set his first name and last name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $fullName = $this->parse($this->first_name) .' '. $this->parse($this->last_name);

        return $fullName;
    }

    /**
     * Parse an attribute and return its value or empty if null.
     *
     * @param string|null $attribute The attribute to parse.
     *
     * @return string
     */
    protected function parse($attribute): string
    {
        if ($attribute === null) {
            return '';
        }

        return $attribute;
    }
}
