<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\CareProviderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function loginUser(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        if ($user->role_id == 2) { // تأكدي أن `role_id` هو 2 للمستخدم العادي
            return redirect()->route('user.dashboard');
        }
    }

    return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
}


public function loginProvider(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        if ($user->role_id == 3) { // تأكدي أن `role_id` هو 3 لمقدم الرعاية
            return redirect()->route('careprovider.dashboard');
        }
    }

    return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
}

public function loginAdmin(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        if ($user->role_id == 1) { // تأكدي أن `role_id` هو 1 للمشرف
            return redirect()->route('admin.dashboard');
        }
    }

    return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
}



public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->to(url()->previous());
}
}
