<?php
namespace Xetaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Link;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::macro('user.profile', function () {
            return Menu::new()
                ->addClass('mb-2 nav nav-menu flex-column')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('users.account.index', '<i class="fas fa-user-edit"></i> Compte')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.user.member', '<i class="fas fa-user-astronaut"></i> Membre')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.notification.index', '<i class="fas fa-user-tag"></i> Notifications')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.reward.index', '<i class="fas fa-award"></i> Récompenses')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.social.index', '<i class="fas fa-user-plus"></i> Social')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.user.transactions', '<i class="fab fa-paypal"></i> Transactions')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.user.settings', '<i class="fas fa-user-cog"></i> Paramètres')
                        ->addClass('nav-link')
                )
                ->setActiveFromRequest();
        });

        // Administration
        Menu::macro('admin.administration', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.page.index', '<i class="fa fa-dashboard"></i> Tableau de bord')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest('/admin');
        });

        Menu::macro('admin.user', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.user.user.index', '<i class="fa fa-users"></i> Gérer les Utilisateurs')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });

        Menu::macro('admin.role', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.role.role.index', '<i class="fa fa-user-circle-o"></i> Gérer les Rôles')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->add(
                    Link::toRoute('admin.role.permission.index', '<i class="fa fa-wrench"></i> Gérer les Permissions')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });

        Menu::macro('admin.setting', function () {
            return Menu::new()
                ->addClass('nav nav-pills flex-column mb-0')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('admin.setting.index', '<i class="fa fa-cogs"></i> Gérer les Paramètres')
                        ->addClass('nav-link')
                        ->addParentClass('nav-item')
                )
                ->setActiveFromRequest();
        });
    }
}
