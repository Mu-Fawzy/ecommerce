<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_products')->only('create');
        $this->middleware('permission:read_products')->only('index');
        $this->middleware('permission:update_products')->only('edit');
        $this->middleware('permission:delete_products')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where(function($q) use($request) {
            return $q->when($request->s, function($query) use($request) {
                return $query->whereTranslationLike('product_name', '%'.$request->s.'%')
                ->orWhereTranslationLike('description', '%'.$request->s.'%');
            })->when($request->cat, function($q_cat) use($request){
                return $q_cat->where('category_id', $request->cat);
            });
        })->latest()->paginate(5);

        
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // we will make categories row for products
        $categories = Category::all();
        return view('dashboard\products\create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $data = $request->except('photo');
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale.'.product_name' => ['required','min:4','string',Rule::unique('product_translations', 'product_name')]];
            $rules += [$locale.'.description' => ['required',Rule::unique('product_translations', 'description')]];
        }

        $rules += [
            'photo'             => 'sometimes|image|mimes:png,jpg',
            'purchase_price'    => 'required|numeric',
            'sale_price'        => 'required|numeric',
            'stock'             => 'sometimes|numeric'
        ];

        $this->validate($request,$rules);

        if ($request->hasFile('photo')) {
            $photo_name = $request->photo->hashName();
            Image::make($request->photo)->greyscale()->save(public_path('uploads/products/'.$photo_name), 60);
            $data['photo'] = $photo_name;
        }

        $product = Product::create($data);

        session()->flash('success', 'Product Create Successfull!');
        return redirect()->route('products.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard\products\edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // return $request;
        $data = $request->except('photo');
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale.'.product_name' => ['required','min:4','string',Rule::unique('product_translations', 'product_name')->ignore($product->id, 'product_id')]];
            $rules += [$locale.'.description' => ['required',Rule::unique('product_translations', 'description')->ignore($product->id, 'product_id')]];
        }

        $rules += [
            'photo'             => 'sometimes|image|mimes:png,jpg',
            'purchase_price'    => 'required|numeric',
            'sale_price'        => 'required|numeric',
            'stock'             => 'sometimes|numeric'
        ];

        $this->validate($request,$rules);

        if ($request->hasFile('photo')) {
            if($product->photo != 'default-product.png'){
                Storage::disk('public_uploads')->delete('products/'.$product->photo);
            }
            $photo_name = $request->photo->hashName();
            Image::make($request->photo)->greyscale()->save(public_path('uploads/products/'.$photo_name), 60);
            $data['photo'] = $photo_name;
        }

        $product->update($data);

        session()->flash('success', 'Product Updated Successfull!');
        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->photo != 'default-product.png') {
            Storage::disk('public_uploads')->delete('products/'.$product->photo);
        }
        $product->delete();

        session()->flash('success', 'Product Deleted Successfull!');
        return redirect()->route('products.index');
        
    }
}
