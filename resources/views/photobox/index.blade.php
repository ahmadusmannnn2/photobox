@extends('layouts.app')

@section('content')
<div class="h-screen w-full bg-zinc-900 overflow-hidden relative flex flex-col font-sans text-white">
    
    <!-- Title Bar -->
    <div class="bg-blue-400 border-b-4 border-black p-3 md:p-4 flex justify-between items-center z-20 shadow-[0_4px_0_0_rgba(0,0,0,1)] relative shrink-0">
        <h1 class="text-xl md:text-3xl font-black uppercase tracking-widest text-black">📸 Studio</h1>
        <div class="flex space-x-2">
            <div class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-red-500 border-2 border-black"></div>
            <div class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-yellow-400 border-2 border-black"></div>
            <div class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-green-400 border-2 border-black"></div>
        </div>
    </div>

    <!-- MAIN CONTAINER -->
    <div class="flex-1 relative overflow-hidden bg-zinc-800">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- ==================== STEP 1: WELCOME ==================== -->
        <div id="step-welcome" class="absolute inset-0 flex flex-col items-center justify-center bg-yellow-300 z-50 cursor-pointer transition-transform duration-500 px-4">
            <div class="bg-white p-6 md:p-12 border-4 md:border-8 border-black rounded-3xl shadow-[8px_8px_0_0_rgba(0,0,0,1)] md:shadow-[12px_12px_0_0_rgba(0,0,0,1)] text-center animate-bounce">
                <h2 class="text-4xl md:text-6xl font-black text-black uppercase mb-2 md:mb-4 tracking-tighter">Ready to<br>Strike a Pose?</h2>
                <p class="text-lg md:text-2xl font-bold text-gray-700 uppercase">Tap anywhere to start</p>
            </div>
        </div>

        <!-- ==================== STEP 1.5: PACKAGE SELECTION ==================== -->
        <div id="step-package" class="absolute inset-0 flex flex-col md:flex-row hidden z-[45] bg-zinc-800 overflow-y-auto md:overflow-hidden">
            <div class="w-full md:w-1/3 bg-purple-400 border-b-4 md:border-b-0 md:border-r-4 border-black p-6 md:p-8 flex flex-col justify-center shadow-[0_4px_0_0_rgba(0,0,0,1)] md:shadow-[4px_0_0_0_rgba(0,0,0,1)] z-10 shrink-0">
                <h2 class="text-4xl md:text-5xl font-black text-black uppercase tracking-tighter mb-2 md:mb-4 leading-none">Choose<br>Package</h2>
                <p class="text-lg md:text-xl font-bold text-black mb-4 md:mb-8">Select your session duration and print limits.</p>
                <button id="btn-confirm-package" class="bg-black hover:bg-zinc-800 text-white font-black py-3 md:py-4 px-6 rounded-lg border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,0.5)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase text-xl md:text-2xl w-full disabled:opacity-50 disabled:cursor-not-allowed hidden md:block">
                    Next ➡️
                </button>
            </div>
            <div class="flex-1 p-4 md:p-8 flex items-start md:items-center justify-center overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-8 w-full max-w-4xl" id="package-container">
                    @foreach($packages as $index => $package)
                    <div class="package-item cursor-pointer group relative border-4 md:border-8 border-black rounded-2xl md:rounded-3xl overflow-hidden transition-all duration-200 bg-white p-4 md:p-8 flex flex-col items-center justify-center text-center shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[8px_8px_0_0_rgba(0,0,0,1)] hover:-translate-y-1 hover:-translate-x-1" data-id="{{ $package->id }}" data-duration="{{ $package->duration_minutes }}" data-max="{{ $package->max_prints }}">
                        <h3 class="text-2xl md:text-4xl font-black uppercase text-black mb-1 md:mb-2">{{ $package->name }}</h3>
                        <p class="text-xl md:text-2xl font-bold text-red-500 mb-4 md:mb-6">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                        
                        <ul class="text-left text-black font-bold text-sm md:text-lg space-y-1 md:space-y-2 mb-4 md:mb-6 w-full">
                            <li>⏱️ Session: <span class="text-blue-600">{{ $package->duration_minutes }} Mins</span></li>
                            <li>📸 Unlimited Shots</li>
                            <li>🖼️ Keep: <span class="text-green-600">{{ $package->max_prints }} Photos</span></li>
                        </ul>
                    </div>
                    @endforeach
                </div>
                
                <!-- Mobile Only Next Button -->
                <button id="btn-confirm-package-mobile" class="mt-6 md:hidden bg-black hover:bg-zinc-800 text-white font-black py-4 px-6 rounded-lg border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,0.5)] transition uppercase text-xl w-full disabled:opacity-50 disabled:cursor-not-allowed">
                    Next ➡️
                </button>
            </div>
        </div>

        <!-- ==================== STEP 2: TEMPLATE SELECTION ==================== -->
        <div id="step-template" class="absolute inset-0 flex flex-col md:flex-row hidden z-40 bg-zinc-800 overflow-y-auto md:overflow-hidden">
            <div class="w-full md:w-1/3 bg-pink-400 border-b-4 md:border-b-0 md:border-r-4 border-black p-6 md:p-8 flex flex-col justify-center shadow-[0_4px_0_0_rgba(0,0,0,1)] md:shadow-[4px_0_0_0_rgba(0,0,0,1)] z-10 shrink-0">
                <h2 class="text-4xl md:text-5xl font-black text-black uppercase tracking-tighter mb-2 md:mb-4 leading-none">Choose<br>Your Frame</h2>
                <p class="text-lg md:text-xl font-bold text-black mb-4 md:mb-8">Select a frame style to proceed to payment.</p>
                <button id="btn-confirm-template" class="bg-black hover:bg-zinc-800 text-white font-black py-3 md:py-4 px-6 rounded-lg border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,0.5)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase text-xl md:text-2xl w-full disabled:opacity-50 disabled:cursor-not-allowed hidden md:block">
                    Pay Now 💳
                </button>
            </div>
            <div class="flex-1 p-4 md:p-8 overflow-y-auto">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6" id="template-container">
                    @foreach($templates as $index => $template)
                    <div class="template-item cursor-pointer group relative border-4 border-black rounded-lg overflow-hidden transition-all duration-200 bg-white shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[6px_6px_0_0_rgba(0,0,0,1)] hover:-translate-y-1 hover:-translate-x-1" data-src="{{ asset('storage/' . $template->overlay_image_path) }}" data-id="{{ $template->id }}">
                        <div class="aspect-[3/4] bg-zinc-200 relative" style="background-image: repeating-linear-gradient(45deg, #e5e7eb 25%, transparent 25%, transparent 75%, #e5e7eb 75%, #e5e7eb); background-size: 20px 20px;">
                            <img src="{{ asset('storage/' . $template->overlay_image_path) }}" class="absolute inset-0 w-full h-full object-contain z-10 drop-shadow-md">
                        </div>
                        <div class="bg-white p-2 md:p-3 border-t-4 border-black font-black uppercase text-center text-black text-xs md:text-base truncate">
                            {{ $template->name }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Mobile Only Pay Button -->
                <button id="btn-confirm-template-mobile" class="mt-6 md:hidden bg-black hover:bg-zinc-800 text-white font-black py-4 px-6 rounded-lg border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,0.5)] transition uppercase text-xl w-full disabled:opacity-50 disabled:cursor-not-allowed">
                    Pay Now 💳
                </button>
            </div>
        </div>

        <!-- ==================== STEP 3: PAYMENT ==================== -->
        <div id="step-payment" class="absolute inset-0 flex items-center justify-center hidden z-30 bg-green-400 px-4">
            <div class="bg-white p-6 md:p-10 border-4 md:border-8 border-black rounded-2xl md:rounded-3xl shadow-[8px_8px_0_0_rgba(0,0,0,1)] md:shadow-[12px_12px_0_0_rgba(0,0,0,1)] text-center text-black max-w-md w-full">
                <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tighter mb-2">Payment</h2>
                <p class="font-bold text-gray-600 mb-4 md:mb-6 uppercase text-sm md:text-base">Scan QR Code to pay</p>
                <div class="bg-zinc-100 p-4 md:p-6 rounded-xl border-4 border-black mb-4 md:mb-6 inline-block">
                    <!-- Dummy QR Code -->
                    <div class="w-32 h-32 md:w-48 md:h-48 bg-black mx-auto" style="mask: url('data:image/svg+xml;utf8,<svg viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'><rect width=\'100\' height=\'100\' fill=\'white\'/><rect x=\'10\' y=\'10\' width=\'80\' height=\'80\' fill=\'black\'/><rect x=\'20\' y=\'20\' width=\'60\' height=\'60\' fill=\'white\'/><rect x=\'30\' y=\'30\' width=\'40\' height=\'40\' fill=\'black\'/></svg>') no-repeat center / contain; -webkit-mask: url('data:image/svg+xml;utf8,<svg viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'><rect width=\'100\' height=\'100\' fill=\'black\'/><rect x=\'10\' y=\'10\' width=\'25\' height=\'25\' fill=\'white\'/><rect x=\'65\' y=\'10\' width=\'25\' height=\'25\' fill=\'white\'/><rect x=\'10\' y=\'65\' width=\'25\' height=\'25\' fill=\'white\'/><rect x=\'15\' y=\'15\' width=\'15\' height=\'15\' fill=\'black\'/><rect x=\'70\' y=\'15\' width=\'15\' height=\'15\' fill=\'black\'/><rect x=\'15\' y=\'70\' width=\'15\' height=\'15\' fill=\'black\'/><rect x=\'45\' y=\'45\' width=\'35\' height=\'35\' fill=\'white\'/><rect x=\'40\' y=\'10\' width=\'15\' height=\'15\' fill=\'white\'/><rect x=\'10\' y=\'40\' width=\'15\' height=\'15\' fill=\'white\'/></svg>') no-repeat center / contain;"></div>
                </div>
                <div class="flex items-center justify-center space-x-2 text-sm md:text-xl font-bold text-blue-600 mb-4 md:mb-6">
                    <svg class="animate-spin h-5 w-5 md:h-6 md:w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Waiting for payment...</span>
                </div>
                <button id="btn-simulate-pay" class="bg-yellow-400 hover:bg-yellow-500 text-black font-black py-3 px-4 rounded border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase text-xs md:text-sm w-full">
                    🛠️ Simulate Success Payment
                </button>
            </div>
        </div>

        <!-- ==================== STEP 4: STUDIO SESSION (CAMERA) ==================== -->
        <div id="step-camera" class="absolute inset-0 flex flex-col md:flex-row hidden z-20 bg-zinc-800">
            <!-- Top/Left Sidebar (Status & Gallery) -->
            <div class="w-full md:w-1/4 bg-blue-400 border-b-4 md:border-b-0 md:border-r-4 border-black p-4 md:p-6 flex flex-row md:flex-col shadow-[0_4px_0_0_rgba(0,0,0,1)] md:shadow-[4px_0_0_0_rgba(0,0,0,1)] z-10 text-black overflow-x-auto md:overflow-y-auto shrink-0 items-center md:items-stretch gap-4 md:gap-0">
                
                <div class="bg-white border-4 border-black p-2 md:p-4 rounded-xl text-center md:mb-6 shadow-[4px_4px_0_0_rgba(0,0,0,1)] shrink-0 min-w-[120px]">
                    <h3 class="font-black uppercase text-xs md:text-sm text-gray-500 mb-1">Time Left</h3>
                    <div id="session-timer" class="text-3xl md:text-5xl font-black tracking-tighter text-red-500">00:00</div>
                </div>

                <div class="flex-1 md:flex-none flex flex-row md:flex-col items-center md:items-stretch overflow-x-auto md:overflow-y-visible gap-4 md:gap-0 h-full">
                    <h3 class="font-black uppercase text-sm md:text-xl md:mb-4 border-r-4 md:border-r-0 md:border-b-4 border-black pr-4 md:pr-0 md:pb-2 shrink-0 self-center md:self-start">Gallery (<span id="gallery-count">0</span>)</h3>
                    
                    <div id="gallery-container" class="flex flex-row md:grid md:grid-cols-2 gap-2 md:gap-3 flex-1 content-start overflow-x-auto md:overflow-y-visible py-2 md:py-0">
                        <!-- Raw photos will appear here -->
                    </div>
                </div>

                <button id="btn-finish-early" class="md:mt-6 bg-red-500 hover:bg-red-600 text-white font-black py-2 md:py-3 px-4 rounded border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,1)] transition uppercase text-xs md:text-sm shrink-0 whitespace-nowrap">
                    Finish ⏭️
                </button>
            </div>

            <!-- Right Area (Camera) -->
            <div class="flex-1 relative flex items-center justify-center p-4 md:p-8 bg-zinc-900 overflow-hidden">
                <div id="camera-container" class="relative w-full max-w-[min(100%,60vh)] md:max-w-2xl aspect-[3/4] md:aspect-[4/3] bg-black border-4 md:border-8 border-black rounded-xl shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[8px_8px_0_0_rgba(0,0,0,1)] overflow-hidden isolate mx-auto">
                    <!-- Video needs object-cover to fill aspect ratio without stretching on mobile -->
                    <video id="video-feed" autoplay playsinline class="absolute inset-0 w-full h-full object-cover -scale-x-100 transition-all duration-300"></video>
                    
                    <!-- Sticker Overlay Element -->
                    <div id="sticker-overlay" class="absolute inset-0 flex items-center justify-center pointer-events-none z-10 hidden">
                        <span id="active-sticker" class="text-7xl md:text-9xl drop-shadow-lg"></span>
                    </div>

                    <!-- Hidden Canvas for capturing raw photo -->
                    <canvas id="raw-canvas" class="hidden"></canvas>
                    
                    <div id="countdown-overlay" class="absolute inset-0 bg-black/40 backdrop-blur-sm z-20 flex items-center justify-center hidden">
                        <span id="countdown-text" class="text-7xl md:text-9xl font-black text-white drop-shadow-[0_5px_5px_rgba(0,0,0,0.8)] scale-150 transition-transform duration-300">3</span>
                    </div>

                    <div id="flash-effect" class="absolute inset-0 bg-white z-30 opacity-0 pointer-events-none transition-opacity duration-150"></div>
                </div>

                <!-- Filters & Stickers Toolbar -->
                <div class="absolute top-4 left-1/2 -translate-x-1/2 flex flex-col gap-2 z-30 bg-white/10 backdrop-blur-md p-2 rounded-xl border-2 border-white/20 w-11/12 md:w-auto max-w-lg">
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 hide-scrollbar">
                        <span class="text-white font-bold text-xs uppercase shrink-0">Filter:</span>
                        <button class="filter-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-yellow-400 focus:border-yellow-400 whitespace-nowrap" data-filter="none">Normal</button>
                        <button class="filter-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-yellow-400 focus:border-yellow-400 whitespace-nowrap" data-filter="grayscale(100%)">B&W</button>
                        <button class="filter-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-yellow-400 focus:border-yellow-400 whitespace-nowrap" data-filter="sepia(80%)">Retro</button>
                        <button class="filter-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-yellow-400 focus:border-yellow-400 whitespace-nowrap" data-filter="hue-rotate(90deg) contrast(1.2)">Cyber</button>
                    </div>
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 hide-scrollbar">
                        <span class="text-white font-bold text-xs uppercase shrink-0">Sticker:</span>
                        <button class="sticker-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-pink-400 focus:border-pink-400 whitespace-nowrap" data-sticker="none">Off</button>
                        <button class="sticker-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-pink-400 focus:border-pink-400 whitespace-nowrap" data-sticker="👑">Crown 👑</button>
                        <button class="sticker-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-pink-400 focus:border-pink-400 whitespace-nowrap" data-sticker="😎">Glasses 😎</button>
                        <button class="sticker-btn bg-black text-white px-3 py-1 rounded-full text-xs font-bold border-2 border-transparent hover:border-pink-400 focus:border-pink-400 whitespace-nowrap" data-sticker="🎀">Ribbon 🎀</button>
                    </div>
                </div>

                <button id="btn-shoot" class="absolute bottom-4 md:bottom-8 left-1/2 -translate-x-1/2 bg-yellow-400 hover:bg-yellow-500 text-black font-black py-3 md:py-4 px-8 md:px-12 rounded-full border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[6px_6px_0_0_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase text-xl md:text-3xl disabled:opacity-50 z-30 flex items-center gap-2">
                    <span class="text-2xl md:text-3xl">📸</span> SHOOT
                </button>
            </div>
        </div>

        <!-- ==================== STEP 5: PHOTO SELECTION ==================== -->
        <div id="step-selection" class="absolute inset-0 flex flex-col hidden z-[45] bg-pink-400 p-4 md:p-8 overflow-y-auto text-black">
            <div class="max-w-6xl mx-auto w-full">
                <div class="bg-white border-4 md:border-8 border-black p-4 md:p-6 rounded-2xl md:rounded-3xl shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[8px_8px_0_0_rgba(0,0,0,1)] mb-6 md:mb-8 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-4 md:gap-0">
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black uppercase tracking-tighter mb-1 md:mb-2">Select Your Best Shots</h2>
                        <p class="text-sm md:text-xl font-bold text-gray-600">Choose up to <span id="max-select-count" class="text-red-500 text-lg md:text-2xl font-black">2</span> photos.</p>
                    </div>
                    <div class="text-center w-full md:w-auto">
                        <span class="text-xl md:text-2xl font-black bg-zinc-200 py-2 px-4 border-4 border-black rounded-xl block md:inline-block shadow-[4px_4px_0_0_rgba(0,0,0,1)] w-full md:w-auto">
                            Selected: <span id="current-selected-count" class="text-blue-600">0</span>
                        </span>
                    </div>
                </div>

                <!-- Hidden Canvas for applying template before upload -->
                <canvas id="merge-canvas" class="hidden"></canvas>
                <img id="template-img" class="hidden" crossorigin="anonymous">

                <div id="selection-grid" class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
                    <!-- Gallery items to select -->
                </div>

                <div class="flex justify-center mb-8">
                    <button id="btn-process-upload" class="bg-blue-500 hover:bg-blue-600 text-white font-black py-4 px-8 md:px-16 rounded-full border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[6px_6px_0_0_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase text-xl md:text-3xl disabled:opacity-50 disabled:cursor-not-allowed w-full md:w-auto" disabled>
                        Process & Print 🖨️
                    </button>
                </div>
            </div>
        </div>

        <!-- ==================== STEP 6: RESULT & QR DELIVERY ==================== -->
        <div id="step-result" class="absolute inset-0 flex items-center justify-center hidden z-50 bg-zinc-100 p-4 md:p-8">
            <div class="bg-white p-6 md:p-10 border-4 md:border-8 border-black rounded-2xl md:rounded-3xl shadow-[8px_8px_0_0_rgba(0,0,0,1)] md:shadow-[12px_12px_0_0_rgba(0,0,0,1)] text-center text-black max-w-xl w-full">
                <h2 class="text-4xl md:text-5xl font-black uppercase tracking-tighter mb-2 md:mb-4 text-center">All Done!</h2>
                <p class="text-sm md:text-xl font-bold mb-6 md:mb-8 text-center bg-yellow-300 px-3 md:px-4 py-2 border-2 border-black -rotate-1 inline-block">Scan QR below to get your digital copies</p>
                
                <div id="qr-container" class="bg-white p-4 md:p-6 border-4 md:border-8 border-black rounded-xl shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[8px_8px_0_0_rgba(0,0,0,1)] mb-6 md:mb-8 flex justify-center items-center">
                    <div id="qr-loading" class="w-32 h-32 md:w-48 md:h-48 flex items-center justify-center">
                        <svg class="animate-spin h-8 w-8 md:h-10 md:w-10 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                    <img id="qr-image" class="w-32 h-32 md:w-48 md:h-48 hidden">
                </div>

                <p class="text-xs md:text-sm font-bold text-gray-500 mb-4 md:mb-6 uppercase">Printing your photos now... Please wait near the printer.</p>

                <button id="btn-finish" class="bg-green-500 hover:bg-green-600 text-white font-black py-3 md:py-4 px-8 md:px-12 rounded-full border-4 border-black shadow-[4px_4px_0_0_rgba(0,0,0,1)] md:shadow-[6px_6px_0_0_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] transition uppercase text-xl md:text-2xl w-full">
                    Finish Session
                </button>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('gif.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Elements
        const steps = {
            welcome: document.getElementById('step-welcome'),
            package: document.getElementById('step-package'),
            template: document.getElementById('step-template'),
            payment: document.getElementById('step-payment'),
            camera: document.getElementById('step-camera'),
            selection: document.getElementById('step-selection'),
            result: document.getElementById('step-result')
        };

        const packageItems = document.querySelectorAll('.package-item');
        const btnConfirmPackage = document.getElementById('btn-confirm-package');
        const btnConfirmPackageMobile = document.getElementById('btn-confirm-package-mobile');
        
        const templateItems = document.querySelectorAll('.template-item');
        const btnConfirmTemplate = document.getElementById('btn-confirm-template');
        const btnConfirmTemplateMobile = document.getElementById('btn-confirm-template-mobile');
        
        const btnSimulatePay = document.getElementById('btn-simulate-pay');

        const video = document.getElementById('video-feed');
        const rawCanvas = document.getElementById('raw-canvas');
        const btnShoot = document.getElementById('btn-shoot');
        const countdownOverlay = document.getElementById('countdown-overlay');
        const countdownText = document.getElementById('countdown-text');
        const flashEffect = document.getElementById('flash-effect');
        
        const sessionTimer = document.getElementById('session-timer');
        const galleryContainer = document.getElementById('gallery-container');
        const galleryCount = document.getElementById('gallery-count');
        const btnFinishEarly = document.getElementById('btn-finish-early');

        const selectionGrid = document.getElementById('selection-grid');
        const maxSelectCountEl = document.getElementById('max-select-count');
        const currentSelectedCountEl = document.getElementById('current-selected-count');
        const btnProcessUpload = document.getElementById('btn-process-upload');
        const mergeCanvas = document.getElementById('merge-canvas');
        const templateImgObj = document.getElementById('template-img');

        const filterBtns = document.querySelectorAll('.filter-btn');
        const stickerBtns = document.querySelectorAll('.sticker-btn');
        const stickerOverlay = document.getElementById('sticker-overlay');
        const activeSticker = document.getElementById('active-sticker');

        const qrLoading = document.getElementById('qr-loading');
        const qrImage = document.getElementById('qr-image');
        const btnFinish = document.getElementById('btn-finish');

        // State
        let selectedPackageId = null;
        let selectedDuration = 0;
        let selectedMaxPrints = 0;
        let selectedTemplateIds = [];
        let selectedTemplateSrcs = [];
        let currentTransactionUuid = null;
        
        let rawPhotos = []; // array of base64
        let selectedPhotoIndices = new Set();
        
        let sessionInterval = null;
        let paymentPollingInterval = null;
        let isShooting = false;
        
        let currentFilter = 'none';
        let currentSticker = 'none';

        // --- 1. WELCOME -> PACKAGE ---
        steps.welcome.addEventListener('click', () => switchStep('package'));

        // --- 1.5. PACKAGE ---
        function selectPackage(item) {
            packageItems.forEach(p => p.classList.remove('ring-4', 'md:ring-8', 'ring-blue-500', 'shadow-[8px_8px_0_0_rgba(59,130,246,1)]', 'md:shadow-[12px_12px_0_0_rgba(59,130,246,1)]'));
            item.classList.add('ring-4', 'md:ring-8', 'ring-blue-500', 'shadow-[8px_8px_0_0_rgba(59,130,246,1)]', 'md:shadow-[12px_12px_0_0_rgba(59,130,246,1)]');
            
            selectedPackageId = item.dataset.id;
            selectedDuration = parseInt(item.dataset.duration);
            selectedMaxPrints = parseInt(item.dataset.max);
            
            btnConfirmPackage.disabled = false;
            if(btnConfirmPackageMobile) btnConfirmPackageMobile.disabled = false;
        }

        packageItems.forEach(item => item.addEventListener('click', () => selectPackage(item)));
        
        btnConfirmPackage.addEventListener('click', () => switchStep('template'));
        if(btnConfirmPackageMobile) btnConfirmPackageMobile.addEventListener('click', () => switchStep('template'));

        // --- 2. TEMPLATE ---
        function selectTemplate(item) {
            const tid = item.dataset.id;
            const tsrc = item.dataset.src;
            
            if(selectedTemplateIds.includes(tid)) {
                selectedTemplateIds = selectedTemplateIds.filter(id => id !== tid);
                selectedTemplateSrcs = selectedTemplateSrcs.filter(src => src !== tsrc);
                item.classList.remove('ring-4', 'md:ring-8', 'ring-pink-500');
            } else {
                if(selectedTemplateIds.length >= selectedMaxPrints) {
                    alert('You can only select up to ' + selectedMaxPrints + ' frames for this package.');
                    return;
                }
                selectedTemplateIds.push(tid);
                selectedTemplateSrcs.push(tsrc);
                item.classList.add('ring-4', 'md:ring-8', 'ring-pink-500');
            }
            
            const hasSelection = selectedTemplateIds.length > 0;
            btnConfirmTemplate.disabled = !hasSelection;
            if(btnConfirmTemplateMobile) btnConfirmTemplateMobile.disabled = !hasSelection;
        }

        templateItems.forEach(item => item.addEventListener('click', () => selectTemplate(item)));
        
        async function processTemplateSelection() {
            if(selectedTemplateIds.length === 0) return;
            
            btnConfirmTemplate.disabled = true;
            btnConfirmTemplate.innerText = 'Processing...';
            if(btnConfirmTemplateMobile) {
                btnConfirmTemplateMobile.disabled = true;
                btnConfirmTemplateMobile.innerText = 'Processing...';
            }

            try {
                const res = await fetch('{{ route("transactions.create") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ template_id: selectedTemplateIds[0], package_id: selectedPackageId })
                });
                const data = await res.json();
                if(data.success) {
                    currentTransactionUuid = data.uuid;
                    switchStep('payment');
                    startPaymentPolling();
                }
            } catch(e) {
                alert('Error creating transaction');
                btnConfirmTemplate.disabled = false;
                btnConfirmTemplate.innerText = 'Pay Now 💳';
                if(btnConfirmTemplateMobile) {
                    btnConfirmTemplateMobile.disabled = false;
                    btnConfirmTemplateMobile.innerText = 'Pay Now 💳';
                }
            }
        }

        btnConfirmTemplate.addEventListener('click', processTemplateSelection);
        if(btnConfirmTemplateMobile) btnConfirmTemplateMobile.addEventListener('click', processTemplateSelection);

        // --- 3. PAYMENT ---
        function startPaymentPolling() {
            paymentPollingInterval = setInterval(async () => {
                const res = await fetch(`/api/transactions/${currentTransactionUuid}/status`);
                const data = await res.json();
                if(data.status === 'paid') {
                    clearInterval(paymentPollingInterval);
                    proceedToCamera();
                }
            }, 3000);
        }
        btnSimulatePay.addEventListener('click', async () => {
            btnSimulatePay.disabled = true;
            btnSimulatePay.innerText = 'Processing...';
            await fetch(`/api/transactions/${currentTransactionUuid}/simulate-pay`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } });
        });

        // --- 4. CAMERA STUDIO ---
        async function proceedToCamera() {
            switchStep('camera');
            await initCamera();
            startStudioSession();
        }

        async function initCamera() {
            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    throw new Error("Camera API blocked. Browsers require HTTPS to access the camera.");
                }
                const stream = await navigator.mediaDevices.getUserMedia({ video: { width: { ideal: 1920 }, height: { ideal: 1080 }, facingMode: "user" } });
                video.srcObject = stream;
            } catch (err) { 
                alert("Camera Error: " + err.message + "\n\nJika Anda mengakses via WiFi IP, HP memblokir kamera jika tidak menggunakan HTTPS. Gunakan LocalTunnel/Ngrok."); 
            }
        }

        function startStudioSession() {
            let timeLeft = selectedDuration * 60; // in seconds
            updateTimerDisplay(timeLeft);
            
            sessionInterval = setInterval(() => {
                timeLeft--;
                updateTimerDisplay(timeLeft);
                if(timeLeft <= 0) {
                    endStudioSession();
                }
            }, 1000);
        }

        function updateTimerDisplay(seconds) {
            const m = Math.floor(seconds / 60).toString().padStart(2, '0');
            const s = (seconds % 60).toString().padStart(2, '0');
            sessionTimer.innerText = `${m}:${s}`;
        }

        // --- FILTER & STICKER LOGIC ---
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                currentFilter = btn.dataset.filter;
                video.style.filter = currentFilter === 'none' ? '' : currentFilter;
                filterBtns.forEach(b => b.classList.remove('border-yellow-400'));
                btn.classList.add('border-yellow-400');
            });
        });

        stickerBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                currentSticker = btn.dataset.sticker;
                if (currentSticker === 'none') {
                    stickerOverlay.classList.add('hidden');
                } else {
                    stickerOverlay.classList.remove('hidden');
                    activeSticker.innerText = currentSticker;
                }
                stickerBtns.forEach(b => b.classList.remove('border-pink-400'));
                btn.classList.add('border-pink-400');
            });
        });

        btnShoot.addEventListener('click', () => {
            if(isShooting) return;
            isShooting = true;
            btnShoot.disabled = true;
            btnShoot.classList.add('opacity-50');

            countdownOverlay.classList.remove('hidden');
            let count = 3;
            countdownText.innerText = count;

            const timer = setInterval(() => {
                count--;
                if(count > 0) {
                    countdownText.innerText = count;
                } else {
                    clearInterval(timer);
                    snapPhoto();
                }
            }, 1000);
        });

        function snapPhoto() {
            flashEffect.style.opacity = '1';
            setTimeout(() => { flashEffect.style.opacity = '0'; }, 150);
            countdownOverlay.classList.add('hidden');

            const videoWidth = video.videoWidth || 1920;
            const videoHeight = video.videoHeight || 1080;
            rawCanvas.width = videoWidth;
            rawCanvas.height = videoHeight;
            const ctx = rawCanvas.getContext('2d');
            
            // Draw flipped video with filter
            if (currentFilter !== 'none') {
                ctx.filter = currentFilter;
            }
            ctx.translate(videoWidth, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, videoWidth, videoHeight);
            
            // Reset transforms for stickers
            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.filter = 'none';

            if (currentSticker !== 'none') {
                // Draw sticker dead center
                ctx.font = `${videoHeight * 0.3}px sans-serif`; // 30% of height
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(currentSticker, videoWidth / 2, videoHeight / 2);
            }
            
            const dataURL = rawCanvas.toDataURL('image/png');
            rawPhotos.push(dataURL);
            
            updateGalleryUI();

            isShooting = false;
            btnShoot.disabled = false;
            btnShoot.classList.remove('opacity-50');
        }

        function updateGalleryUI() {
            galleryCount.innerText = rawPhotos.length;
            galleryContainer.innerHTML = '';
            
            rawPhotos.forEach((photo, index) => {
                const div = document.createElement('div');
                div.className = 'relative border-4 border-black bg-white shadow-[2px_2px_0_0_rgba(0,0,0,1)] rounded-lg overflow-hidden aspect-[3/4] w-20 md:w-auto shrink-0 snap-start';
                div.innerHTML = `
                    <img src="${photo}" class="w-full h-full object-cover">
                    <button class="absolute top-1 right-1 bg-red-500 text-white font-black w-5 h-5 md:w-6 md:h-6 text-xs md:text-base flex items-center justify-center rounded-full border-2 border-black" onclick="deletePhoto(${index})">X</button>
                `;
                galleryContainer.appendChild(div);
            });
        }

        window.deletePhoto = function(index) {
            rawPhotos.splice(index, 1);
            updateGalleryUI();
        };

        btnFinishEarly.addEventListener('click', () => endStudioSession());

        function endStudioSession() {
            clearInterval(sessionInterval);
            
            if(video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }
            
            if(rawPhotos.length === 0) {
                alert("You didn't take any photos! Taking you back to start.");
                window.location.reload();
                return;
            }
            
            setupSelectionScreen();
            switchStep('selection');
        }

        // --- 5. SELECTION ---
        function setupSelectionScreen() {
            maxSelectCountEl.innerText = selectedMaxPrints;
            selectionGrid.innerHTML = '';
            selectedPhotoIndices.clear();
            updateSelectionCount();

            rawPhotos.forEach((photo, index) => {
                const div = document.createElement('div');
                div.className = 'cursor-pointer relative border-4 md:border-8 border-black bg-white shadow-[4px_4px_0_0_rgba(0,0,0,1)] rounded-xl overflow-hidden aspect-[3/4] transition-all duration-200';
                div.dataset.index = index;
                div.innerHTML = `
                    <img src="${photo}" class="w-full h-full object-cover">
                    <div class="selection-overlay absolute inset-0 bg-blue-500/50 hidden flex items-center justify-center backdrop-blur-sm">
                        <span class="text-white text-4xl md:text-6xl font-black drop-shadow-md">✓</span>
                    </div>
                `;
                
                div.addEventListener('click', () => toggleSelection(index, div));
                selectionGrid.appendChild(div);
            });
        }

        function toggleSelection(index, el) {
            const overlay = el.querySelector('.selection-overlay');
            if(selectedPhotoIndices.has(index)) {
                selectedPhotoIndices.delete(index);
                overlay.classList.add('hidden');
                el.classList.remove('ring-4', 'md:ring-8', 'ring-blue-500', '-translate-y-1', 'md:-translate-y-2');
            } else {
                if(selectedPhotoIndices.size >= selectedMaxPrints) {
                    alert(`You can only select up to ${selectedMaxPrints} photos.`);
                    return;
                }
                selectedPhotoIndices.add(index);
                overlay.classList.remove('hidden');
                el.classList.add('ring-4', 'md:ring-8', 'ring-blue-500', '-translate-y-1', 'md:-translate-y-2');
            }
            updateSelectionCount();
        }

        function updateSelectionCount() {
            currentSelectedCountEl.innerText = selectedPhotoIndices.size;
            btnProcessUpload.disabled = selectedPhotoIndices.size === 0;
        }

        btnProcessUpload.addEventListener('click', async () => {
            btnProcessUpload.disabled = true;
            btnProcessUpload.innerText = 'Processing... ⏳';

            const finalImagesBase64 = [];
            
            const img = new Image();
            img.src = rawPhotos[Array.from(selectedPhotoIndices)[0]];
            await new Promise(r => img.onload = r);
            
            mergeCanvas.width = img.width;
            mergeCanvas.height = img.height;
            const ctx = mergeCanvas.getContext('2d');

            let templateIndex = 0;
            for (let idx of selectedPhotoIndices) {
                const rImg = new Image();
                rImg.src = rawPhotos[idx];
                await new Promise(r => rImg.onload = r);
                ctx.drawImage(rImg, 0, 0, mergeCanvas.width, mergeCanvas.height);

                const currentTemplateSrc = selectedTemplateSrcs[templateIndex % selectedTemplateSrcs.length];
                const tImg = new Image();
                tImg.crossOrigin = 'anonymous';
                tImg.src = currentTemplateSrc;
                await new Promise(r => tImg.onload = r);
                ctx.drawImage(tImg, 0, 0, mergeCanvas.width, mergeCanvas.height);

                finalImagesBase64.push(mergeCanvas.toDataURL('image/png'));
                templateIndex++;
            }

            // --- GIF GENERATION ---
            const gif = new GIF({
                workers: 2,
                quality: 10,
                width: mergeCanvas.width,
                height: mergeCanvas.height,
                workerScript: '{{ asset("gif.worker.js") }}'
            });

            // Add frames
            for (const base64 of finalImagesBase64) {
                const fImg = new Image();
                fImg.src = base64;
                await new Promise(r => fImg.onload = r);
                gif.addFrame(fImg, {delay: 500}); // 500ms per frame
            }

            gif.on('finished', function(blob) {
                const reader = new FileReader();
                reader.readAsDataURL(blob); 
                reader.onloadend = function() {
                    const gifBase64 = reader.result;
                    uploadFinalResults(finalImagesBase64, gifBase64);
                }
            });

            gif.render();
        });

        // --- 6. UPLOAD & RESULT ---
        async function uploadFinalResults(base64Array, gifBase64 = null) {
            try {
                const payload = { images_base64: base64Array };
                if (gifBase64) payload.gif_base64 = gifBase64;

                const res = await fetch(`/api/transactions/${currentTransactionUuid}/upload`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                
                if(data.success) {
                    switchStep('result');
                    
                    // Bangun URL berdasarkan origin browser saat ini agar aman untuk Ngrok/Localtunnel (menghindari isu HTTP vs HTTPS)
                    const downloadUrl = window.location.origin + '/download/' + currentTransactionUuid;
                    
                    qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(downloadUrl)}`;
                    qrImage.onload = () => {
                        qrLoading.classList.add('hidden');
                        qrImage.classList.remove('hidden');
                    };

                    console.log('Sending print signal for: ', base64Array.length, ' photos');
                }
            } catch(e) {
                alert('Failed to upload. Please try again.');
                btnProcessUpload.disabled = false;
                btnProcessUpload.innerText = 'Process & Print 🖨️';
            }
        }

        btnFinish.addEventListener('click', () => {
            window.location.reload();
        });

        function switchStep(stepName) {
            Object.values(steps).forEach(el => {
                if(el) el.classList.add('hidden');
            });
            steps[stepName].classList.remove('hidden');
        }
    });
</script>
@endsection
