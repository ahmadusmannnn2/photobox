<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Package;
use Illuminate\Http\Request;

class PhotoboxController extends Controller
{
    public function index()
    {
        $templates = Template::where('status_aktif', true)->get();
        $packages = Package::where('status_aktif', true)->get();
        return view('photobox.index', compact('templates', 'packages'));
    }
}
