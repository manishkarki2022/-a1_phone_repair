<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductSpecification;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category', 'primaryImage'])->latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        return view('backend.products.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'sku' => 'required|string|max:100|unique:products',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'condition' => 'required|in:new,used,refurbished',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'specifications.*.spec_name' => 'required|string|max:255',
            'specifications.*.spec_value' => 'required|string',
            'specifications.*.spec_group' => 'nullable|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_texts' => 'nullable|array',
            'alt_texts.*' => 'nullable|string|max:255',
            'primary_image_index' => 'nullable|integer'
        ]);

        $product = Product::create($validated);

        // Handle specifications
        if (!empty($validated['specifications'])) {
            foreach ($validated['specifications'] as $spec) {
                $product->specifications()->create($spec);
            }
        }

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                $isPrimary = ($request->primary_image_index == $index);

                $product->images()->create([
                    'image_path' => $path,
                    'alt_text' => $validated['alt_texts'][$index] ?? null,
                    'is_primary' => $isPrimary
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }



    public function edit(Product $product)
    {
        $brands = Brand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        $product->load(['specifications', 'images']);
        return view('backend.products.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'sku' => 'required|string|max:100|unique:products,sku,'.$product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'condition' => 'required|in:new,used,refurbished',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'specifications.*.id' => 'nullable|exists:product_specifications,id,product_id,'.$product->id,
            'specifications.*.spec_name' => 'required|string|max:255',
            'specifications.*.spec_value' => 'required|string',
            'specifications.*.spec_group' => 'nullable|string|max:255',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_texts' => 'nullable|array',
            'alt_texts.*' => 'nullable|string|max:255',
            'primary_image_id' => 'nullable|exists:product_images,id,product_id,'.$product->id,
            'deleted_image_ids' => 'nullable|array',
            'deleted_image_ids.*' => 'exists:product_images,id,product_id,'.$product->id
        ]);

        $product->update($validated);

        // Handle specifications
        $existingSpecIds = $product->specifications()->pluck('id')->toArray();
        $updatedSpecIds = [];

        if (!empty($validated['specifications'])) {
            foreach ($validated['specifications'] as $spec) {
                if (isset($spec['id'])) {
                    $product->specifications()->where('id', $spec['id'])->update($spec);
                    $updatedSpecIds[] = $spec['id'];
                } else {
                    $newSpec = $product->specifications()->create($spec);
                    $updatedSpecIds[] = $newSpec->id;
                }
            }
        }

        // Delete specs that weren't included in the update
        $specsToDelete = array_diff($existingSpecIds, $updatedSpecIds);
        if (!empty($specsToDelete)) {
            $product->specifications()->whereIn('id', $specsToDelete)->delete();
        }

        // Handle image deletions
        if (!empty($validated['deleted_image_ids'])) {
            foreach ($validated['deleted_image_ids'] as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        // Handle new images
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $index => $image) {
                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'alt_text' => $validated['alt_texts'][$index] ?? null,
                    'is_primary' => false
                ]);
            }
        }

        // Handle primary image
        if ($validated['primary_image_id']) {
            $product->images()->update(['is_primary' => false]);
            $product->images()->where('id', $validated['primary_image_id'])->update(['is_primary' => true]);
        }

        return redirect()->route('backend.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
