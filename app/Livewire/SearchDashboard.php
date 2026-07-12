<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Staff;

class SearchDashboard extends Component
{
    public $searchQuery = '';
    public $selectedPerson = null;
    public $personType = null;
    public $showModal = false;

    public function render()
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

        return view('livewire.search-dashboard', [
            'results' => $searchResults
        ]);
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
}