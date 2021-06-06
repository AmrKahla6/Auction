<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
      $this->middleware(['permission:read_users'])->only('index');

      $this->middleware(['permission:create_users'])->only('create');

      $this->middleware(['permission:update_users'])->only('edit');

      $this->middleware(['permission:delete_users'])->only('destroy');
    }//end of construct

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
           $data['users'] = User::when($request->search , function ($q) use ($request){
              return $q->where('name' , 'like' , '%'. $request->search. '%')
              ->orWhere('email' , 'like' , '%'. $request->search. '%');
          })->latest()->paginate(5);

        return view('dashboard.users.index')->with($data);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'email'       => 'required|unique:users',
            'image'       => 'nullable',
            'password'    => 'required|confirmed',
            'permissions' => 'required|min:1',
            ]);
            $data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
            $data['password'] = bcrypt($request->password);

            if ($request->image) {
                Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                    ->save(public_path('uploads/user_images/' . $request->image->hashName()));
                $data['image'] = $request->image->hashName();
             }else{
                $data['image'] = 'default.png';
             }

        $user = User::create($data);

        $user->attachRole('admin');

        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.users.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $request->validate([
            'name'        => 'required',
            'email'       => ['required', Rule::unique('users')->ignore($user->id)],
            'image'       => 'image',
            'permissions' => 'required|min:1',

        ]);
        $data = $request->except(['permissions', 'image']);

        if ($request->image) {

            if ($user->image != 'default.png') {
                Storage::disk('uploads')->delete('/user_images/' . $user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }

        $user->update($data);
        $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.updated_successfully'));
        return redirect(route('dashboard.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('uploads')->delete('/dashboard/users/' . $user->image);
        }

        $user->delete();

        session()->flash('success', 'تم الحذف بنجاح');

        return redirect()->route('dashboard.users.index');
    }
}
