<div class="h-full flex flex-col justify-center px-8 bg-green-900 relative">
    
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-green-400 rounded-full mix-blend-overlay blur-2xl"></div>
    </div>

    <!-- App Logo & Branding -->
    <div class="text-center z-10 mb-12 animate-fade-in-up">
        <div class="w-28 h-28 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl p-2 border-4 border-green-700 overflow-hidden">
            <!-- Looks for logo.png in the public folder -->
            <img src="{{ asset('logo.png') }}" alt="PAAU Logo" class="w-full h-full object-contain">
        </div>
        <h1 class="text-3xl font-extrabold text-white tracking-tight">PAAU SecureApp</h1>
        <p class="text-green-200 mt-2 text-sm font-medium">Tactical Field Verification System</p>
    </div>

    <!-- Login Form -->
    <form wire:submit="authenticate" class="z-10 space-y-5">
        
        @if($errorMessage)
            <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-100 px-4 py-3 rounded-xl text-sm text-center">
                {{ $errorMessage }}
            </div>
        @endif

        <div>
            <label class="block text-xs font-bold text-green-200 uppercase tracking-wider mb-2">Officer Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input type="email" wire:model="email" required class="block w-full pl-11 pr-4 py-4 bg-white rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400 font-medium shadow-sm transition" placeholder="e.g. guard@paau.edu.ng">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-green-200 uppercase tracking-wider mb-2">Passcode</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input type="password" wire:model="password" required class="block w-full pl-11 pr-4 py-4 bg-white rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400 font-medium shadow-sm transition" placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-green-900 bg-green-400 hover:bg-green-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 focus:ring-offset-green-900 transition-colors mt-8">
            <span wire:loading.remove wire:target="authenticate">Authenticate</span>
            <span wire:loading wire:target="authenticate">Verifying...</span>
        </button>
    </form>

    <div class="mt-8 text-center z-10 text-xs text-green-300">
        <p>Offline access enabled for this device.</p>
    </div>
</div>