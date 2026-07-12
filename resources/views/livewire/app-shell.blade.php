<div class="h-full flex flex-col">
    <!-- Main Header -->
    <header class="bg-green-800 text-white pt-12 pb-4 px-4 shadow-md z-20 flex justify-between items-center">
        <div class="flex items-center">
            <!-- PAAU Logo -->
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 p-0.5 overflow-hidden">
                <img src="{{ asset('logo.png') }}" alt="PAAU Logo" class="w-full h-full object-contain" onerror="this.src='https://ui-avatars.com/api/?name=PAAU&background=fff&color=166534'">
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight">PAAU SecureApp</h1>
                <div class="flex items-center mt-0.5">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                    <span class="text-xs text-green-200">System Online</span>
                </div>
            </div>
        </div>
        <button wire:click="logout" class="p-2 bg-green-700 rounded-full text-green-100 hover:bg-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
        </button>
    </header>

    <!-- Dynamic Content Area -->
    <main class="flex-1 overflow-y-auto bg-gray-50 pb-20">
        @if($currentTab === 'verify')
            <livewire:search-dashboard />
        @elseif($currentTab === 'scan')
            <div class="flex flex-col items-center justify-center h-full p-8 text-center text-gray-500">
                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                <h3 class="text-lg font-bold text-gray-800">Scanner Offline</h3>
                <p class="text-sm mt-2">Hardware camera access is required to scan ID barcodes.</p>
            </div>
        @elseif($currentTab === 'report')
            <livewire:incident-report />
        @endif
    </main>

    <!-- Functional Bottom Navigation -->
    <nav class="absolute bottom-0 w-full bg-white border-t border-gray-200 flex justify-around items-center pb-safe pt-2 h-16 px-2 z-20 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <button wire:click="switchTab('verify')" class="flex flex-col items-center w-full {{ $currentTab === 'verify' ? 'text-green-700' : 'text-gray-400 hover:text-green-600' }} transition">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span class="text-[10px] font-semibold">Verify</span>
        </button>
        
        <button wire:click="switchTab('scan')" class="flex flex-col items-center w-full {{ $currentTab === 'scan' ? 'text-green-700' : 'text-gray-400 hover:text-green-600' }} transition relative">
            <div class="{{ $currentTab === 'scan' ? 'bg-green-600' : 'bg-gray-800' }} text-white p-3 rounded-full -mt-6 shadow-lg border-4 border-gray-50 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <span class="text-[10px] font-semibold mt-1">Scan ID</span>
        </button>
        
        <button wire:click="switchTab('report')" class="flex flex-col items-center w-full {{ $currentTab === 'report' ? 'text-green-700' : 'text-gray-400 hover:text-green-600' }} transition">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="text-[10px] font-semibold">Report</span>
        </button>
    </nav>
</div>