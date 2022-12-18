<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Session;
use Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('id',auth()->user()->id)->get();
        return view('admin.profile.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([ 
            'name'              => 'required|min:3',
            'email'             => 'required|unique:users,email,'.$id,
            'phone'             => 'required|digits:10|unique:users,phone,'.$id,
        ],
        [
            'name.required'         => 'Name field is required',
            'name.min'              => 'Name field is must be atleast 6 characters',
            'email.required'        => 'Email field is required',
            'email.unique'          => 'Email field is already taken',
            'phone.required'        => 'Phone field is required',
            'phone.digits'          => 'Phone field is must be a 10 digits',
            'phone.unique'          => 'Phone field is already taken',
        ]);

        $res = User::where('id',$id)->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);
        $user_email = auth()->user()->email;
        if($request->email!=null && $request->email!= $user_email){
            User::where('id',$id)->update([
                'email'  => $request->email,
            ]);
            Session::flush();
            return redirect()->route('login');
        }

        if($request->old_password!=null || $request->new_password!=null || $request->confirm_password!=null){
            $request->validate([ 
                'old_password'      => 'required',
                'new_password'      => 'required|min:6',
                'confirm_password'  => 'required|same:new_password'
            ],
            [
                'old_password.required'     => 'Old Password field is required',
                'new_password.required'     => 'New Password field is required',
                'new_password.min'          => 'New Password field is must be atleast 6 characters',
                'confirm_password.required' => 'Confirm Password field is required',
                'confirm_password.same'     => 'Password do not match',
            ]);
            if(Hash::check($request->old_password, auth()->user()->password)){
                User::where('id',$id)->update([
                    'password'  => Hash::make($request->new_password),
                ]);
                Session::flush();
                return redirect()->route('login');
            }else{
                flash()->addError('Oops! Invalid Old Password.');
                return redirect()->back();
            }
        }
        flash()->addSuccess('Profile Updated Successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
