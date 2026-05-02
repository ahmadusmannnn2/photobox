@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-zinc-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8 border-b-4 border-black pb-4">
            <h1 class="text-4xl font-black uppercase tracking-tighter">Admin Dashboard</h1>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded border-2 border-black shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase tracking-wider text-sm">
                    Logout
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-400 text-black font-bold p-4 rounded mb-6 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-400 text-black font-bold p-4 rounded mb-6 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Form Upload Template -->
            <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-xl border-4 border-black h-fit">
                <h2 class="text-2xl font-black mb-6 uppercase border-b-2 border-black pb-2">Add New Template</h2>
                <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label class="block font-bold mb-2 uppercase text-xs tracking-widest">Template Name</label>
                        <input type="text" name="name" class="w-full border-2 border-black p-3 rounded bg-zinc-50 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-400 transition" required>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block font-bold mb-2 uppercase text-xs tracking-widest">Overlay Image (PNG)</label>
                        <input type="file" name="overlay_image" accept="image/png" class="w-full border-2 border-black p-2 rounded bg-zinc-50 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-bold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" required>
                        <p class="text-xs text-gray-500 mt-2 font-medium">Please use transparent PNG format. Recommended size: 1080x1920 or 1200x1800.</p>
                    </div>
                    
                    <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-black py-3 px-4 rounded border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase tracking-widest">
                        Upload Template
                    </button>
                </form>
            </div>

            <!-- List Templates -->
            <div class="md:col-span-2">
                <h2 class="text-2xl font-black mb-6 uppercase border-b-4 border-black pb-2 inline-block">Existing Templates</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($templates as $template)
                        <div class="bg-white rounded-lg border-4 border-black overflow-hidden shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex flex-col">
                            <div class="bg-zinc-200 aspect-[3/4] relative flex items-center justify-center p-4 border-b-4 border-black" style="background-image: repeating-linear-gradient(45deg, #e5e7eb 25%, transparent 25%, transparent 75%, #e5e7eb 75%, #e5e7eb), repeating-linear-gradient(45deg, #e5e7eb 25%, #f3f4f6 25%, #f3f4f6 75%, #e5e7eb 75%, #e5e7eb); background-position: 0 0, 10px 10px; background-size: 20px 20px;">
                                <img src="{{ asset('storage/' . $template->overlay_image_path) }}" alt="{{ $template->name }}" class="object-contain w-full h-full drop-shadow-md z-10">
                            </div>
                            <div class="p-4 flex-grow flex flex-col justify-between bg-white">
                                <div>
                                    <h3 class="font-black text-xl mb-1 uppercase truncate">{{ $template->name }}</h3>
                                    <span class="inline-block bg-green-200 text-green-800 text-xs px-2 py-1 rounded font-bold border border-green-800 uppercase">Active</span>
                                </div>
                                <div class="mt-4 pt-4 border-t-2 border-dashed border-zinc-300">
                                    <form action="{{ route('admin.templates.destroy', $template) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition uppercase text-xs">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-yellow-100 p-8 rounded-lg border-4 border-black text-center border-dashed">
                            <p class="font-bold text-xl text-yellow-800 uppercase tracking-wide">No templates found.</p>
                            <p class="text-sm mt-2 font-medium text-yellow-700">Upload your first template from the sidebar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
