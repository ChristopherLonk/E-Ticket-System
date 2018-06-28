<?php

use Illuminate\Database\Seeder;
use App\Tools;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin'),
            'ext_id' => Tools::randomByte(),
        ]);
        DB::table('roles')->insert([
            'name' => 'user',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
        ]);
        DB::table('roles')->insert([
            'name' => 'teamleader',
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 2,
        ]);
        DB::table('permissions')->insert([
            'name' => 'create_user',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_user',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_user',
        ]);
        DB::table('permissions')->insert([
            'name' => 'create_project',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_project',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_project',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create_sprint',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_sprint',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_sprint',
        ]);

        DB::table('permissions')->insert([
            'name' => 'create_ticket',
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit_ticket',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete_ticket',
        ]);

        DB::table('permissions')->insert([
            'name' => 'edit_ticket_status',
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 1,
            'role_id' => 2,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 2,
            'role_id' => 2,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 3,
            'role_id' => 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 4,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 5,
            'role_id' => 3,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 6,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 7,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 8,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 9,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 10,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 11,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 12,
            'role_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'permission_id' => 13,
            'role_id' => 1,
        ]);
    }

}
