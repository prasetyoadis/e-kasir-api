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
        $outletSatu = Outlet::create(
            [
                'owner_id' => "a0f506b6-a8d2-4a79-b00f-910547947cae",
                'name' => 'Toko Satu',
                'address' => 'Jln Sudirman No.1, Jakarta',
                'msisdn' => '+628345356777',
                'type' => 'fnb',
                'is_active' => true,
            ],
        );
        $sub1 = Subscription::create(
            [
                'user_id' => "a0f506b6-a8d2-4a79-b00f-910547947cae",
                'subscription_type' => 1,
                'subscription_status' => 'active',
                'valid_from' => now(),
                'valid_to' => now()->addDays(30),
            ],
        );

        $sub1->outlets()->sync([$outletSatu->id]);
        $sub1->users()->sync(["a0f506b6-a8d2-4a79-b00f-910547947cae", "a0f506b7-c108-4dea-8863-880ba129dca2"]);
        $outletSatu->employees()->sync(["a0f506b7-c108-4dea-8863-880ba129dca2" => ['role_id' => "01KG6DVXJ00N6ZR77YZNYZMX4N"]]);
    }
}
