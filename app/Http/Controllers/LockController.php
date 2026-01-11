<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:passkey-lock'], ['only' => ['PasskeyPage']]);
        $this->middleware(['permission:user-logs'], ['only' => ['LogPage']]);
    }
    // passkey page
    public function PasskeyPage()
    {
        return view("Backend.Pages.Passkey.Passkey-Page");
    }
    // logs page
    public function LogPage()
    {
        return view("Backend.Pages.Logs.Logs-Page");
    }
}
