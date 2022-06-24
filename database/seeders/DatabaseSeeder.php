<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'name' => 'Group 1'
        ]);

        Group::create([
            'name' => 'Group 2'
        ]);

        $faker = Container::getInstance()->make(Generator::class);

        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->firstName,
                'email'     => 'user' . $i . '@gmail.com',
                'password' => bcrypt('123456'),
                'group_id' => Group::inRandomOrder()->value('id')
            ]);
        }

    }
}
