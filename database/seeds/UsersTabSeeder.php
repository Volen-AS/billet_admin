<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'   => 'Автор не відомий',
                'email'  => 'uathor_unknown@g.g',
                'password'=> bcrypt(Str::random(16)),
            ],
            [
                'name'   => 'Автор',
                'email'  => 'uatho@g.g',
                'password'=> bcrypt('123123123')
            ]
        ];
        DB::table('users')->insert($data);

    }
}
