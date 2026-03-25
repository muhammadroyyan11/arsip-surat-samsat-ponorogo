<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        $division = \App\Models\Division::firstOrCreate(['name' => 'Direksi']);
        $position = \App\Models\Position::firstOrCreate(['name' => 'Direktur Utama']);

        $staff = \App\Models\Staff::firstOrCreate(
            ['nip' => '123456789'],
            [
                'name' => 'Super Admin',
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'division_id' => $division->id,
                'position_id' => $position->id,
            ]
        );

        $user = \App\Models\User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'staff_id' => $staff->id,
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
            ]
        );

        $sectionMaster = \App\Models\MenuSection::firstOrCreate(['section_name' => 'Master Data'], ['order' => 1]);
        $sectionMail = \App\Models\MenuSection::firstOrCreate(['section_name' => 'Surat Menyurat'], ['order' => 2]);
        $sectionSystem = \App\Models\MenuSection::firstOrCreate(['section_name' => 'System'], ['order' => 3]);

        $menus = [
            ['section_id' => $sectionMaster->id, 'menu_name' => 'Divisi', 'url' => 'divisions.index', 'icon' => 'fas fa-building', 'permission_slug' => 'divisions-view', 'order' => 1],
            ['section_id' => $sectionMaster->id, 'menu_name' => 'Jabatan', 'url' => 'positions.index', 'icon' => 'fas fa-id-badge', 'permission_slug' => 'positions-view', 'order' => 2],
            ['section_id' => $sectionMaster->id, 'menu_name' => 'Staff', 'url' => 'staffs.index', 'icon' => 'fas fa-users', 'permission_slug' => 'staffs-view', 'order' => 3],
            ['section_id' => $sectionMaster->id, 'menu_name' => 'Kategori Surat', 'url' => 'kategori-surats.index', 'icon' => 'fas fa-tags', 'permission_slug' => 'kategori-surats-view', 'order' => 4],
            ['section_id' => $sectionMail->id, 'menu_name' => 'Surat Masuk', 'url' => 'surat-masuks.index', 'icon' => 'fas fa-inbox', 'permission_slug' => 'surat-masuks-view', 'order' => 1],
            ['section_id' => $sectionMail->id, 'menu_name' => 'Surat Keluar', 'url' => 'surat-keluars.index', 'icon' => 'fas fa-paper-plane', 'permission_slug' => 'surat-keluars-view', 'order' => 2],
            ['section_id' => $sectionMail->id, 'menu_name' => 'Disposisi Saya', 'url' => 'disposis.index', 'icon' => 'fas fa-exchange-alt', 'permission_slug' => 'disposis-view', 'order' => 3],
            ['section_id' => $sectionSystem->id, 'menu_name' => 'Users', 'url' => 'users.index', 'icon' => 'fas fa-user-shield', 'permission_slug' => 'users-view', 'order' => 1],
            ['section_id' => $sectionSystem->id, 'menu_name' => 'Menu & Akses', 'url' => 'menus.index', 'icon' => 'fas fa-cogs', 'permission_slug' => 'menus-view', 'order' => 2],
        ];

        foreach ($menus as $m) {
            $menu = \App\Models\Menu::firstOrCreate(['url' => $m['url']], $m);
            \App\Models\UserMenu::firstOrCreate(['user_id' => $user->id, 'menu_id' => $menu->id]);
        }

        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
