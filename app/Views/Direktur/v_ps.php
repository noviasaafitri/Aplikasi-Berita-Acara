<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">View Pemetaan Swadaya</h1>

    <!-- Content Column -->
    <div class="col">
        <div class="col-14 grid-margin">
            <div class="card shadow">
                <div class="card-header py-3">
                    <p><strong>Nama Pekerjaan:</strong> <?= esc($pemetaan['nama_pekerjaan']); ?></p>
                    <p><strong>Jenis Pekerjaan:</strong> <?= esc($pemetaan['jenis_pekerjaan']); ?></p>
                    <p><strong>Pelaksana:</strong> <?= esc($pemetaan['pelaksana']); ?></p>
                    <p><strong>Lokasi:</strong> <?= esc($pemetaan['lokasi']); ?></p>
                    <p><strong>Bagian:</strong> <?= esc($pemetaan['bagian']); ?></p>
                    <p><strong>Nilai Pekerjaan:</strong> Rp. <?= number_format($pemetaan['nilai_pekerjaan'], 0, ',', '.'); ?></p>
                    <p><strong>No. Tanggal SPK:</strong> <?= esc($pemetaan['nt_spk']); ?></p>
                    <p><strong>No. Tanggal BA Selesai Pekerjaan:</strong> <?= esc($pemetaan['nt_ba_selesai']); ?></p>
                    <p><strong>No. Tanggal BA Selesai Pembayaran:</strong> <?= esc($pemetaan['nt_ba_pembayaran']); ?></p>
                    <p><strong>Tanggal Masuk Berkas:</strong> <?= esc($pemetaan['tgl_masuk_berkas']); ?></p>
                    <p><strong>Berkas:</strong> <?= esc($pemetaan['berkas']); ?></p>
                    <p><strong>Keterangan:</strong> <?= esc($pemetaan['keterangan']); ?></p>
                    <p><strong>Catatan:</strong> <?= esc($pemetaan['catatan']); ?></p>
                    <p><strong>Status:</strong>
                        <?php
                        $status = esc($pemetaan['status']);
                        if ($status == 'Proses Verifikasi') {
                            echo '<span class="btn btn-warning btn-sm">' . $status . '</span>';
                        } elseif ($status == 'Terverifikasi') {
                            echo '<span class="btn btn-success btn-sm">' . $status . '</span>';
                        } elseif ($status == 'Ditolak') {
                            echo '<span class="btn btn-danger btn-sm">' . $status . '</span>';
                        }
                        ?>
                    </p>
                    <div>
                        <div>
                            <p><strong>Button Untuk Melakukan Verifikasi Data:</p>
                            <a href="<?= site_url('Direktur/update_status_by_kategori_ps/Pemetaan Swadaya/terverifikasi/' . esc($pemetaan['id'])); ?>" class="btn btn-success">Verifikasi</a>
                            <a href="<?= site_url('Direktur/update_status_by_kategori_ps/Pemetaan Swadaya/ditolak/' . esc($pemetaan['id'])); ?>" class="btn btn-danger">Ditolak</a>
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="feedbackModalLabel">Pesan</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="feedbackMessage">
                                        <?php if (session()->getFlashdata('success')) : ?>
                                            <div class="alert alert-success">
                                                <?= session()->getFlashdata('success'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('error')) : ?>
                                            <div class="alert alert-danger">
                                                <?= session()->getFlashdata('error'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#pdfModal">
                            Lihat Berkas Permohonan
                        </button>
                        <a href="<?= site_url('Direktur/pemetaan_swadaya'); ?>" class="btn btn-primary">Kembali</a>
                        <!-- Button to open PDF modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for PDF Viewer -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Berkas Permohonan Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Embed PDF in iframe -->
                <iframe src="<?= base_url('Assets/Berkas/' . esc($pemetaan['berkas'])); ?>" width="100%" height="500px" style="border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Page Content -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success') || session()->getFlashdata('error')) : ?>
            $('#feedbackModal').modal('show');
        <?php endif; ?>
    });
</script>