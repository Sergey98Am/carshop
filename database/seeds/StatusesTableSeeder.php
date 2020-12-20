<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'Pending',
            ],
            [
                'name' => 'Purchased'
            ],
            [
                'name' => 'Canceled'
            ],
        ];

        Status::insert($statuses);
    }
}
