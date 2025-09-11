<?php

namespace Database\Seeders;

use App\Enum\PermissionEnum;
use App\Enum\RolesEnum;
use App\Models\Association;
use App\Models\Client;
use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $userRole=Role::create(['name'=>RolesEnum::Client->value]);
        $adminRole=Role::create(['name'=>RolesEnum::Admin->value]);
        $associationRole=Role::create(['name'=>RolesEnum::Association->value]);

        $manageUsers=Permission::create(['name'=>PermissionEnum::ManageUsers->value]);
        $manageServices=Permission::create(['name'=>PermissionEnum::ManageServices->value]);
        $manageJops=Permission::create(['name'=>PermissionEnum::ManageJops->value]);
        $requestService=Permission::create(['name'=>PermissionEnum::RequestService->value]);
        $addSuccessStory=Permission::create(['name'=>PermissionEnum::AddSuccessStory->value]);
        $manageSuccessStory=Permission::create(['name'=>PermissionEnum::ManageSuccessStory->value]);

        $adminRole->syncPermissions([$manageJops,$manageUsers,$manageServices,$manageSuccessStory]);
        $associationRole->syncPermissions([$manageJops,$manageServices]);
        $userRole->syncPermissions([$addSuccessStory,$requestService]);

        User::factory()->create([
            'email' => 'admin@example.com',
            'password'=>Hash::make('emademad')
        ])->assignRole(RolesEnum::Admin);
        User::factory()->create([
            'email' => 'association@example.com',
            'password'=>Hash::make('emademad')
        ])->assignRole(RolesEnum::Association);
        User::factory()->create([
            'email' => 'client@example.com',
            'password'=>Hash::make('emademad')
        ])->assignRole(RolesEnum::Client);
        Client::create([
            'user_id' => 3,
            'full_name' => 'مستخدم',
            'mobile_number' => '966512345678',
            'file_path' => 'uploads/uploads/clients/Files/obito.pdf',
            'accepted'=>0,
            'image' => 'uploads/uploads/clients/Images/obito.pdf',
        ]);
        Association::create([
            'user_id' => 2,
            'full_name' => ' جمعية',
            'mobile_number' => '966512345678',
            'lisence' => '123123123',
            'accepted' => 0,
            'file_path' => 'uploads/uploads/clients/Files/obito.pdf',
            'image' => 'uploads/uploads/clients/Images/obito.pdf',
        ]);
        Setting::create([
            'about_footer'=>'منصة إلكترونية شاملة لربط ذوي الإحتياجات الخاصة بالخدمات المتخصصة التي يحتاجونها بطريقة سهلة وموثوقة.',
            'phone1'=>'+963938614264',
            'email1'=>'tamkeen@gmail.com',
            'facebook'=>'',
            'linkedin'=>'',
            'instagram'=>'',
            'youtube'=>'',

        ]);
    }
}
