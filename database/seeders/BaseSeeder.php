<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

abstract class BaseSeeder extends Seeder
{
    /**
     * The table to seed.
     *
     * @var string
     */
    protected string $table;

    /**
     * The CSV file to use for seeding.
     *
     * @var string
     */
    protected string $csvFile;

    /**
     * Run the database seeds.
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table($this->table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $csv = Reader::createFromPath(database_path($this->csvFile), 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $record) {
            foreach ($record as $key => $value) {
                // Check if the value is an empty string
                if ($value === '') {
                    // If so, set it to NULL
                    $record[$key] = null;
                }
            }

            if (empty($record['created_at'])) {
                $record['created_at'] = now();
            }
            if (empty($record['updated_at'])) {
                $record['updated_at'] = now();
            }
            DB::table($this->table)->insert($record);
        }
    }
}
