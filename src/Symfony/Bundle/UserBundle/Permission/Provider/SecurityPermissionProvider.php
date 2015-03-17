<?php

namespace Symfony\Bundle\UserBundle\Permission\Provider;

/**
 * Security Provider
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class SecurityPermissionProvider implements ProviderInterface
{
    public function getPermissions()
    {
        return array(
            'ROLE_ADMIN_USER'                 => array('ROLE_VIEW', 'ROLE_ADD', 'ROLE_UPDATE', 'ROLE_DELETE', 'ROLE_RESTORE'),
            'ROLE_SUPER_ADMIN'                => array('ROLE_SUPER_ADMIN', 'ROLE_ADMIN_USER'),
        );
    }
}