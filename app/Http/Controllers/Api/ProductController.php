<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Services\Product\CreateProductService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        # Get data product dengan limit paginate 10.
        $products = Product::paginate(10);
        
        return $this->successPaginated(
            message: 'Products retrieved successfully',
            data: ProductResource::collection($products),
            paginator: $products
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, CreateProductService $createProduct)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('sub');

        $dataValid = $request->validated();

        # Execute CreateProductService (create new product, assign category, assign images, assign variants)
        $product = $createProduct->execute(
            data: $dataValid,
            userId: $userId
        );

        return $this->successCreateData(
            message: 'Product created successfully',
            data: new ProductResource($product)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->loadMissing(['categories', 'variants', 'images']);
        
        return $this->successGetData(
            message: 'Request processed successfully',
            data: new ProductResource($product)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
