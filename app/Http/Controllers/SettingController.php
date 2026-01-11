<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:passkey-lock'], ['only' => ['SettingPage']]);
    }
    public function SettingPage()
    {
        return view("Backend.Pages.Settings.Settings-Page");
    }
    // get settings
    public function GetSettings()
    {
        try {
            $setting = Setting::all();
            return ResponseHelper::Out('success', 'Setting fetched successfully', $setting, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
    // update settings
    public function UpdateSettings(Request $request)
    {
        try {
            $request->validate([
                'key' => 'required',
                'ip_address' => 'required',
            ]);
            $setting = Setting::where('id', 1)->first();
            $setting->key = $request->input('key');
            $setting->ip_address = $request->input('ip_address');
            $setting->save();
            return ResponseHelper::Out('success', 'Setting updated successfully', $setting, 200);
        }catch (\Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), null, 200);
        }
    }
}
