<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\penyakit;

class RealtimePenyakit extends Component
{
    public $penyakits;

    public function mount()
    {
        $this->loadLastPenyakit();
    }

    public function render()
    {
        return view('livewire.realtime-penyakit');
    }
    public function loadLastPenyakit()
    {
        $this->penyakits = penyakit::latest()->first();
    }
    public function hydrate()
    {
        // $this->emit('debug', 'Hydrated!');
        $this->loadLastPenyakit();
    }
}
