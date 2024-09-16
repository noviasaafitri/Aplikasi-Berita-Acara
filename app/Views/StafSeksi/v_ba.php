<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">View Berita Acara Pembayaran</h1>

    <!-- Content Column -->
    <div class="col">
        <div class="col-14 grid-margin">
            <div class="card shadow">
                <div class="card-header py-3">
                    <div class="card-body">
                        <p><strong>Nomor Berita Acara: </strong> <?= esc($pemetaan['nomor_ba']); ?></p>
                        <p><strong>Nama Pekerjaan: </strong> <?= esc($pemetaan['nama_pekerjaan']); ?></p>
                        <p><strong>Nama Pihak Pertama: </strong> <?= esc($pemetaan['nama_ph1']); ?></p>
                        <p><strong>Jabatan Pihak Pertama: </strong> <?= esc($pemetaan['jabatan_ph1']); ?></p>
                        <p><strong>Alamat Pihak Pertama: </strong> <?= esc($pemetaan['alamat_ph1']); ?></p>
                        <p><strong>Nama Pihak Kedua: </strong> <?= esc($pemetaan['nama_ph2']); ?></p>
                        <p><strong>Jabatan Pihak Kedua: </strong> <?= esc($pemetaan['jabatan_ph2']); ?></p>
                        <p><strong>Alamat Pihak kedua: </strong> <?= esc($pemetaan['alamat_ph2']); ?></p>
                        <p><strong>No. Surat Permohonan Pembayaran: </strong> <?= esc($pemetaan['surat_permohonan_bayar']); ?></p>
                        <p><strong>No. Surat Perintah Kerja: </strong> <?= esc($pemetaan['nt_spk']); ?></p>
                        <p><strong>Nilai Pekerjaan: </strong> Rp. <?= number_format($pemetaan['nilai_pekerjaan'], 0, ',', '.'); ?></p>
                        <p><strong>PPN : </strong> Rp. <?= number_format($pemetaan['ppn'], 0, ',', '.'); ?></p>
                        <p><strong>Total: </strong> Rp. <?= number_format($pemetaan['total'], 0, ',', '.'); ?></p>
                        <p><strong>Terbilang : </strong> <?= esc($pemetaan['terbilang']); ?></p>
                        <p><strong>Lokasi: </strong> <?= esc($pemetaan['lokasi']); ?></p>
                        <p><strong>Nama Perusahaan Pihak Kedua: </strong> <?= esc($pemetaan['pelaksana']); ?></p>
                        <p><strong>Hari: </strong> <?= esc($pemetaan['hari']); ?></p>
                        <p><strong>Tanggal: </strong> <?= esc($pemetaan['tanggal']); ?></p>
                        <p><strong>Bulan: </strong> <?= esc($pemetaan['bulan']); ?></p>
                        <p><strong>Tahun: </strong> <?= esc($pemetaan['tahun']); ?></p>

                        <div style="text-align: right;">
                            <a href="<?= site_url('Stafseksi/berita_acara'); ?>" class="btn btn-danger">Kembali</a>
                            <!-- Button to open PDF modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Page Content -->