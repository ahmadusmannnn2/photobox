<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function show($uuid)
    {
        $transaction = Transaction::with('photos')->where('uuid', $uuid)
            ->firstOrFail();

        return view('download.show', compact('transaction'));
    }
}
