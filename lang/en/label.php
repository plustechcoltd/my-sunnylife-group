<?php

return [
    // buttons
    'buttons' => [
        'create' => 'Create',
        'edit' => 'Edit',
        'save' => 'Save',
        'delete' => 'Delete',
        'export_csv' => 'Export CSV',
        'import_csv' => 'Import CSV',
        'login' => 'Login',
        'logout' => 'Logout',
        'submit' => 'Submit',
    ],

    // menus
    'menus' => [
        'home' => 'Home',
        'activity_logs' => 'Activity Log',
        'users' => 'User',
        'create_user' => 'Create User',
        'admins' => 'Admin',
        'create_admin' => 'Create Admin',
        'my_profile' => 'My Profile',
        'settings' => 'Setting',
        'languages' => 'Language',
        'contacts' => 'Contact',
        'pages' => 'Pages',
    ],

    // models
    'tables' => [
        'admins' => 'Admin',
        'users' => 'User',
        'settings' => 'Setting',
        'languages' => 'Language',
        'contact' => 'Contact',
        'activity_logs' => 'Activity Log',
        'institutions' => 'Institution',
        'notifications' => 'Notification',
    ],

    'columns' => [
        'common' => [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'actions' => 'Actions',
        ],

        // admins
        'admins' => [
            'code' => 'Code',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'family_name' => 'Family Name',
            'first_name' => 'First Name',
            'full_name' => 'Full Name',
            'gender' => 'Gender',
            'avatar_image_path' => 'Profile Image',
            'language' => 'Language',
            'password' => 'Password',
            'current_password' => 'Current Password',
            'admin_permissions' => 'Admin Permissions',
            'allowed_ips' => 'Allowed IPs',
        ],

        // users
        'users' => [
            'code' => 'Code',
            'first_name' => 'First Name',
            'family_name' => 'Family Name',
            'email' => 'Email',
            'gender' => 'Gender',
            'avatar_image_path' => 'Profile Image',
            'phone' => 'Phone Number',
            'language' => 'Language',
            'password' => 'Password',
            'allowed_ips' => 'Allowed IPs',
        ],

        // settings
        'settings' => [
            'site_settings' => 'Site Settings',
            'site_title' => 'Site Title',
            'site_description' => 'Site Description',
            'maintenance_message' => 'Maintenance Message',
            'logo' => 'Site Logo',
            'logo_login' => 'Login Page Logo',
            'light_logo' => 'Site Light Logo',
            'favicon' => 'Site Favicon',
            'boxed_page' => 'Boxed Layout Page',
            'fixed_footer' => 'Fixed Footer',
            'display_footer' => 'Display Footer',
            'header_background_color' => 'Header Background Color',
            'header_text_color' => 'Header Text Color',
            'navbar_background_color' => 'Navbar Background Color',
            'navbar_text_color' => 'Navbar Text Color',
        ],

        'languages' => [
            'code' => 'Code',
            'flag' => 'Flag',
            'label' => 'Label',
            'default_yn' => 'Default',
            'sortno' => 'Sort No.',
        ],

        'contacts' => [
            'email' => 'Email',
            'title' => 'Title',
            'content' => 'Content'
        ],

        // activity_logs
        'activity_logs' => [
            'user' => 'User',
            'action' => 'Action',
            'record' => 'Record',
            'description' => 'Description',
            'ip_address' => 'IP Address',
            'user_agent' => 'User Agent',
        ],
    ],

    // Labels
    'labels' => [
        'list' => 'List',
        'create' => 'Create',
        'edit' => 'Edit',
        'import' => 'Import',
        'deleted' => '(deleted)',
        'basic_info' => 'Basic Information',
        'password_setting' => 'Password Setting',
        'permission_setting' => 'Permission Setting',
        'new_user_register' => 'New user with email <a :href="userUrl" x-text="userEmail"></a> has been registered.',
        'general_setting' => 'General Setting',
        'language' => 'Language',
        'contact' => 'Contact',
        'upload_csv_file' => 'Upload CSV File',
        'my_profile' => 'My Profile',
        'edit_profile' => 'Edit Profile',
        'edit_manager' => 'Edit Manager',
        'list_room' => 'List Room',
        'search_user_name' => 'Search for a Username...',
        'new_message' => 'New Message',
        'view_all' => 'View All',
        'badge_no_message' => 'New messages will be displayed here when you receive them.',
        'seen' => 'seen',
        'is_typing' => 'is typing',
        'leave_chat' => 'Leave Chat',

        // pages title
        'dashboard' => 'Dashboard',
        'login' => 'Login',
        'forget_password' => 'Forget Password',
        'reset_password' => 'Reset Password',
        'profile' => 'Profile',
        'change_permissions' => 'Change Permissions',
        'change_password' => 'Change Password',
        'edit_admin' => ':name | Admin',
        'change_permissions_admin' => 'Change Permissions | Admin',
        'change_password_admin' => 'Change Password | Admin',
        'chats' => 'Chats',
        'start_chat' => 'Start Chat',
        'edit_user' => ':name | User',
        'change_password_user' => 'Change Password | User',
        'add_language' => 'Add Language',
        'no_language_available' => 'No languages available',
        'manager_user' => 'Manager | User',
    ],
];
