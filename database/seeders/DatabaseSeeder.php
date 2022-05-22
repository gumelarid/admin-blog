<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\LabelModel;
use App\Models\NavModel;
use App\Models\RoleModel;
use App\Models\SettingModel;
use App\Models\User;
use App\Models\UserAccessModel;
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
        // user
        User::create([
            'user_id' => Str::uuid(),
            'user_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
            'status'    => 1,
            'role_id'   => 1,
            'profile'   => 'default.png'
        ]);

        // role
        RoleModel::create([
            'role' => 'Administrator'
        ]);

        RoleModel::create([
            'role' => 'User'
        ]);

         // Label
        LabelModel::create([
            'label' => 'Menu',
        ]);

        LabelModel::create([
            'label' => 'Configurations'
           
        ]);

        // Navigation
        NavModel::create([
            'nav_id'            => '23fa2366-2da3-44f1-a6f0-390b81c3c63f',
            'id_label'          => 1,
            'url'               => '/dashboard',
            'name'              => 'Dashboard',
            'icon'              => 'dashboard',
            'is_active'         => 1,
        ]);

        NavModel::create([
            'nav_id'            => 'd23bf4fd-4e72-4e16-bd7f-ec200d70dc13',
            'id_label'          => 2,
            'url'               => '/dashboard/role',
            'name'              => 'Role Access',
            'icon'              => 'verified_user',
            'is_active'         => 1,
        ]);

        NavModel::create([
            'nav_id'            => Str::uuid(),
            'id_label'          => 2,
            'url'               => '/dashboard/navigation',
            'name'              => 'Navigation',
            'icon'              => 'autorenew',
            'is_active'         => 1,
        ]);

        NavModel::create([
            'nav_id'            => Str::uuid(),
            'id_label'          => 2,
            'url'               => '/dashboard/user',
            'name'              => 'List Users',
            'icon'              => 'manage_accounts',
            'is_active'         => 1,
        ]);

        NavModel::create([
            'nav_id'            => Str::uuid(),
            'id_label'          => 2,
            'url'               => '/dashboard/profile',
            'name'              => 'My Profile',
            'icon'              => 'person',
            'is_active'         => 1,
        ]);

        NavModel::create([
            'nav_id'            => Str::uuid(),
            'id_label'          => 2,
            'url'               => '/dashboard/setting',
            'name'              => 'Setting',
            'icon'              => 'settings',
            'is_active'         => 1,
        ]);


        // access
        UserAccessModel::create([
            'access_id'         => Str::uuid(),
            'role_id'           => 1,
            'nav_id'            => 'd23bf4fd-4e72-4e16-bd7f-ec200d70dc13'
        ]);

        UserAccessModel::create([
            'access_id'         => Str::uuid(),
            'role_id'           => 1,
            'nav_id'            => '23fa2366-2da3-44f1-a6f0-390b81c3c63f'
        ]);


        // setting
        SettingModel::create([
            'id_setting'        => Str::uuid(),
            'logo'              => 'logo_default.png',
            'webname'           => 'GumelarId Dashboard',
            'description'       => 'Sebuah web dashboard admin open source yang dapat digunakan oleh developer atau company, dapat dikembangkan untuk membuat web company profile, blog, dll',
            'meta_description'  =>  'dashboard admin open source',
            'is_logo'           => 1,
            'is_developer'      => 1
        ]);

        
    }
}
