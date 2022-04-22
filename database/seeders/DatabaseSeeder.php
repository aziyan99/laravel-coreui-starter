<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => Hash::make('admin@example.test')
        ]);

        $adminRole = Role::create([
           'title' => 'admin'
        ]);

        $user->roles()->sync([$adminRole->id]);

        Permission::insert([
            ['title' => 'dashboard_view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'role_view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'role_create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'role_update', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'role_delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'permission_view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'permission_create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'permission_update', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'permission_delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'user_view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'user_create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'user_update', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'user_delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'setting_view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'setting_update', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        $adminRole->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]);

        Setting::create([
           'web_name' => 'LVCU',
           'logo' => null
        ]);


    }
}
