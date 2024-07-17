@extends('layouts.draft')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Gula Darah</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="codepen"></i>
                            </div>
                        </div>
                    </div>
                    <div id="glucose-cholesterol-data">
                        @if ($penyakit)
                            <div class="row">
                                <div class="col">
                                    <h1 class="mt-1 mb-3">
                                        <span id="gula_darah">{{ $penyakit->gula_darah }}</span>
                                        <span class="text-muted" style="font-size: 15px">Mg/dl</span>
                                    </h1>
                                    <div class="mb-0">
                                        <span class="text-danger"><i class="mdi mdi-arrow-bottom-right"></i> Gula
                                            Darah</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>Tidak Ada Data</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">BPM & Spo2</h5>
                        </div>
                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="codepen"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="bpm-spo2-data">
                        @if ($penyakit)
                            <div class="col">
                                <h1 class="mt-1 mb-3">
                                    <span id="bpm">{{ $penyakit->bpm }}</span>
                                    <span class="text-muted" style="font-size: 15px">BPM</span>
                                </h1>
                                <div class="mb-0">
                                    <span class="text-danger"><i class="mdi mdi-arrow-bottom-right"></i> BPM</span>
                                </div>
                            </div>
                            <div class="col">
                                <h1 class="mt-1 mb-3">
                                    <span id="spo2">{{ $penyakit->spo2 }}</span>%
                                    <span class="text-muted" style="font-size: 15px">spo2</span>
                                </h1>
                                <div class="mb-0">
                                    <span class="text-warning"><i class="mdi mdi-arrow-bottom-right"></i> SPO2</span>
                                </div>
                            </div>
                        @else
                            <p>Tidak Ada Data</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card flex-fill w-100">
                <div class="card-body py-3">
                    <div class="col">
                        <h5 class="card-title">Grafik</h5>
                    </div>
                    <div class="chart chart-sm">
                        <canvas id="chartjs-dashboard-line"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8 col-xxl-9 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title mb-0">Riwayat Pengecekan</h5>
                            <h6 class="card-title mt-4">Nama = {{ $pasien->name }}</h6>
                            <h6 class="card-title">Usia = {{ $pasien->age }}</h6>
                            <h6 class="card-title">Telepon = {{ $pasien->phone }}</h6>
                        </div>
                        <div class="col-4 d-flex align-items-center justify-content-start">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-print" onclick="printTable('example')"
                                    style="cursor: pointer; font-size: 2rem;" title="Cetak Tabel">
                                </i>
                                <h6 class="text-muted mt-2">Print</h6> <!-- Tambahkan mt-2 untuk margin-top -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>BPM</th>
                                    <th>Spo2</th>
                                    <th>Gula Darah</th>
                                    {{-- <th>Kolesterol</th> --}}
                                    <th class="d-none d-xl-table-cell">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody id="tabelpenyakit-body">
                                @foreach ($penyakits as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->bpm }}</td>
                                        <td>{{ $p->spo2 }}</td>
                                        <td>{{ $p->gula_darah }} <span>mg/dl</span></td>
                                        {{-- <td>{{ $p->kolesterol }}</td> --}}
                                        <td class="d-none d-xl-table-cell">
                                            {{ \Carbon\Carbon::parse($p->created_at)->format('d-m-Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Existing real-time data fetching and chart updating logic
            });

            function printTable(tableId) {
                var tableContent = document.getElementById(tableId).outerHTML;
                var newWindow = window.open('', '', 'width=800, height=600');
                newWindow.document.write(`
                <html>
                    <head>
                        <title>Print Tabel</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                            }
                            h2, p {
                                margin: 0 0 10px 0;
                                text-align: center;
                            }
                            h2 {
                                margin-bottom: 20px;
                                text-align: center;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-top: 20px;
                            }
                            table, th, td {
                                border: 1px solid black;
                            }
                            th, td {
                                padding: 8px;
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <h2>Hasil Riwayat Pengecekan</h2>
                        <p>Nama: ${document.querySelector('.card-title.mt-4').innerText.split('= ')[1]}</p>
                        <p>Usia: ${document.querySelector('.card-title:nth-of-type(2)').innerText.split('= ')[1]}</p>
                        <p>Telepon: ${document.querySelector('.card-title:nth-of-type(3)').innerText.split('= ')[1]}</p>
                        ${tableContent}
                    </body>
                 </html>
            `);
                newWindow.document.close();
                newWindow.print();
            }
        </script>
    </div>

    {{-- </div> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function fetchRealtimeData() {
                fetch(`/penyakit/realtime/{{ $pasien->id }}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            const gulaDarahElem = document.getElementById('gula_darah');
                            const bpmElem = document.getElementById('bpm');
                            const spo2Elem = document.getElementById('spo2');

                            if (gulaDarahElem) gulaDarahElem.innerText = data.gula_darah;
                            // if (kolesterolElem) kolesterolElem.innerText = data.kolesterol;
                            if (bpmElem) bpmElem.innerText = data.bpm;
                            if (spo2Elem) spo2Elem.innerText = data.spo2;
                        }
                    })
                    .catch(error => console.error('Error fetching real-time data:', error));
            }

            function fetchRealtimeTableData() {
                fetch(`/penyakit/realtime-table/{{ $pasien->id }}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            let tableBody = document.getElementById('tabelpenyakit-body');
                            tableBody.innerHTML = ''; // Clear the table body

                            data.forEach((row, index) => {
                                let formattedTime = moment(row.created_at).format(
                                    'DD-MM-YYYY HH:mm:ss');
                                let newRow = document.createElement('tr');
                                newRow.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${row.bpm}</td>
                                <td>${row.spo2}</td>
                                <td>${row.gula_darah} <span>mg/dl</span></td>
                                <td class="d-none d-xl-table-cell">${formattedTime}</td>
                            `;
                                tableBody.appendChild(newRow);
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching real-time table data:', error));
            }

            setInterval(fetchRealtimeData, 5000); // Fetch data every 5 seconds
            setInterval(fetchRealtimeTableData, 5000); // Fetch table data every 5 seconds
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
            var gradient = ctx.createLinearGradient(0, 0, 0, 225);
            gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
            gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

            var gulaDarahData = <?php echo $gula_darah_json; ?>;
            var labels = <?php echo $labels_json; ?>;

            var chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Gula Darah",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: window.theme.primary,
                        data: gulaDarahData
                    }, ]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true
                    },
                    tooltips: {
                        intersect: false
                    },
                    hover: {
                        intersect: true
                    },
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    scales: {
                        xAxes: [{
                            reverse: true,
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                stepSize: 100
                            },
                            display: true,
                            borderDash: [3, 3],
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }]
                    }
                }
            });

            function updateChart() {
                fetch('/chart/data/{{ $pasien->id }}') // Ganti dengan id_pasien yang diinginkan
                    .then(response => response.json())
                    .then(data => {
                        chart.data.labels = data.labels;
                        chart.data.datasets[0].data = data.gula_darah;
                        chart.update();
                    })
                    .catch(error => console.error("Error: ", error));
            }

            setInterval(updateChart, 5000);
            updateChart();
        });
    </script>
@endsection
