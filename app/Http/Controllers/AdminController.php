<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $templates = Template::all();
        return view('admin.dashboard', compact('templates'));
    }

    public function storeTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'overlay_image' => 'required|image|mimes:png|max:2048',
        ]);

        $path = $request->file('overlay_image')->store('templates', 'public');

        Template::create([
            'name' => $request->name,
            'overlay_image_path' => $path,
            'status_aktif' => true,
        ]);

        return back()->with('success', 'Template added successfully!');
    }

    public function destroyTemplate(Template $template)
    {
        Storage::disk('public')->delete($template->overlay_image_path);
        $template->delete();

        return back()->with('success', 'Template deleted successfully!');
    }
}
