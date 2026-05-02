<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Your Photo!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-100 font-sans text-black min-h-screen flex flex-col">

    <div class="bg-blue-500 border-b-4 border-black p-4 text-center shadow-[0_4px_0_0_rgba(0,0,0,1)]">
        <h1 class="text-2xl font-black uppercase tracking-widest text-white">📸 Virtual Photobox</h1>
    </div>

    <div class="flex-1 p-6 flex flex-col items-center justify-center">
        
        <div class="bg-white p-6 rounded-2xl border-4 border-black shadow-[8px_8px_0_0_rgba(0,0,0,1)] max-w-sm w-full text-center">
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-2">Here are your photos!</h2>
            <p class="font-bold text-gray-500 mb-6">Thanks for using our photobooth.</p>
            
            <div class="grid grid-cols-1 gap-6 mb-6">
                @foreach($transaction->photos as $photo)
                <div class="border-4 border-black rounded-lg overflow-hidden bg-zinc-200">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" class="w-full h-auto object-contain">
                    <div class="p-2 bg-white">
                        <a href="{{ asset('storage/' . $photo->image_path) }}" download="Photobox_{{ $transaction->uuid }}_{{ $loop->index }}.png" class="block w-full bg-green-400 hover:bg-green-500 text-black font-black py-3 px-2 rounded-xl border-4 border-black shadow-[2px_2px_0_0_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-none transition uppercase text-sm">
                            ⬇️ Download
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <p class="text-xs font-bold text-gray-400 mt-4">Long press the image to save if the button doesn't work.</p>
        </div>

    </div>

</body>
</html>
