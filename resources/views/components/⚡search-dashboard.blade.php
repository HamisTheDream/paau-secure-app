<?php

use Livewire\Volt\Component;
use App\Models\Student;
use App\Models\Staff;

new class extends Component {
    public string $searchQuery = '';
    public $selectedPerson = null;
    public ?string $personType = null;
    public bool $showModal = false;

    // The 'with' method automatically passes data to the Blade view below
    public function with(): array
    {
        $searchResults = collect();

        if (strlen($this->searchQuery) >= 2) {
            $students = Student::where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('matric_number', 'like', '%' . $this->searchQuery . '%')
                ->get()
                ->map(function ($student) {
                    $student->type = 'Student';
                    return $student;
                });

            $staff = Staff::where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('staff_number', 'like', '%' . $this->searchQuery . '%')
                ->get()
                ->map(function ($member) {
                    $member->type = 'Staff';
                    return $member;
                });

            $searchResults = $students->concat($staff);
        }

        return [
            'results' => $searchResults
        ];
    }

    public function viewDetails($id, $type)
    {
        if ($type === 'Student') {
            $this->selectedPerson = Student::find($id);
        } else {
            $this->selectedPerson = Staff::find($id);
        }
        
        $this->personType = $type;
        $this->showModal = true;
        $this->searchQuery = '';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedPerson = null;
    }
}; ?>

<div class="relative max-w-2xl mx-auto mt-10">
    
    <!-- Header / Logo Area -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-700 text-white rounded-full mb-4 shadow-lg">
            <!-- Placeholder for PAAU Logo -->
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">PAAU Security Dashboard</h1>
        <p class="text-gray-500 mt-1">Search for Students or Staff members</p>
    </div>

    <!-- Search Input -->
    <div class="relative">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="searchQuery" 
            placeholder="Enter name, matric number, or staff ID..." 
            class="w-full px-5 py-4 text-lg bg-white border-2 border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 transition"
        >
        
        <!-- Loading Indicator (Shows only while typing) -->
        <div wire:loading wire:target="searchQuery" class="absolute right-4 top-4">
            <svg class="animate-spin h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>
    </div>

    <!-- Auto-complete Dropdown -->
    @if(strlen($searchQuery) >= 2)
        <div class="absolute z-40 w-full mt-2 bg-white rounded-xl shadow-xl border border-gray-100 max-h-96 overflow-y-auto">
            @if($results->isEmpty())
                <div class="p-5 text-center text-gray-500">
                    User record not found in the database
                </div>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach($results as $result)
                        <li 
                            wire:click="viewDetails({{ $result->id }}, '{{ $result->type }}')"
                            class="p-4 hover:bg-gray-50 cursor-pointer flex justify-between items-center transition"
                        >
                            <div>
                                <p class="font-semibold text-gray-800">{{ $result->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $result->type === 'Student' ? $result->matric_number : $result->staff_number }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $result->type === 'Student' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ $result->type }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <!-- Security Modal overlay -->
    @if($showModal && $selectedPerson)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50 backdrop-blur-sm">
            
            <!-- Modal Card -->
            <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">
                
                <!-- Close Button -->
                <button wire:click="closeModal" class="absolute top-4 right-4 bg-gray-100 p-2 rounded-full hover:bg-gray-200 transition z-10">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Dynamic Security Banner Header -->
                @php
                    $statusColor = match($selectedPerson->security_status) {
                        'None' => 'bg-green-500',
                        'Wanted' => 'bg-red-600',
                        'Investigated' => 'bg-orange-500',
                        'Suspended' => 'bg-yellow-500',
                        'Withdrawn' => 'bg-gray-800',
                        default => 'bg-gray-500',
                    };
                @endphp
                <div class="{{ $statusColor }} h-24 w-full"></div>

                <!-- Profile Info -->
                <div class="px-6 pb-6 relative text-center">
                    <!-- Profile Picture -->
                    <img src="{{ $selectedPerson->profile_picture }}" alt="Profile" class="w-24 h-24 rounded-full border-4 border-white shadow-lg mx-auto -mt-12 bg-white">
                    
                    <h2 class="mt-4 text-2xl font-bold text-gray-800">{{ $selectedPerson->name }}</h2>
                    <p class="text-sm font-medium text-gray-500 mb-4">
                        {{ $personType === 'Student' ? $selectedPerson->matric_number : $selectedPerson->staff_number }}
                    </p>

                    <!-- Security Alert Badge -->
                    <div class="inline-block px-4 py-1 mb-6 text-sm font-bold text-white rounded-full {{ $statusColor }} shadow-sm">
                        Security Status: {{ strtoupper($selectedPerson->security_status) }}
                    </div>

                    <!-- Detailed Data Grid -->
                    <div class="grid grid-cols-2 gap-4 text-left border-t border-gray-100 pt-4">
                        
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Department</p>
                            <p class="font-semibold text-gray-800">{{ $selectedPerson->department }}</p>
                        </div>

                        @if($personType === 'Student')
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider">Level</p>
                                <p class="font-semibold text-gray-800">{{ $selectedPerson->level }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider">Fees Status</p>
                                <p class="font-semibold {{ $selectedPerson->fees_status === 'Paid' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $selectedPerson->fees_status }}
                                </p>
                            </div>
                        @else
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider">Role</p>
                                <p class="font-semibold text-gray-800">{{ $selectedPerson->role }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider">Rank</p>
                                <p class="font-semibold text-gray-800">{{ $selectedPerson->rank }}</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>