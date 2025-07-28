<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\murid; // Adjust this to your Student model

class ProfileController extends Controller
{
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch student data using the NIS from the authenticated user
        $murid = Murid::where('username_user', $user->username)->first();


        // If no student data is found, redirect with an error
        if (!$murid) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Pass the student data to the profile view
        return view('show', compact('murid'));
    }
}
