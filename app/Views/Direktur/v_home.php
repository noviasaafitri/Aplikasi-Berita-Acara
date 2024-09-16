<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 ">Home - Direktur</h1>
    <div class="col">

        <!-- Content Row -->
        <div class="row justify-content-center">
            <!-- Proses Verifikasi Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 mx-auto">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Proses Verifikasi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= isset($jumlah_proses_verifikasi) ? $jumlah_proses_verifikasi : 'Data tidak tersedia' ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2 mx-auto">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Ditolak
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_ditolak ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2 mx-auto">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Terverifikasi</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $jumlah_verifikasi ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Content Column -->
        <div class="col-lg-12 mb-14">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="card-header py-3 text-center">
                        <h6 class="m-0 font-weight-bold text-primary">Selamat Datang</h6>
                    </div>
                    <div class="card-body text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width:450px;" src="<?= base_url() ?>/Assets/img/logo_perumda.png" alt="logo">
                    </div>

                    <br>
                    <br>
                    <br>
                    <center>
                        <p>Selamat Datang Di Aplikasi E-BILLING PERUMDA </p>
                        <p>Aplikasi ini digunakan untuk membuat, mencetak, menyimpan berkas yang dikirimkan dari instalatir kepada Perumda dalam upaya pembuatan berita acara</p>
                    </center>
                    <!-- <p class="text-center">Selamat Datang Di Aplikasi Berita Acara PDAM </p>
                    <p class="text-center">Aplikasi ini digunakan untuk membuat, mencetak, menyimpan berkas yang dikirimkan dari instalatir kepada PDAM dalam upaya pembuatan berita acara</p> -->
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->