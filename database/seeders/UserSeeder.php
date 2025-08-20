<?php

namespace Database\Seeders;

class UserSeeder extends BaseSeeder
{
    /**
     * The table to seed.
     *
     * @var string
     */
    protected string $table = 'users';

    /**
     * The CSV file to use for seeding.
     *
     * @var string
     */
    protected string $csvFile = 'seeders/csv/users.csv';
}
