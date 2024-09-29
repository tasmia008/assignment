<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    
    public function index()
    {
        return response()->json([
            'msg' => 'Backend Connected',
        ]);
    }

    public function subAdminInfo(){
        $subadmins = Role::where('role', 2)->get();

        return response()->json([
            'subadmins' => $subadmins
        ]);
    }
    public function allUserInfo(){
        $users = Role::where('role', 3)->get();

        return response()->json([
            'users' => $users
        ]);
    }

    public function updateuserinfo(Request $request ,$userId)
    {
        
        $updateuser = Role::find($userId);
        $updateuser->status = $request->status;
        $updateuser->save();

        return response()->json([
            'message' => 'User status updated successfully',
            'updateuser' => $updateuser
        ]);

    }
    public function destroy($userId)
    {
        $deleteuser = Role::findOrFail($userId);
        $deleteuser->delete();

        return response()->json([
            'message' => 'User  deleted successfully',
            'deleteuser' => $deleteuser
        ]);
    }

    public function createSubadmin(Request $request)
    {
        $subadmin = new Role();

        $subadmin->username = $request->username;
        $subadmin->password = $request->password;
        $subadmin->status = "subadmin";
        $subadmin->role = 2;

        try {
            $subadmin->save();
            return response()->json([
                'message' => 'Sub Admin registered successfully',
                'subadmin' => $subadmin
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Sub Admin registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createUser(Request $request)
    {
        $user = new Role();

        $user->username = $request->username;
        $user->password = $request->password;
        $user->status = "pending";
        $user->role = 3;

        try {
            $user->save();
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getUserInfo($userId)  {

  
    $user = Role::find($userId) ;

        return response()->json([
            "user"=>$user 
        ]) ;

        }
    public function login(Request $request)
    {
        $user = Role::where('username', $request->username)->first();

        if (!$user) {
            return response()->json([
                'msg' => 'User not found',
            ]);
        }

        return response()->json([
            'msg' => 'success',
            'id' => $user->id,
            'role' => $user->role,
        ]);
    }
}
