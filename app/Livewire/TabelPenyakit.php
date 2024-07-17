<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\penyakit;

class TabelPenyakit extends Component
{
    public $Tablepenyakits;

    public function mount()
    {
        $this->loadLastPenyakit();
    }

    public function render()
    {

        return view('livewire.tabel-penyakit', ['i' => 1]);
    }
    public function loadLastPenyakit()
    {
        $this->Tablepenyakits = penyakit::latest()->take(10)->get();
    }
    public function hydrate()
    {
        // $this->emit('debug', 'Hydrated!');
        $this->loadLastPenyakit();
    }
}
