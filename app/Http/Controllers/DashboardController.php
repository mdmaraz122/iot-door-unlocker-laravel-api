<?php

namespace App\Http\Controllers;

use App\Helpers\JWTToken;
use App\Models\LockLog;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    // user index
    public function index(Request $request){
        // check cookie token
        $token = $request->cookie('BackendLogin');
        if(!$token){
            return redirect(route('backend.login'));
        }else{
            $user = JWTToken::ReadToken($token);
            if(!$user){
                return redirect(route('backend.login'));
            }else{
                $id = $user->userID;
                $user = user::find($id);
                // total users
                $total_users = User::count();
                // total unlock today
                $total_unlock = LockLog::whereDate('created_at', now()->toDateString())->count();
                return view("Backend.Pages.Dashboard.Dashboard-Page", compact('user', 'total_users', 'total_unlock'));
            }
        }
    }
    // user profile page
    public function profilePageView(Request $request){
        // check cookie token
        $token = $request->cookie('BackendLogin');
        if(!$token){
            return redirect(route('backend.login'));
        }else{
            // read token
            $user = JWTToken::ReadToken($token);
            // check user
            if(!$user){
                return redirect(route('backend.login'));
            }else{
                // get user info
                $id = $user->userID;
                $user = user::find($id);
                return view("Backend.Pages.Profile.Profile-Page", compact('user'));
            }
        }
    }
}
