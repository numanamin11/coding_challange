<?php 
namespace App\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItem(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->addChild('new')
            ->setLabel('Logs')
            ->setAttribute('type', 'link')
        ;

        $newSubmenu
            ->addChild('new-subitem', ['route' => 'admin_email_logs'])
            ->setLabel('Email Logs')
            ->setLabelAttribute('icon', 'email')
        ;
    }
}