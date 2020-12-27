<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CategroyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_categories')->only('create');
        $this->middleware('permission:read_categories')->only('index');
        $this->middleware('permission:update_categories')->only('edit');
        $this->middleware('permission:delete_categories')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::where(function($query) use($request) {
            return $query->when($request->s,function($q) use($request){
                return $q->whereTranslationLike('name', '%'.$request->s.'%');
            });
        })->latest()->paginate(5);
        
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale.'.name' => ['required','min:4',Rule::unique('category_translations', 'name')]];
        }
        
        $this->validate($request,$rules);

        $categories = Category::create($request->except('_token'));

        session()->flash('success', 'Category Create Successfull!');
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit' , compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //return $request;

        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale.'.name' => [
                'required',
                'min:4', 
                Rule::unique('category_translations','name')->ignore($category->id,'category_id')
                ]
            ];
        }

            
        $this->validate($request,$rules);

        $category->update($request->all());

        session()->flash('success', 'Category Updated Successfull!');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        
        $category->delete();
        session()->flash('success', 'Category Deleted Successfull!');
        return redirect()->route('categories.index');
    }
}
