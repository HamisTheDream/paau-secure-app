<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\IncidentReport as Report;
use Illuminate\Support\Facades\Auth;

class IncidentReport extends Component
{
    public $suspectId = '';
    public $incidentType = '';
    public $description = '';
    public $successMessage = false;

    public function submitReport()
    {
        $this->validate([
            'incidentType' => 'required',
            'description' => 'required|min:10',
        ]);

        Report::create([
            'reported_by' => Auth::user()->email,
            'suspect_id' => $this->suspectId,
            'incident_type' => $this->incidentType,
            'description' => $this->description,
        ]);

        $this->reset(['suspectId', 'incidentType', 'description']);
        $this->successMessage = true;
    }

    public function render()
    {
        return view('livewire.incident-report');
    }
}