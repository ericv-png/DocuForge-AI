<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'data_source_create',
            ],
            [
                'id'    => 20,
                'title' => 'data_source_edit',
            ],
            [
                'id'    => 21,
                'title' => 'data_source_show',
            ],
            [
                'id'    => 22,
                'title' => 'data_source_delete',
            ],
            [
                'id'    => 23,
                'title' => 'data_source_access',
            ],
            [
                'id'    => 24,
                'title' => 'data_category_create',
            ],
            [
                'id'    => 25,
                'title' => 'data_category_edit',
            ],
            [
                'id'    => 26,
                'title' => 'data_category_show',
            ],
            [
                'id'    => 27,
                'title' => 'data_category_delete',
            ],
            [
                'id'    => 28,
                'title' => 'data_category_access',
            ],
            [
                'id'    => 29,
                'title' => 'extracted_data_create',
            ],
            [
                'id'    => 30,
                'title' => 'extracted_data_edit',
            ],
            [
                'id'    => 31,
                'title' => 'extracted_data_show',
            ],
            [
                'id'    => 32,
                'title' => 'extracted_data_delete',
            ],
            [
                'id'    => 33,
                'title' => 'extracted_data_access',
            ],
            [
                'id'    => 34,
                'title' => 'query_create',
            ],
            [
                'id'    => 35,
                'title' => 'query_edit',
            ],
            [
                'id'    => 36,
                'title' => 'query_show',
            ],
            [
                'id'    => 37,
                'title' => 'query_delete',
            ],
            [
                'id'    => 38,
                'title' => 'query_access',
            ],
            [
                'id'    => 39,
                'title' => 'query_message_create',
            ],
            [
                'id'    => 40,
                'title' => 'query_message_edit',
            ],
            [
                'id'    => 41,
                'title' => 'query_message_show',
            ],
            [
                'id'    => 42,
                'title' => 'query_message_delete',
            ],
            [
                'id'    => 43,
                'title' => 'query_message_access',
            ],
            [
                'id'    => 44,
                'title' => 'setting_create',
            ],
            [
                'id'    => 45,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 46,
                'title' => 'setting_show',
            ],
            [
                'id'    => 47,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 48,
                'title' => 'setting_access',
            ],
            [
                'id'    => 49,
                'title' => 'report_create',
            ],
            [
                'id'    => 50,
                'title' => 'report_edit',
            ],
            [
                'id'    => 51,
                'title' => 'report_show',
            ],
            [
                'id'    => 52,
                'title' => 'report_delete',
            ],
            [
                'id'    => 53,
                'title' => 'report_access',
            ],
            [
                'id'    => 54,
                'title' => 'error_create',
            ],
            [
                'id'    => 55,
                'title' => 'error_edit',
            ],
            [
                'id'    => 56,
                'title' => 'error_show',
            ],
            [
                'id'    => 57,
                'title' => 'error_delete',
            ],
            [
                'id'    => 58,
                'title' => 'error_access',
            ],
            [
                'id'    => 59,
                'title' => 'moderation_create',
            ],
            [
                'id'    => 60,
                'title' => 'moderation_edit',
            ],
            [
                'id'    => 61,
                'title' => 'moderation_show',
            ],
            [
                'id'    => 62,
                'title' => 'moderation_delete',
            ],
            [
                'id'    => 63,
                'title' => 'moderation_access',
            ],
            [
                'id'    => 64,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
