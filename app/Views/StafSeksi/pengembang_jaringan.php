<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">

    <h1 class="h3 mb-4 text-gray-800">Pemetaan Pengembangan Jaringan - Staf Seksi Database</h1>
    <!-- Page Heading -->
    <div class="col">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div id="alert-success" class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php elseif (session()->getFlashdata('error')) : ?>
                        <div id="alert-error" class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nomor Surat</th>
                                    <th style="text-align: center;">Nama Pekerjaan</th>
                                    <th style="text-align: center;">Jenis Pekerjaan</th>
                                    <th style="text-align: center;">Pelaksana</th>
                                    <th style="text-align: center;">Nilai Pekerjaan</th>
                                    <th style="text-align: center;">No. Tanggal SPK</th>
                                    <th style="text-align: center;">No. Tanggal BA Selesai Pekerjaan</th>
                                    <th style="text-align: center;">No. Tanggal BA Selesai Pembayaran</th>
                                    <th style="text-align: center;">Tanggal Masuk Berkas</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center; width: 200px;">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pemetaan)) : ?>
                                    <?php $no = 1;
                                    foreach ($pemetaan as $pemetaan_pj) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $pemetaan_pj['no_surat']; ?></td>
                                            <td><?= $pemetaan_pj['nama_pekerjaan']; ?></td>
                                            <td><?= $pemetaan_pj['jenis_pekerjaan']; ?></td>
                                            <td><?= $pemetaan_pj['pelaksana']; ?></td>
                                            <td>Rp. <?= number_format($pemetaan_pj['nilai_pekerjaan'], 0, ',', '.'); ?></td>
                                            <td><?= $pemetaan_pj['nt_spk']; ?></td>
                                            <td><?= $pemetaan_pj['nt_ba_selesai']; ?></td>
                                            <td><?= $pemetaan_pj['nt_ba_pembayaran']; ?></td>
                                            <td><?= $pemetaan_pj['tgl_masuk_berkas']; ?></td>
                                            <td>
                                                <?php if ($pemetaan_pj['status'] == 'Proses Verifikasi') : ?>
                                                    <span class="btn btn-warning btn-sm"><?= $pemetaan_pj['status']; ?></span>
                                                <?php elseif ($pemetaan_pj['status'] == 'Terverifikasi') : ?>
                                                    <span class="btn btn-success btn-sm"><?= $pemetaan_pj['status']; ?></span>
                                                <?php elseif ($pemetaan_pj['status'] == 'Ditolak') : ?>
                                                    <span class="btn btn-danger btn-sm"><?= $pemetaan_pj['status']; ?></span>
                                                <?php else : ?>
                                                    <span class="btn btn-secondary btn-sm"><?= $pemetaan_pj['status']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('StafSeksi/view_pj/' . $pemetaan_pj['id']); ?>" class="btn btn-sm btn-info" style="margin-right: 5px;">View</a>

                                                    <a href="<?= base_url('StafSeksi/edit_pj/' . $pemetaan_pj['id']); ?>" class="btn btn-sm btn-primary" style="margin-right: 5px;">Edit</a>

                                                    <a href="<?= base_url('StafSeksi/surat_keterangan_pj/' . $pemetaan_pj['id']); ?>" class="btn btn-sm btn-success" style="margin-right: 5px;" target="_blank">Cetak</a>

                                                    <a href="<?= base_url('StafSeksi/delete_pj/' . $pemetaan_pj['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete();">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="10">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>

<!-- Tambahkan skrip JavaScript untuk konfirmasi hapus -->
<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus data ini?');
    }
    // Function to auto-hide alerts
    function autoHideAlert(alertId, duration) {
        var alertElement = document.getElementById(alertId);
        if (alertElement) {
            setTimeout(function() {
                alertElement.style.display = 'none';
            }, duration);
        }
    }

    // Auto-hide success and error alerts after 5 seconds
    autoHideAlert('alert-success', 5000);
    autoHideAlert('alert-error', 5000);
</script>