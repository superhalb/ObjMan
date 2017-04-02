<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('objects')->insert([
            'name' => 'name1',
            'description' => 'description1',
            'type' => 'type1',
        ]);
        DB::table('objects')->insert([
            'name' => 'name2',
            'description' => 'description2',
            'type' => 'type2',
        ]);
        DB::table('objects')->insert([
            'name' => 'name3',
            'description' => 'description3',
            'type' => 'type3',
        ]);

        DB::table('relations')->insert([
            'from' => 1,
            'to' => 2,
        ]);
        DB::table('relations')->insert([
            'from' => 1,
            'to' => 3,
        ]);
        DB::table('relations')->insert([
            'from' => 2,
            'to' => 3,
        ]);

    }
}
