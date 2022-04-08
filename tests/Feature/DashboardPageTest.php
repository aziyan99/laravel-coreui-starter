<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardPageTest extends TestCase
{
    use RefreshDatabase;

    public function prepareDBWithRolePermission()
    {
        $user = User::create([
            'name' => 'Ezzy',
            'email'    => 'username@example.net',
            'password' => bcrypt('secret'),
        ]);
        $permission = Permission::create([
            'title' => 'dashboard_view'
        ]);
        $role = Role::create([
            'title' => 'test',
        ]);
        $role->permissions()->sync([$role->id]);
        $user->roles()->sync([$role->id]);
    }

    public function test_user_cannot_go_to_dashboard_before_login()
    {
        $this->visit('/admin/dashboard')->seeRouteIs('login');
    }

    public function test_user_can_go_to_dashboard_after_login()
    {
        $this->prepareDBWithRolePermission();
        $this->visit('login');
        $this->submitForm('Login', [
            'email'    => 'username@example.net',
            'password' => 'secret',
        ]);

        $this->visit('/admin/dashboard');
        $this->seePageIs('/admin/dashboard')->seeText('Dashboard');
    }
}
