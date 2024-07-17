<div wire:poll.1s>
    <div class="table-responsive">
        <table id="tabelpenyakit" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th class=" ">Kadar Gula</th>
                    <th class=" ">Kadar Kolesterol</th>
                    <th class="d-none d-xl-table-cell">Waktu Check</th>
                    {{-- <th class="d-none d-xl-table-cell">Waktu Check</th> --}}
                    <th class="d-none d-xl-table-cell">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Tablepenyakits as $p)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td class="">{{ $p->gula_darah }}</td>
                        <td class="">{{ $p->kolesterol }}</td>
                        <td><span class="badge bg-success d-none d-xl-table-cell">{{ $p->created_at }}</span></td>
                        <td><span class="badge bg-warning d-none d-xl-table-cell">Baik</span></td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        initializeDataTable();

        Livewire.hook('message.processed', (message, component) => {
            initializeDataTable();
        });

        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#tabelpenyakit')) {
                $('#tabelpenyakit').DataTable().destroy();
            }

            $('#tabelpenyakit').DataTable({
                pageLength: 6,
                pagingType: 'full_numbers',
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        }
    });
</script>
