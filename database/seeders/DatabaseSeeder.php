<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Subscription;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('permissions')->insert([
            [
                'id' => (string) Str::uuid(),
                'name' => 'All Access',
                'slug' => '*',
                'description' => 'Punya semua hak akses',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'User All',
                'slug' => 'user.*',
                'description' => 'Punya semua hak akses untuk User',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Role All',
                'slug' => 'role.*',
                'description' => 'Punya semua hak akses untuk Role',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Product All',
                'slug' => 'product.*',
                'description' => 'Punya semua hak akses untuk Product',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'View Users',
                'slug' => 'user.view',
                'description' => 'Melihat Data Users',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Create New User',
                'slug' => 'user.create',
                'description' => 'Memambahkan Data Baru User',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Update User',
                'slug' => 'user.update',
                'description' => 'Mengubah Data User',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Delete User',
                'slug' => 'user.delete',
                'description' => 'Menghapus Data User',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('roles')->insert([
            [
                'id' => (string) Str::uuid(),
                'name' => 'owner',
                'slug' => 'owner',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'admin',
                'slug' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'kasir',
                'slug' => 'cashier',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'manager',
                'slug' => 'manager',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('users')->insert([
            [
                'id' => (string) Str::uuid(),
                'name' => 'Owner Kasir',
                'username' => 'ownerkasir',
                'email' => 'ownerkasir@gmail.com',
                'msisdn' => '+6281113334445',
                'password' => Hash::make("ownerkasir"),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Admin Kasir',
                'username' => 'adminkasir',
                'email' => 'adminkasir@gmail.com',
                'msisdn' => '+6281133445566',
                'password' => Hash::make("adminkasir"),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Petugas Kasir',
                'username' => 'petugaskasir',
                'email' => 'petugaskasir@gmail.com',
                'msisdn' => '+6281345678899',
                'password' => Hash::make("petugaskasir"),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
        $user1 = User::where('username', 'ownerkasir')->first();
        $user2 = User::where('username', 'adminkasir')->first();
        $user3 = User::where('username', 'petugaskasir')->first();

        Subscription::create(
            [
                'user_id' => $user1->id,
                'subscription_type' => 1,
                'subscription_status' => 'active',
                'valid_from' => now(),
                'valid_to' => now()->addDays(30),
            ],
        );
        Subscription::create(
            [
                'user_id' => $user1->id,
                'subscription_type' => 1,
                'subscription_status' => 'active',
                'valid_from' => now(),
                'valid_to' => now()->addDays(30),
            ],
        );

        Outlet::create(
            [
                'owner_id' => $user1->id,
                'name' => 'Toko Satu',
                'address' => 'Jln Sudirman No.1, Jakarta',
                'msisdn' => '+628345356777',
                'is_active' => true,
            ],
        );
        Outlet::create(
            [
                'owner_id' => $user1->id,
                'name' => 'Toko Dua',
                'address' => 'Jln Ahmad Yani No.1, Jakarta',
                'msisdn' => '+628345356667',
                'is_active' => true,
            ],
        );
        $role1 = Role::where('slug', 'owner')->first();
        $role2 = Role::where('slug', 'admin')->first();
        $role3 = Role::where('slug', 'cashier')->first();
        $role4 = Role::where('slug', 'manager')->first();
        
        $user1->roles()->sync([$role1->id]);
        $user2->roles()->sync([$role2->id]);
        $user3->roles()->sync([$role3->id]);
        
        $permission1 = Permission::where('slug', '*')->first();
        $permission2 = Permission::where('slug', 'user.*')->first();
        $permission4 = Permission::where('slug', 'product.*')->first();
        $permission5 = Permission::where('slug', 'user.view')->first();
        
        $role1->permissions()->sync([$permission1->id]);
        $role2->permissions()->sync([$permission2->id,$permission4->id,$permission5->id]);
        $role3->permissions()->sync([$permission4->id]);
        $role4->permissions()->sync([$permission2->id]);
        
        $sub = Subscription::all();
        $outlet1 = Outlet::where('msisdn', '+628345356777')->first();
        $outlet2 = Outlet::where('msisdn', '+628345356667')->first();

        $sub[0]->outlets()->sync([$outlet1->id]);
        $sub[1]->outlets()->sync([$outlet2->id]);
        $sub[0]->users()->sync([$user1->id,$user2->id,$user3->id]);
        $sub[1]->users()->sync([$user1->id]);
    }
}
