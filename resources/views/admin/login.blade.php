@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-zinc-900 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-xl border-4 border-black">
        <h2 class="text-3xl font-black text-center mb-8 uppercase tracking-tighter">Admin Login</h2>
        
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-6 font-bold border-2 border-black">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-6">
                <label class="block font-bold mb-2 uppercase text-sm tracking-wide">Email</label>
                <input type="email" name="email" class="w-full border-2 border-black p-3 rounded bg-zinc-100 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-400 transition" required value="{{ old('email') }}">
            </div>
            
            <div class="mb-8">
                <label class="block font-bold mb-2 uppercase text-sm tracking-wide">Password</label>
                <input type="password" name="password" class="w-full border-2 border-black p-3 rounded bg-zinc-100 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-400 transition" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-black py-4 px-4 rounded border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase tracking-widest text-lg">
                Login
            </button>
        </form>
    </div>
</div>
@endsection
