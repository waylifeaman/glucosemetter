<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\penyakit;

class RealtimeBpm extends Component
{
    public $bpm;

    public function mount()
    {
        $this->loadLastbpm();
    }
    public function loadLastbpm()
    {
        $this->bpm = penyakit::latest()->first();
    }
    public function hydrate()
    {
        // $this->emit('debug', 'Hydrated!');
        $this->loadLastbpm();
    }
    public function render()
    {
        return view('livewire.realtime-bpm');
    }
}
