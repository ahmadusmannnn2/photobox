<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates,id',
            'package_id' => 'required|exists:packages,id',
        ]);

        $transaction = Transaction::create([
            'uuid' => Str::uuid()->toString(),
            'template_id' => $request->template_id,
            'package_id' => $request->package_id,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'uuid' => $transaction->uuid,
        ]);
    }

    public function checkStatus($uuid)
    {
        $transaction = Transaction::where('uuid', $uuid)->firstOrFail();

        return response()->json([
            'status' => $transaction->status,
        ]);
    }

    public function simulatePay($uuid)
    {
        $transaction = Transaction::where('uuid', $uuid)->firstOrFail();
        $transaction->update(['status' => 'paid']);

        return response()->json(['success' => true]);
    }

    public function uploadResult(Request $request, $uuid)
    {
        $request->validate([
            'images_base64' => 'required|array',
            'images_base64.*' => 'required|string',
        ]);

        $transaction = Transaction::where('uuid', $uuid)->firstOrFail();

        foreach ($request->images_base64 as $index => $base64) {
            $image_parts = explode(";base64,", $base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $fileName = 'results/' . $transaction->uuid . '_' . time() . '_' . $index . '.' . $image_type;
            
            Storage::disk('public')->put($fileName, $image_base64);

            $transaction->photos()->create([
                'image_path' => $fileName
            ]);
            
            if ($index === 0) {
                // Backward compatibility or quick ref
                $transaction->update(['result_image_path' => $fileName]);
            }
        }

        return response()->json([
            'success' => true,
            'download_url' => route('download.show', $transaction->uuid),
        ]);
    }
}
