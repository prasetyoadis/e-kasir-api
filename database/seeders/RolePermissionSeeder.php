<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => (string) Str::ulid(),
                'name' => 'owner',
                'slug' => 'owner',
                'description' => 'Can do anythink',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'admin',
                'slug' => 'admin',
                'description' => 'Can do anythink',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'kasir',
                'slug' => 'cashier',
                'description' => 'just do cashier think',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        $permissionUserAll = Permission::create([
            'name' => 'User All Access',
            'slug' => 'user.*',
            'description' => 'Punya semua hak akses untuk User',
        ]);
        $permissionOutletAll = Permission::create([
            'name' => 'Outlet All Access',
            'slug' => 'outlet.*',
            'description' => 'Punya semua hak akses untuk Outlet',
        ]);
        $permissionCategoryAll = Permission::create([
            'name' => 'Category All Access',
            'slug' => 'category.*',
            'description' => 'Punya semua hak akses untuk Category',
        ]);
        $permissionProductAll = Permission::create([
            'name' => 'Product All',
            'slug' => 'product.*',
            'description' => 'Punya semua hak akses untuk Product',
        ]);
        $permissionInventoryAll = Permission::create([
            'name' => 'Inventory All',
            'slug' => 'inventory.*',
            'description' => 'Punya semua hak akses untuk Inventory',
        ]);
        $permissionTansactionAll = Permission::create([
            'name' => 'Transaction All Access',
            'slug' => 'transaction.*',
            'description' => 'Punya semua hak akses untuk Report',
        ]);
        $permissionReportAll = Permission::create([
            'name' => 'Report All Access',
            'slug' => 'report.*',
            'description' => 'Punya semua hak akses untuk Report',
        ]);
        $permissionViewReport = Permission::create([
            'name' => 'View Report',
            'slug' => 'report.view',
            'description' => 'Melihat Data Report',
        ]);
        $permissionViewProduct = Permission::create([
            'name' => 'View Product',
            'slug' => 'product.view',
            'description' => 'Melihat Data Product',
        ]);
        $permissioCreateTransaction = Permission::create([
            'name' => 'Create New Transaction',
            'slug' => 'transaction.create',
            'description' => 'Memambahkan Data Baru Transaction',
        ]);
        $permissionUpdateTransaction = Permission::create([
            'name' => 'Update Transaction',
            'slug' => 'transaction.update',
            'description' => 'Mengubah Data Transaction',
        ]);;
        $permissionSetting = Permission::create([
            'name' => 'Setting',
            'slug' => 'setting',
            'description' => 'Dapat melakukan pengaturan',
        ]);

        DB::table('permissions')->insert([
            [
                'id' => (string) Str::ulid(),
                'name' => 'View Users',
                'slug' => 'user.view',
                'description' => 'Melihat Data Users',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Create New User',
                'slug' => 'user.create',
                'description' => 'Memambahkan Data Baru User',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Update User',
                'slug' => 'user.update',
                'description' => 'Mengubah Data User',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Delete User',
                'slug' => 'user.delete',
                'description' => 'Menghapus Data User',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'View Outlet',
                'slug' => 'outlet.view',
                'description' => 'Melihat Data Outlet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Create New Product',
                'slug' => 'product.create',
                'description' => 'Memambahkan Data Baru Product',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Update Product',
                'slug' => 'product.update',
                'description' => 'Mengubah Data Product',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Delete Product',
                'slug' => 'product.delete',
                'description' => 'Menghapus Data Product',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'View Inventory',
                'slug' => 'inventory.view',
                'description' => 'Melihat Data Inventory',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Create New Inventory',
                'slug' => 'inventory.create',
                'description' => 'Memambahkan Data Baru Inventory',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Update Inventory',
                'slug' => 'inventory.update',
                'description' => 'Mengubah Data Inventory',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Delete Inventory',
                'slug' => 'inventory.delete',
                'description' => 'Menghapus Data Inventory',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'View Transaction',
                'slug' => 'transaction.view',
                'description' => 'Melihat Data Transaction',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Delete Transaction',
                'slug' => 'transaction.delete',
                'description' => 'Menghapus Data Transaction',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Create New Report',
                'slug' => 'report.create',
                'description' => 'Memambahkan Data Baru Report',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Update Report',
                'slug' => 'report.update',
                'description' => 'Mengubah Data Report',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => (string) Str::ulid(),
                'name' => 'Delete Report',
                'slug' => 'report.delete',
                'description' => 'Menghapus Data Report',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        $roleOwner = Role::where('slug', 'owner')->first();
        $roleAdmin = Role::where('slug', 'admin')->first();
        $roleCashier = Role::where('slug', 'cashier')->first();

        $roleAdmin->permissions()->sync([
            $permissionUserAll->id,
            $permissionOutletAll->id,
            $permissionProductAll->id,
            $permissionInventoryAll->id,
            $permissionCategoryAll->id,
            $permissionTansactionAll->id,
            $permissionReportAll->id,
            $permissionSetting->id
        ]);
        $roleOwner->permissions()->sync([
            $permissionUserAll->id,
            $permissionOutletAll->id,
            $permissionProductAll->id,
            $permissionInventoryAll->id,
            $permissionCategoryAll->id,
            $permissionTansactionAll->id,
            $permissionReportAll->id,
            $permissionSetting->id
        ]);
        $roleCashier->permissions()->sync([
            $permissioCreateTransaction->id,
            $permissionUpdateTransaction->id,
            $permissionViewReport->id,
            $permissionViewProduct->id,
        ]);
    }
}
