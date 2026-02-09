<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $outletSatu = Outlet::create(
        //     [
        //         'owner_id' => "a1096730-b723-4542-91af-983dcd04c409",
        //         'name' => 'Toko Satu',
        //         'address' => 'Jln Sudirman No.1, Jakarta',
        //         'msisdn' => '+628345356777',
        //         'type' => 'fnb',
        //         'is_active' => true,
        //     ],
        // );
        // $sub1 = Subscription::create(
        //     [
        //         'user_id' => "a1096730-b723-4542-91af-983dcd04c409",
        //         'subscription_type' => 1,
        //         'subscription_status' => 'active',
        //         'valid_from' => now(),
        //         'valid_to' => now()->addDays(7),
        //     ],
        // );
        $outletSatu = Outlet::where('owner_id', "a1096730-b723-4542-91af-983dcd04c409")->first();
        // $sub1->outlets()->sync([$outletSatu->id]);
        // $sub1->users()->sync(["a1096730-b723-4542-91af-983dcd04c409", "a1096731-23e6-4794-bafb-17b3960809fb", "a1096731-7c58-4f72-a8b1-2aab447d9051"]);
        $outletSatu->employees()->sync([
            "a1096731-23e6-4794-bafb-17b3960809fb" => ['role_id' => "01KH0GG372S9PKRCKC6BR6YCV5"],
            "a1096731-7c58-4f72-a8b1-2aab447d9051" => ['role_id' => "01KH0GG372S9PKRCKC6BR6YCV6"]
        ]);
    }
}
