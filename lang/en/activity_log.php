<?php

return [
    'actions' => [
        'store' => 'Create',
        'update' => 'Edit',
        'destroy' => 'Delete',
        'import' => 'Import',
        'export' => 'Export',
        'update_password' => 'Update Password',
        'update_permissions' => 'Update Permissions',
        'login' => 'Login',
        'register' => 'Register',
        'update_profile' => 'Update Profile',
        'update_profile_permissions' => 'Update Profile Permissions',
        'update_profile_password' => 'Update Profile Password',
    ],
    'descriptions' => [
        'store' => ':user_table :user_name added a new :record_table :record_name',
        'update' => ':user_table :user_name updated :record_table :record_name',
        'destroy' => ':user_table :user_name deleted :record_table with ID: :record_id',
        'import' => ':user_table :user_name bulk imported :record_table',
        'export' => ':user_table :user_name exported data from :record_table',
        'update_password' => ':user_table :user_name updated the password for :record_name',
        'update_permissions' => ':user_table :user_name updated the permissions for :record_name',
        'login' => ':user_table :user_name logged in',
        'register' => ':user_table :user_name registered',
        'update_profile' => ':user_table :user_name updated the profile information',
        'update_profile_permissions' => ':user_table :user_name updated the profile permissions',
        'update_profile_password' => ':user_table :user_name updated the profile password',
    ]
];