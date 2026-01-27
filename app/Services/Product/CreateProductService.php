<?php

namespace App\Services\Product;

use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateProductService
{
    public function execute(array $data, string $userId): Product
    {
        $uploadedPaths = [];
        $outletId = Cache::get("active_outlet:user:{$userId}");

        try {
            return DB::transaction(function () use ($data, $outletId, &$uploadedPaths) {
                # Create data table Prduct.
                $product = Product::create($data);
                
                # Assign category
                if (!empty($data['categories'])) $product->categories()->sync($data['categories']);

                # Assign images
                if (!empty($data['images'])) $this->storeImage($product, $data['images'], $uploadedPaths);

                # Assign variant
                $variants = !empty($data['variants'])
                                ? $this->storeVariant($product, $data['variants'])
                                : collect([$this->storeDefaultVariant($product)]);

                # Create Inventory product
                $this->createInventoryItems($variants, $outletId);

                return $product->loadMissing(['categories', 'variants', 'images']);
            });
        } catch (\Throwable $th) {
            # roleback jika gagal simpan DB file yang sudah di upload dihapus
            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $th;
        }
    }

    private function storeImage(Product $product, array $images, array &$uploadedPaths): void
    {
        # code...
        $imagesPayload = [];
        # upload file
        foreach ($images as $index => $image) {
            $filename = Str::uuid() . '.' . $image['file']->extension();
            $path = $image['file']->storeAs(
                'products/' . now()->format('Y/m'),
                $filename,
                'public'
            );

            $uploadedPaths[] = $path;

            # Prepare payload
            $imagesPayload[] = [
                'product_id' => $product->id,
                'url' => $path,
                'alt' => $image['alt'] ?? null,
                'is_default' => $index === 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        # code...
        ProductImage::insert($imagesPayload);
    }
    
    private function storeVariant(Product $product, array $variants)
    {
        $productVariants = collect($variants)->map(
            fn ($variant) => [
                'product_id' => $product->id,
                'variant_name' => $variant['variant_name'],
                'description' => $variant['description'] ?? null,
                'price' => $variant['price'],
                'is_active' => $variant['is_active'] ?? true,
                'is_variant' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        )->all();

        # code...
        return $product->variants()->createMany($productVariants);
    }

    private function storeDefaultVariant(Product $product): ProductVariant
    {
        return ProductVariant::create([
            'product_id'   => $product->id,
            'variant_name' => 'Reguler',
            'description'  => 'Default variant',
            'price'        => $product->base_price,
            'is_active'    => true,
            'is_variant'   => false,
        ]);
    }

    private function createInventoryItems(Collection $variants, string $outletId)
    {
        if ($variants->isEmpty()) return;
        if (!$outletId) throw new \RuntimeException('Active outlet not set');

        $now = now();

        $inventoryPayload = $variants->map(
            fn ($variant) => [
                'product_variant_id' => $variant->id,
                'outlet_id'          => $outletId,
                'current_stock'      => 0,
                'min_stock'          => 0,
                'created_at'         => $now,
                'updated_at'         => $now,
            ]
        );

        InventoryItem::insert($inventoryPayload);
    }
}