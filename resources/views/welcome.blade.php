@extends('layouts.template')

@section('content')
<style>
    /* Styling for Dashboard Cards */
    .dashboard-card {
        background-color: #f8f9fa;
        color: #2C3941;
        margin-bottom: 25px;
        border-radius: 8px;
        transition: transform 0.2s ease-in-out;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        border-color: #dcdcdc;
    }

    .dashboard-card .card-icon {
        font-size: 35px;
        margin-left: auto;
        opacity: 0.7;
        color: #4f83cc;
    }

    .dashboard-card .card-icon {
        font-size: 30px;
        opacity: 0.7;
    }

    .dashboard-card h6 {
        margin: 0;
        font-size: 16px;
    }

    .dashboard-card h4 {
        margin: 5px 0;
        font-size: 24px;
    }

    .progress {
        height: 10px;
        margin-top: 10px;
        border-radius: 6px;

    }

    /* Style Event Mendatang */
    .events-card {
        margin-top: 20px;
    }

    .event-list {
        padding: 0;
        list-style: none;
    }

    .event-list li {
        padding: 10px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .event-list li:last-child {
        border-bottom: none;
    }

    .event-date {
        font-weight: bold;
        color: #2c3941;
    }

    /* Style Statistik Dosen */
    .lecturer-card {
        background-color: #2C3941;
        color: #ffffff;
        margin-bottom: 15px;
        border-radius: 8px;
    }

    .lecturer-card .card-body {
        padding: 15px;
    }

    .progress-bar {
        background-color: #4f83cc;
    }

    .certification-card {
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    .card-image {
        width: 100%;
        height: auto;
        /* Change this to 'auto' to maintain aspect ratio */
        object-fit: cover;
        border-radius: 24px;
        aspect-ratio: 16 / 9;
        /* Set the desired aspect ratio */
    }

    /* Menyesuaikan gambar potret agar menjadi landscape */
    .card-image {
        aspect-ratio: 16 / 9;
        /* Menetapkan rasio aspek landscape */
        object-fit: cover;
        /* Menutup seluruh area card */
    }

    .hover-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 24px;
        background: linear-gradient(to bottom, rgba(196, 196, 196, 0.75) 0%, rgba(1, 86, 158, 0.3) 50%, rgba(1, 86, 158, 0.75) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Efek hover */
    .certification-card:hover .hover-gradient {
        opacity: 1;
    }

    .card-custom {
        float: right;
        background-color: #2C3941;
        color: white;
        border: none;
        border-radius: 10px;
        text-align: center;
        width: 46px;
        /* Ukuran card menjadi 46px */
        height: 46px;
        /* Ukuran card menjadi 46px */
    }

    .icon {
        font-size: 1.5rem;
        /* Ukuran ikon menjadi lebih kecil */
        cursor: pointer;
        line-height: 46px;
        /* Menjaga posisi ikon tetap di tengah */
    }

    #barChart {
        width: 100%;
        height: auto;
    }


    .hidden {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Dashboard Cards with Modern Minimalist Style -->
        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h6>Total Pengguna</h6>
                        <h4>150</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <i class="bi bi-people-fill card-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h6>Total Sertifikasi</h6>
                        <h4>75</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <i class="bi bi-award-fill card-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h6>Total Pelatihan</h6>
                        <h4>45</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <i class="bi bi-journal-text card-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h6>Total Vendor</h6>
                        <h4>20</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 40%;" aria-valuenow="40"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <i class="bi bi-building card-icon"></i>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <!-- Lecturer Statistics -->
    <div class="row mt-4">
        <div class="col-12">
            <h5>Statistik Dosen</h5>
        </div>

        <!-- BANNI SATRIA ANDOKO -->
        <div class="col-lg-3 col-md-6">
            <div class="card lecturer-card shadow-sm">
                <div class="card-body">
                    <h6>BANNI SATRIA ANDOKO</h6>
                    <p>Sertifikasi: 3 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60"
                            aria-valuemin="0" aria-valuemax="100">60%</div>
                    </div>
                    <p class="mt-2">Pelatihan: 4 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROKHIMATUL WAKHIDAH -->
        <div class="col-lg-3 col-md-6">
            <div class="card lecturer-card shadow-sm">
                <div class="card-body">
                    <h6>ROKHIMATUL WAKHIDAH</h6>
                    <p>Sertifikasi: 4 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>
                    <p class="mt-2">Pelatihan: 3 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60"
                            aria-valuemin="0" aria-valuemax="100">60%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EKA LARASATI AMALIA -->
        <div class="col-lg-3 col-md-6 lecturer-card-extra hidden">
            <div class="card lecturer-card shadow-sm">
                <div class="card-body">
                    <h6>EKA LARASATI AMALIA</h6>
                    <p>Sertifikasi: 2 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 40%;" aria-valuenow="40"
                            aria-valuemin="0" aria-valuemax="100">40%</div>
                    </div>
                    <p class="mt-2">Pelatihan: 3 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60"
                            aria-valuemin="0" aria-valuemax="100">60%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADE ISMAIL -->
        <div class="col-lg-3 col-md-6 lecturer-card-extra hidden">
            <div class="card lecturer-card shadow-sm">
                <div class="card-body">
                    <h6>ADE ISMAIL</h6>
                    <p>Sertifikasi: 5 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                    <p class="mt-2">Pelatihan: 4 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FARID ANGGA PRIBADI -->
        <div class="col-lg-3 col-md-6 lecturer-card-extra hidden">
            <div class="card lecturer-card shadow-sm">
                <div class="card-body">
                    <h6>FARID ANGGA PRIBADI</h6>
                    <p>Sertifikasi: 5 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                    <p class="mt-2">Pelatihan: 4 / 5</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View All / View Less Button -->
        <div class="col-12 mt-3">
            <button id="toggleLecturers" class="btn btn-primary">Lihat Semua</button>
        </div>
    </div>
    <hr>
    <br>

    <!-- Main Content Area with Bar Chart and Upcoming Events -->
    <div class="row">

        <!-- Bar Chart Section -->
        <div class="col-lg-8 col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Sertifikasi dan Pelatihan Kurun Waktu 1 Tahun</h6>
                    <br>
                    <div id="barChart" style="height: 300px; width: 100%;"></div> <!-- Posisikan di dalam card-body -->
                </div>
            </div>
        </div>


        <!-- Upcoming Events Section -->
        <div class="col-lg-4">
            <div class="card shadow-sm events-card">
                <div class="card-body">
                    <ul class="event-list">
                        <h4>Event Mendatang</h4>
                        <hr>
                        <li>
                            <span class="event-date">Nov 15, 2024</span> - Sertifikasi Java Programming
                        </li>
                        <li>
                            <span class="event-date">Dec 02, 2024</span> - Pelatihan Data Science
                        </li>
                        <li>
                            <span class="event-date">Dec 10, 2024</span> - Workshop on AI in Education
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <br>

    <div class="row" style="display: flex; flex-wrap: wrap; justify-content: flex-end; align-items: flex-start;">
        <div class="col-lg-2">
            <div class="card card-custom">
                <i class="bi bi-filter icon" title="Filter" onclick="filterFunction()"></i>
                <p>Filter</p>
            </div>
        </div>
        <div class="col-mt-2">
            <div class="card card-custom">
                <i class="bi bi-calendar3 icon" title="Kalender" onclick="calendarFunction()"></i>
                <p>Kalender</p>
            </div>
        </div>
    </div>
    

    <div id="filterModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Filter options -->
                </div>
            </div>
        </div>
    </div>

    <div id="calendarModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kalender</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Calendar UI -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Gambar -->
        <div class="col-lg-4">
            <h4 style="color: #2C3941;">Rekomendasi Pelatihan & Sertifikasi</h4><br>
            <div class="card shadow-sm certification-card">
                <div class="card-body" style="padding: 0; overflow: hidden; border-radius: 24px; position: relative;">
                    <img src="{{ asset('vokasi.png') }}" alt="Deskripsi Gambar" class="card-image">
                    <div class="hover-gradient"></div>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="col-lg-6">
            <br><br>
            <div class="card-body">
                <h5>Program Non-Degree Peningkatan Kompetensi Dosen Vokasi 2024</h5>
                <p style="font-size: 14px; color: #666;">
                    Program Non-Degree Peningkatan Kompetensi Dosen (Program-NDPKD) merupakan program yang mendorong dan
                    memfasilitasi pendidikan tinggi vokasi membangun ekosistem dalam menyiapkan SDM menyongsong
                    Indonesia Emas 2045, melalui pelatihan dan sertifikasi kompetensi, profesi dan industri serta
                    peningkatan tata kelola pendidikan tinggi melalui pelatihan industri (magang) pada industri dan
                    perguruan tinggi luar negeri yang berpotensi global...
                </p>
                <button
                    style="background-color: #007bff; color: #fff; border: none; padding: 10px 16px; border-radius: 4px; cursor: pointer;">
                    Lihat selengkapnya
                </button>
            </div>
        </div>
        <br>

        <div class="col-lg-4">
            <h4>Informasi Sertifikasi</h4>
        </div>


    </div>


</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
     // Data untuk chart
     const monthlyData = [10, 20, 15, 25, 30, 50, 20, 25, 15, 20, 25, 18];
     const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
 
     // Konfigurasi bar chart
     const barOptions = {
         series: [{
             name: 'Monthly Data',
             data: monthlyData
         }],
         chart: {
             type: 'bar',
             height: '85%',
             width: '100%',
             toolbar: { show: false },
             background: '#f8f9fa',
             responsive: [{
                 breakpoint: 768,
                 options: {
                     chart: {
                         height: 250
                     },
                     plotOptions: {
                         bar: {
                             columnWidth: '60%'
                         }
                     }
                 }
             }, {
                 breakpoint: 576,
                 options: {
                     chart: {
                         height: 200
                     },
                     plotOptions: {
                         bar: {
                             columnWidth: '70%'
                         }
                     }
                 }
             }]
         },
         plotOptions: {
             bar: {
                 borderRadius: 5,
                 columnWidth: '50%',
                 distributed: true,
                 hover: {
                     enabled: true
                 }
             }
         },
         colors: Array(12).fill('#4f83cc'),
         xaxis: {
             categories: months,
             labels: {
                 style: {
                     colors: '#4f83cc',
                     fontSize: '12px'
                 }
             }
         },
         yaxis: {
             show: false
         },
         grid: {
             show: false
         },
         dataLabels: {
             enabled: false
         },
         tooltip: {
             enabled: true,
             theme: 'light',
             style: {
                 fontSize: '12px'
             },
             y: {
                 formatter: function(value) {
                     return value;
                 }
             }
         },
         stroke: {
             width: 0
         }
     };
 
     // Inisialisasi chart
     const barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
     barChart.render();
 
     // Fungsi untuk resize chart
     function resizeChart() {
         barChart.resize();
     }
 
     // Event listener untuk sidebar toggle
     document.getElementById("pushMenuButton").addEventListener("click", function() {
         setTimeout(resizeChart, 300); // Delay untuk memastikan animasi selesai sebelum resize
     });
 
     // Opsional: Resize saat window diubah ukurannya
     window.addEventListener("resize", resizeChart);
 });
</script>
<script>
    document.getElementById("toggleLecturers").addEventListener("click", function() {
        const extras = document.querySelectorAll(".lecturer-card-extra");
        const button = document.getElementById("toggleLecturers");
        
        extras.forEach(card => {
            card.classList.toggle("hidden");
        });
        
        if (button.textContent === "Lihat Semua") {
            button.textContent = "Lihat Lebih Sedikit";
        } else {
            button.textContent = "Lihat Semua";
        }
    });
</script>
<script>
    function filterFunction() {
    $('#filterModal').modal('show');
    // Add your filter logic here
}

function calendarFunction() {
    $('#calendarModal').modal('show');
    // Add your calendar logic here
}
</script>
@endsection