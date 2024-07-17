 <div wire:poll.1s>
     @if ($penyakits)
         <div class="row">
             <div class="col">
                 <h1 class="mt-1 mb-3">{{ $penyakits->gula_darah }} <span class="text-muted"
                         style="font-size: 15px">Mg/dl</span></h1>
                 <div class="mb-0">
                     <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> Gula Darah </span>
                     {{-- <span class="text-muted">Since last week</span> --}}
                 </div>
             </div>
             {{-- <div class="col">
                 <h1 class="mt-1 mb-3">{{ $penyakits->kolesterol }} <span class="text-muted"
                         style="font-size: 15px">Mg/dl</span> </h1>
                 <div class="mb-0">
                     <span class="text-warning"> <i class="mdi mdi-arrow-bottom-right"></i> Kolesterol </span>
                 </div>
             </div> --}}
         </div>
     @else
         <p>Tidak Ada Data</p>
     @endif
 </div>
