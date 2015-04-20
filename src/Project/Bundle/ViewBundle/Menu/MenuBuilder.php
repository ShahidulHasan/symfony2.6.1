<?php

namespace Project\Bundle\ViewBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $user = $this->userAccessCheck();
        $menu = $factory->createItem('root');
        $menu = $this->commonMenu($menu);
        if($user->hasRole("ROLE_SUPER_ADMIN") ) {
            $menu = $this->settingsMenu($menu);
        }

        return $menu;
    }

    /**
     * @param $menu
     */
    public function settingsMenu($menu)
    {
        $menu
            ->addChild('User', array('route' => 'user_home'))
            ->setAttribute('icon','icon-user');
//            ->setAttribute('dropdown', true);

//        $menu['User']
//            ->addChild('Add New User', array('route' => 'user_add'))
//            ->setAttribute('icon','fa fa-plus');

        $menu
            ->addChild('Group', array('route' => 'group_home'))
            ->setAttribute('icon','icon-users');

        $menu
            ->addChild('Audit', array('route' => 'audit_home'))
            ->setAttribute('icon','icon-eye');

        return $menu;
    }

    /**
     * @param $menu
     */
    public function commonMenu($menu)
    {
        $menu->setChildrenAttributes(array('class' => 'page-sidebar-menu page-sidebar-menu-hover-submenu1'));

        $menu
            ->addChild('Dashboard', array('route' => 'dashboard_home'))
            ->setAttribute('icon', 'icon-home');

        return $menu;
    }

    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @return mixed
     */
    public function userAccessCheck()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $user;
    }
}