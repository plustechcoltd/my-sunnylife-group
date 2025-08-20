<?php

return [
    'success' => [
        'create' => '#:id :name has been created.',
        'update' => '#:id :name has been updated.',
        'update_no_id' => 'Updated successfully.',
        'delete' => '#:id :name has been deleted.',
        'import' => 'The data has been imported successfully.',
    ],
    'error' => [
        'import_csv' => 'The CSV file is invalid. Please check the file and try again.',
        'self_delete' => 'Logged-in users cannot be deleted.',
    ],
];