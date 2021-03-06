<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function login() {
        return view('user.login');
    }

//    protected function create(array $data)
//    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//        ]);
//    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function create() {
        return view('user.create');
    }
    public function show() {
        $auth = session('auth');
        $users = Users::all();
        return view('user.index', ["users"=>$users, "auth"=>$auth]);
    }
    public function edit($id) {
        $user = Users::all()->find($id);
        return view('user.edit', ['user'=>$user]);
    }
    public function editUser(Request $request, Users $user) {
//        return $this->validator($request);
        $user->update($request->all());
        return back();
    }
    public function destroy(Request $request, Users $user) {
        Users::all()->find($user)->delete();
        $auth = session('auth');
        $users = Users::all();
        return view('user.index', ["users"=>$users, "auth"=>$auth]);
    }
    public function makeNew(Request $request)
    {
        Users::create([
            'name' => $request['name'],
            'email' => $request['email'],
//            'password' => bcrypt($request['password']),
            'password' => $request['password'],
        ]);
        return back();
    }
    //
}
