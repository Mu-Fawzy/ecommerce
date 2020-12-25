<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:create_users')->only('create');
        $this->middleware('permission:read_users')->only('index');
        $this->middleware('permission:update_users')->only('edit');
        $this->middleware('permission:delete_users')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->where(function($query) use($request) {
            return $query->when($request->s,function($q) use($request){
                return $q->where('first_name','like', '%'.$request->s.'%')
                ->orWhere('last_name','like', '%'.$request->s.'%')
                ->orWhere('email','like', '%'.$request->s.'%');
            });
        })->latest()->paginate(5);
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|min:4',
            'last_name' => 'required|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'photo' => 'image|mimes:png,jpg',
            'permissions' => 'array',
        ]);

        $data = $request->except('password_confirmation','photo','permissions');
        
        if($request->hasFile('photo'))
        {
            $image_name = $request->photo->hashName();
            $img = Image::make($request->photo)->resize(null, 62, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/'.$image_name), 80);
            $data['photo'] = $image_name;
        }

        $user = User::create($data);

        $user->attachRole('admin');


        if($request->has('permissions'))
        {
            $user->syncPermissions($request->permissions);
        }

        session()->flash('success', 'User Create Successfull!');
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        return view('dashboard.users.edit' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        //return $request;
        $this->validate($request,[
            'first_name' => 'required|min:4',
            'last_name' => 'required|min:4',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|confirmed',
            'photo' => 'image|mimes:png,jpg',
            'permissions' => 'array',
        ]);

        $data = $request->except('password','password_confirmation','photo','permissions');
        
        if($request->hasFile('photo'))
        {
            if ($user->photo != 'avatar.png') {
                Storage::disk('public_uploads')->delete('users/'. $user->photo);
            }
            $image_name = $request->photo->hashName();
            $img = Image::make($request->photo)->resize(null, 62, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/'.$image_name), 80);
            $data['photo'] = $image_name;
        }

        //password
        if($request->has('password') && $request->password != null)
        {
            $data['password'] = $request->password;
        }

        $user->update($data);

        if($request->has('permissions'))
        {
            $user->syncPermissions($request->permissions);
        }else {
            $user->detachPermissions($request->permissions);
        }

        session()->flash('success', 'User Updated Successfull!');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        if ($user->photo != 'avatar.png') {
            Storage::disk('public_uploads')->delete('users/'. $user->photo);
        }
        $user->delete();
        session()->flash('success', 'User Deleted Successfull!');
        return redirect()->route('users.index');
    }
}
