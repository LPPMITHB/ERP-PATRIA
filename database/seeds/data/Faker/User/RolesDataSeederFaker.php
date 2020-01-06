<?php

namespace Database\Data\Faker;

use App\Models\Permission;

/**
 * Export to PHP Array plugin for PHPMyAdmin
 * @version 4.9.0.1
 */

/**
 * Database `erp_patria`
 */
class RolesDataSeederFaker
{
    /* `erp_patria`.`menus` */
    public static function getRoleUser()
    {
        return json_encode([
            'show-dashboard' => true,
            'show-user' => true, 'edit-user' => true, 'change-role' => true,
        ]);
    }

    public static function getRoleCustomer()
    {
        return json_encode([
            'show-dashboard' => true,
            'show-user' => true, 'edit-user' => true,
            'show-project-progress' => true,
            'create-post' => true,
        ]);
    }
}
