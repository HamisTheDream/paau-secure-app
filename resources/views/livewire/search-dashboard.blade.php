<div class="p-4">
    
    <!-- Large, Tappable Search Bar -->
    <div class="relative bg-white rounded-2xl shadow-sm border border-gray-200 p-2">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input 
                type="text" 
                inputmode="search"
                wire:model.live.debounce.300ms="searchQuery" 
                placeholder="Enter Matric / Staff ID..." 
                class="w-full px-3 py-3 text-lg bg-transparent border-none focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-400"
            >
            <div wire:loading wire:target="searchQuery" class="mr-3">
                <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Quick Filters -->
    <div class="flex space-x-2 mt-4 overflow-x-auto pb-2 scrollbar-hide">
        <button class="px-4 py-1.5 bg-green-100 text-green-800 rounded-full text-sm font-semibold whitespace-nowrap border border-green-200">All</button>
        <button class="px-4 py-1.5 bg-white text-gray-600 rounded-full text-sm font-medium whitespace-nowrap border border-gray-200 shadow-sm">Students Only</button>
        <button class="px-4 py-1.5 bg-white text-gray-600 rounded-full text-sm font-medium whitespace-nowrap border border-gray-200 shadow-sm">Staff Only</button>
    </div>

    <!-- Search Results List -->
    @if(strlen($searchQuery) >= 2)
        <div class="mt-4 space-y-3">
            @if($results->isEmpty())
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 text-center">
                    <svg class="w-8 h-8 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-sm font-bold text-red-800">No Record Found</p>
                    <p class="text-xs text-red-600 mt-1">Verify ID number or confiscate.</p>
                </div>
            @else
                @foreach($results as $result)
                    <!-- Tappable Result Card -->
                    <div 
                        wire:click="viewDetails({{ $result->id }}, '{{ $result->type }}')"
                        class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center active:bg-gray-50 active:scale-95 transition-transform cursor-pointer"
                    >
                        <img src="{{ $result->profile_picture }}" class="w-12 h-12 rounded-full border border-gray-200">
                        <div class="ml-3 flex-1">
                            <p class="font-bold text-gray-900 text-sm truncate">{{ $result->name }}</p>
                            <p class="text-xs text-gray-500 font-mono mt-0.5">
                                {{ $result->type === 'Student' ? $result->matric_number : $result->staff_number }}
                            </p>
                        </div>
                        <div class="ml-2 flex flex-col items-end">
                            <span class="text-[10px] uppercase font-bold {{ $result->type === 'Student' ? 'text-blue-600' : 'text-purple-600' }}">{{ $result->type }}</span>
                            @if($result->security_status !== 'None')
                                <span class="w-3 h-3 bg-red-600 rounded-full mt-1 animate-pulse"></span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endif

    <!-- Premium Full-Screen Bottom Sheet Modal -->
    @if($showModal && $selectedPerson)
        <div class="fixed inset-0 z-50 flex flex-col justify-end bg-black bg-opacity-60 backdrop-blur-sm animate-fade-in">
            
            <!-- Draggable Sheet Container -->
            <div class="w-full h-[90vh] max-w-md mx-auto bg-gray-50 rounded-t-3xl shadow-2xl flex flex-col relative overflow-hidden animate-slide-up">
                
                <!-- Close Button (Floating) -->
                <button wire:click="closeModal" class="absolute top-4 right-4 z-20 bg-black/20 hover:bg-black/40 backdrop-blur-md text-white p-2 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                @php
                    $statusColor = match($selectedPerson->security_status) {
                        'None' => 'bg-green-600',
                        'Wanted' => 'bg-red-600',
                        'Investigated' => 'bg-orange-500',
                        'Suspended' => 'bg-yellow-500',
                        'Withdrawn' => 'bg-gray-800',
                        default => 'bg-gray-500',
                    };
                @endphp

                <!-- Cover Graphic -->
                <div class="{{ $statusColor }} h-32 w-full flex-shrink-0 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white to-transparent"></div>
                    <h3 class="text-white/90 font-black tracking-[0.2em] uppercase text-2xl z-10 opacity-30 mix-blend-overlay">
                        {{ $selectedPerson->security_status === 'None' ? 'CLEARED' : $selectedPerson->security_status }}
                    </h3>
                </div>

                <!-- Scrollable Profile Content -->
                <div class="flex-1 overflow-y-auto pb-10 px-6">
                    
                    <!-- Avatar (Overlapping) -->
                    <div class="-mt-16 flex justify-center relative z-10">
                        <div class="relative">
                            <img src="{{ $selectedPerson->profile_picture }}" alt="Profile" class="w-32 h-32 rounded-full border-4 border-gray-50 shadow-xl object-cover bg-white">
                            @if($selectedPerson->security_status !== 'None')
                                <div class="absolute bottom-2 right-2 w-6 h-6 bg-red-600 border-2 border-white rounded-full flex items-center justify-center animate-bounce">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Identity Block -->
                    <div class="text-center mt-4 mb-6">
                        <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">{{ $selectedPerson->name }}</h2>
                        <p class="text-base font-mono font-bold text-gray-500 mt-1">
                            {{ $personType === 'Student' ? $selectedPerson->matric_number : $selectedPerson->staff_number }}
                        </p>
                        <span class="inline-block mt-3 px-3 py-1 bg-gray-200 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-full">
                            {{ $personType }} Profile
                        </span>
                    </div>

                    <!-- Data Grid -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 space-y-4">
                        
                        <div class="grid grid-cols-2 gap-4 border-b border-gray-50 pb-4">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Date of Birth</p>
                                <p class="font-semibold text-gray-800 text-sm mt-0.5">{{ \Carbon\Carbon::parse($selectedPerson->dob)->format('d M, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Phone</p>
                                <p class="font-semibold text-gray-800 text-sm mt-0.5">{{ $selectedPerson->phone_number }}</p>
                            </div>
                        </div>

                        <div class="pb-4 border-b border-gray-50">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Department</p>
                            <p class="font-bold text-gray-800 text-base mt-0.5">{{ $selectedPerson->department }}</p>
                        </div>

                        @if($personType === 'Student')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Level</p>
                                    <p class="font-semibold text-gray-800 text-sm mt-0.5">{{ $selectedPerson->level }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Fees Status</p>
                                    <div class="mt-1">
                                        <span class="px-2 py-0.5 text-xs font-bold rounded {{ $selectedPerson->fees_status === 'Paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ strtoupper($selectedPerson->fees_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Role</p>
                                    <p class="font-semibold text-gray-800 text-sm mt-0.5">{{ $selectedPerson->role }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Rank</p>
                                    <p class="font-semibold text-gray-800 text-sm mt-0.5">{{ $selectedPerson->rank }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-6 flex gap-3">
                        <button wire:click="$parent.switchTab('report')" class="flex-1 bg-gray-900 text-white py-3.5 rounded-xl font-bold text-sm shadow-md active:bg-gray-800 flex justify-center items-center transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Log Issue
                        </button>
                        @if($selectedPerson->security_status !== 'None')
                            <button class="flex-1 bg-red-600 text-white py-3.5 rounded-xl font-bold text-sm shadow-md active:bg-red-700 flex justify-center items-center transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                Call Unit
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>