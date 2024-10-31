<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CareProviderProfile;
use App\Models\Consultation;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Display the main dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalCareProviders = CareProviderProfile::count();
        $totalConsultations = Consultation::count();
        $totalEducationalContents = EducationalContent::count();

        return view('admin.dashboard', compact('totalUsers', 'totalCareProviders', 'totalConsultations', 'totalEducationalContents'));
    }

    // Function to update the profile data
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    // Function to display all users
    public function index()
    {
        $users = User::all(); // Retrieve all users from the database
        return view('admin.users.index', compact('users'));
    }

    // Function to show the admin's profile page
    public function showProfile()
    {
        $admin = Auth::user(); // assuming you're using the Auth facade
        return view('admin.profile', compact('admin'));
    }

}
