<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        # Get data product dengan limit paginate 10.
        $categories = Category::paginate(10);
        
        return $this->successPaginated(
            message: 'Products retrieved successfully',
            data: CategoryResource::collection($categories),
            paginator: $categories
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        $dataValid = $request->validated();

        $category = Category::create($dataValid);

        return $this->successCreateData(
            message: 'Category created successfully',
            data: new CategoryResource($category)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return $this->successGetData(
            message: 'Request processed successfully',
            data: new CategoryResource($category)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $dataValid = $request->validated();

        $category->update($dataValid);

        return $this->successUpdateData(
            message: 'Category updated successfully',
            id: $category->id
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
