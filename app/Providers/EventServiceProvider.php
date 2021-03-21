<?php
namespace Xetaravel\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\Discord\\DiscordExtendSocialite@handle',
            'SocialiteProviders\\Twitch\\TwitchExtendSocialite@handle'
        ],
        \Illuminate\Auth\Events\Registered::class => [
            \Illuminate\Auth\Listeners\SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        \Xetaravel\Listeners\Subscribers\BadgeSubscriber::class,
        \Xetaravel\Listeners\Subscribers\Discuss\LogSubscriber::class,
        \Xetaravel\Listeners\Subscribers\ExperienceSubscriber::class,
        \Xetaravel\Listeners\Subscribers\RubySubscriber::class,
        \Xetaravel\Listeners\Subscribers\Server\ServerStatusSubscriber::class,
        \Xetaravel\Listeners\Subscribers\RCON\RCONSubscriber::class,
        \Xetaravel\Listeners\Subscribers\Donation\DonationSubscriber::class,
        \Xetaravel\Listeners\Subscribers\Reward\RewardSubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
