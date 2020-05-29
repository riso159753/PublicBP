<?php

use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'nazov' => 'Order Confirmed',
        ]);

        DB::table('status')->insert([
            'nazov' => 'Production model',
        ]);

        DB::table('status')->insert([
            'nazov' => 'Preparation',
        ]);

        DB::table('status')->insert([
            'nazov' => 'Export to Press',
        ]);

        DB::table('status')->insert([
            'nazov' => 'Press',
        ]);

        DB::table('status')->insert([
            'nazov' => 'Sewing',
        ]);

        DB::table('status')->insert([
            'nazov' => 'Dispatched',
        ]);

        DB::table('status')->insert([
            'nazov' => 'Invoiced',
        ]);


    }
}
