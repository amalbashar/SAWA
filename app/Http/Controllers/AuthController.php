<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CareProviderProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

//فورم التسجيل تاع اليوزر
    public function showUserRegistrationForm()
    {
        return view('auth.register-user');
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $roleId = 2;

        // كرييت يوزر
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId,
        ]);


//بسوي لوق ان لحالو بعد ما يسجل
        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

//فورم التسجيل تاع الكيربروفايدر
    public function showCareProviderRegistrationForm()
    {
        return view('auth.register-careprovider');
    }



    public function registerCareProvider(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'clinic_address' => 'nullable|string|max:255',
        ]);

        $data['offers_home_services'] = $request->has('offers_home_services') ? true : false;

        $roleId = 3;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId,
        ]);

        CareProviderProfile::create([
            'user_id' => $user->id,
            'specialization' => $data['specialization'],
            'bio' => $data['bio'],
            'offers_home_services' => $data['offers_home_services'],
            'clinic_address' => $data['clinic_address'],
        ]);

        Auth::login($user);

        return redirect()->route('careprovider.dashboard');
    }


//هاد بس للوق ان فورم
    public function showLoginForm()
{
    return view('auth.login');
}


//---------

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        if (Auth::user()->role_id == 2) {
            return redirect()->intended('user/dashboard');
        } elseif (Auth::user()->role_id == 3) {
            return redirect()->intended('careprovider/dashboard');
        } elseif (Auth::user()->role_id == 1) {
            return redirect()->intended('admin/dashboard');
        }
        elseif (Auth::user()->role_id == 4) {
            return redirect()->intended('superadmin/dashboard');
        }

    }
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
}


}
