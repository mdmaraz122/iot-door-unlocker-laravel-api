<?php

namespace App\Http\Controllers;

use App\Helpers\GetUserID;
use App\Helpers\JWTToken;
use App\Helpers\ResponseHelper;
use App\Models\Lock;
use App\Models\LockLog;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        // examples:
       $this->middleware(['permission:user-list'], ['only' => ['UserPageView']]);
    }

    // Login Page View
    public function loginPageView()
    {
        return view("Backend.Pages.Auth.Login-Page");
    }

    // user index
    public function UserPageView(Request $request){
        // check cookie token
        $token = $request->cookie('BackendLogin');
        if (!$token) {
            return redirect(route('backend.login'));
        } else {
            $user = JWTToken::ReadToken($token);
            if (!$user) {
                return redirect(route('backend.login'));
            } else {
                $id = $user->userID;
                $user = User::find($id);
                $roles = Role::all();
                return view("Backend.Pages.Users.User-Page", compact('user', 'roles'));
            }
        }
    }

    // Auth - Login
    public function UserLogin(Request $request){
        try {
            $request->validate([
                'phone' => 'required',
                'password' => 'required'
            ]);
            // check user exists by username
            $user = User::where('phone', '=', $request->input('phone'))->first();
            // return error if user not found
            if (!$user) {
                return ResponseHelper::Out('error', 'Mobile Number & password does not matched ', null, 200);
            } else {
                // check hash password
                if (Hash::check($request->input('password'), $user->password)) {
                    if ($user->status == 'Inactive') {
                        return ResponseHelper::Out('error', 'Your account is Inactive', null, 200);
                    }else if ($user->status == 'Banned') {
                        return ResponseHelper::Out('error', 'Your account is Banned', null, 200);
                    }else {
                        $token = JWTToken::CreateToken($user->id, $user->email);
                        return ResponseHelper::Out('success', 'Login successful', $token, 200)->cookie('BackendLogin', $token, 60 * 24 * 30);
                    }
                } else {
                    return ResponseHelper::Out('error', 'Invalid email or password', null, 200);
                }
            }
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', 'Invalid email or password', null, 200);
        }
    }

    // Get Users
    public function getUsers()
    {
        try {
            $users = User::all();
            return ResponseHelper::Out('success', 'Users fetched', $users, 200);
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }

    // Create User
    public function createUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'required',
                'passkey' => 'required',
                'status' => 'required',
                'roleId' => 'required'
            ]);
            if (User::where('email', '=', $request->input('email'))->first()) {
                return ResponseHelper::Out('error', 'Email already exist', null, 200);
            } else {
                $user = new User();
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->phone = $request->input('phone');
                $user->password = Hash::make($request->input('password'));
                $user->pass_key = Hash::make($request->input('passkey'));
                $user->status = $request->input('status');
                $user->save();
                $role = Role::whereIn('id', $request->input('roleId'))->pluck('name');
                $user->assignRole($role);

                return ResponseHelper::Out('success', 'User created successfully', $user, 200);
            }
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }

    // user log out
    public function UserLogout(Request $request)
    {
        try {
            // Forget the cookie
            $cookie = cookie()->forget('BackendLogin'); // This will properly remove the cookie
            // Redirect to login page
            return redirect(route('backend.login'))->withCookie($cookie); // Pass the forgotten cookie with the response
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }

    // Get User By Id
    public function getUserById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            $user = User::find($request->input('id'));
            return ResponseHelper::Out('success', 'User fetched', $user, 200);
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // User Profile
    public function UserProfile(Request $request)
    {
        try {
            $token = $request->cookie('BackendLogin');
            if (!$token) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $userData = JWTToken::ReadToken($token);
            if (!$userData) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $user = User::find($userData->userID);
            return ResponseHelper::Out('success', 'User profile fetched', $user, 200);
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }

    // update user profile
    public function UpdateUserProfile(Request $request){
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'nullable',
            ]);
            $token = $request->cookie('BackendLogin');
            if (!$token) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $userData = JWTToken::ReadToken($token);
            if (!$userData) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $user = User::find($userData->userID);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->save();
            return ResponseHelper::Out('success', 'Profile update successfully', null, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }

    // change password
    public function ChangePassword(Request $request){
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required',
            ]);
            $token = $request->cookie('BackendLogin');
            if (!$token) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $userData = JWTToken::ReadToken($token);
            if (!$userData) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $user = User::find($userData->userID);
            // check old password
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return ResponseHelper::Out('error', 'Old password is incorrect', null, 200);
            }
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
            return ResponseHelper::Out('success', 'Password changed successfully', null, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }
    // update passkey
    public function ChangePasskey(Request $request){
        try {
            $request->validate([
                'current_passkey' => 'required',
                'new_passkey' => 'required',
            ]);
            $token = $request->cookie('BackendLogin');
            if (!$token) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $userData = JWTToken::ReadToken($token);
            if (!$userData) {
                return ResponseHelper::Out('error', 'Unauthorized', null, 401);
            }
            $user = User::find($userData->userID);
            // check old passkey
            if (!Hash::check($request->input('current_passkey'), $user->pass_key)) {
                return ResponseHelper::Out('error', 'Old passkey is incorrect', null, 200);
            }
            $user->pass_key = Hash::make($request->input('new_passkey'));
            $user->save();
            return ResponseHelper::Out('success', 'Passkey changed successfully', null, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }

    // Get Model Has Role By Id
    public function getUserRolesById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer', // Ensure the ID is provided and valid
            ]);

            $user = User::findOrFail($request->input('id')); // Get the user by ID
            $roles = $user->getRoleNames(); // Get roles assigned to the user

            // Return roles data in the response
            return ResponseHelper::Out('success', 'Roles fetched successfully', $roles, 200);
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }

    // Update User
    public function updateUser(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'nullable',
                'passkey' => 'nullable',
                'status' => 'required',
                'roleId' => 'required'
            ]);
            // check user exits or not
            $user = User::find($request->input('id'));
            if(!$user){
                return ResponseHelper::Out('error', 'User not found', null, 200);
            }
            // check email already exists or not
            $existingUser = User::where('email', '=', $request->input('email'))->where('id', '!=', $request->input('id'))->first();
            if ($existingUser) {
                return ResponseHelper::Out('error', 'Email already exist', null, 200);
            }
            // check phone already exists or not
            $existingUserPhone = User::where('phone', '=', $request->input('phone'))->where('id', '!=', $request->input('id'))->first();
            if ($existingUserPhone) {
                return ResponseHelper::Out('error', 'Phone already exist', null, 200);
            }
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->phone = $request->input('phone');
                if($request->input('password') !== ''){
                    $user->password = Hash::make($request->input('password'));
                }
                if($request->input('passkey') !== ''){
                    $user->pass_key = Hash::make($request->input('passkey'));
                }
                $user->status = $request->input('status');
                $user->save();
            // Sync roles
            $user->syncRoles($request->input('roleId'));
                return ResponseHelper::Out('success', 'User updated successfully', $user, 200);

        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }

    // delete-permission-by-id
    public function UserDeleteById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            $user = User::where('id', '=', $request->input('id'))->first();
            if ($user) {
                $user->delete();
                return ResponseHelper::Out('success', 'User deleted successfully', null, 200);
            } else {
                return ResponseHelper::Out('error', 'User not found', null, 200);
            }
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }



    public function Passkey(Request $request)
    {
        try {
            $request->validate([
                'passkey' => 'required',
            ]);

            $user_id = GetUserID::user_id($request->cookie('BackendLogin'));
            $user = User::where('id', $user_id)->first();
            // check passkey matches it's hash
            if (!Hash::check($request->input('passkey'), $user->pass_key)) {
                return ResponseHelper::Out('error', 'Invalid Passkey', null, 200);
            }else{
               $serverIp = Setting::where('id', 1)->first()->ip_address;
               if($request->ip() != $serverIp){
                   return ResponseHelper::Out('error', 'Unauthorized IP Address', null, 200);
               }
               // if status is Inactive or Banned return error
                if($user->status == 'Inactive'){
                    return ResponseHelper::Out('error', 'Your account is Inactive', null, 200);
                }else if($user->status == 'Banned'){
                    return ResponseHelper::Out('error', 'Your account is Banned', null, 200);
                }

                // if verified passkey, update database.
                $Database = Lock::where('id', 1)->first();
                $Database->status = 'success';
                $Database->action = 'unlock';
                $Database->save();
                // update log
                $log = LockLog::create([
                    'user_id' => $user->id,
                    'action' => 'unlock',
                    'status' => 'success',
                    'ip_address' => $request->ip(),
                ]);
            }
            return ResponseHelper::Out('success', 'Successfully', null, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }

    // Unlock Logs
    public function UnlockLogs(Request $request){
        try {
            $request->validate([
                'user_id' => 'required|integer',
            ]);
            // get logs by user id
            $logs = LockLog::where('user_id', $request->input('user_id'))->with('user')->get();
            // return response
            return ResponseHelper::Out('success', 'Logs fetched successfully', $logs, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }
    // Door Status
    public function doorStatus(Request $request)
    {
        try {
            // 1. Validate passkey
            $request->validate([
                'passkey' => 'required',
            ]);

            $pass = Setting::where('id', 1)->value('key');

            if ($request->passkey !== $pass) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid passkey'
                ], 401);
            }

            // 2. Get lock
            $lock = Lock::findOrFail(1);

            // 3. Calculate time difference (seconds)
            $diffSeconds = now()->diffInSeconds($lock->updated_at);

            // 4. Default action
            $action = $lock->action;

            // 5. If action is unlock AND older than 5 seconds → force lock
            if ($lock->action === 'unlock' && $diffSeconds >= 5) {
                $lock->action = 'lock';
                $lock->save();

                $action = 'lock';
            }

            // 6. Return response
            return ResponseHelper::Out(
                'success',
                'Lock Status',
                [
                    'status' => $lock->status,
                    'action' => $action,
                    'age'    => $diffSeconds, // optional (for debugging)
                ],
                200
            );

        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }

    // Clear Cache
    public function ClearCache(Request $request)
    {
        try {
            Artisan::call('optimize:clear');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            return ResponseHelper::Out('success', 'Cache cleared successfully', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 500);
        }
    }


}
