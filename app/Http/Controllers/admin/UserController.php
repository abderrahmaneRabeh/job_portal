<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // get all users and paginate them in admin panel
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.list', ['users' => $users]);
    }

    // show edited user data in admin panel form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', ['user' => $user]);
    }

    // update edited user data in database
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            session()->flash('success', 'User updated successfully!');
            //  is a method of the session instance that stores data in the session for the next request. This data will only be available during the next HTTP request and will be deleted afterward.

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // delete user from database
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('success', 'User deleted successfully!');
        return redirect()->route('admin.users.list');
    }

}
