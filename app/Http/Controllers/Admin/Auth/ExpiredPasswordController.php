<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordExpiredRequest;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ExpiredPasswordController extends Controller
{
    public function expired()
    {
        return Inertia::render('Auth/PasswordExpired');
    }

    public function postExpired(PasswordExpiredRequest $request)
    {
        // Check current password
        if ( !Hash::check($request->current_password, $request->user()->password) ) {
            return redirect()->back()->withErrors([
                'current_password' => 'A senha actual está incorrecta!'
            ]);
        }

        $request->user()->update([
            'password' => bcrypt($request->password),
            'password_changed_at' => now()->toDateTimeString(),
            'password_changed_by_user' => 1
        ]);

        return redirect()->to('/dashboard');
    }
}
