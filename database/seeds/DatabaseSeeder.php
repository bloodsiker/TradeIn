<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UserSeeder::class);

        $roles = [
            ['id' => 1, 'name' => 'Администратор сайта'],
            ['id' => 2, 'name' => 'Руководитель торговой сети'],
            ['id' => 3, 'name' => 'Сотрудник магазина'],
        ];

        DB::table('roles')->insert($roles);

        DB::table('users')->insert([
            'name' => 'Admin',
            'surname' => 'Admin',
            'email' => 'admin@gmail.com',
            'role_id' => \App\Models\Role::ROLE_ADMIN,
            'is_active' => true,
            'password' => bcrypt('admin'),
        ]);

        $statuses = [
            ['id' => 1, 'name' => 'Зарегистрирован'],
            ['id' => 2, 'name' => 'Отправлен'],
            ['id' => 3, 'name' => 'Принят'],
            ['id' => 4, 'name' => 'Возврат'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
