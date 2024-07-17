 <div wire:poll.1s>
     @if ($bpm)
         <div class="row">
             <div class="col">
                 <h1 class="mt-1 mb-3">{{ $bpm->bpm }} <span class="text-muted" style="font-size: 15px">BPM</span>
                 </h1>
                 <div class="mb-0">
                     <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> BPM </span>
                     {{-- <span class="text-muted">Since last week</span> --}}
                 </div>
             </div>
             <div class="col">
                 <h1 class="mt-1 mb-3">{{ $bpm->spo2 }} <span class="text-muted" style="font-size: 15px">spo2</span>
                 </h1>
                 <div class="mb-0">
                     <span class="text-warning"> <i class="mdi mdi-arrow-bottom-right"></i> SPO2 </span>
                     {{-- <span class="text-muted">Since last week</span> --}}
                 </div>
             </div>
         </div>
     @else
         <p>Tidak Ada Data</p>
     @endif
 </div>
