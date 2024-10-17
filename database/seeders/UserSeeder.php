<?php

namespace Database\Seeders;

use App\Enum\UserTypeEnum;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::findOrCreate('Super Admin');

        $user1 = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('password'),
                'type' => UserTypeEnum::ADMIN->value,
            ]
        );

        $user1->assignRole($role);


    }
}
