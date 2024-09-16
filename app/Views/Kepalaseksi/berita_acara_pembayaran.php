<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">
    <h1 class="h3 mb-4 text-gray-800">Berita Acara Pembayaran</h1>
    <!-- Page Heading -->
    <div class="col">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">No. Berita Acara</th>
                                    <th style="text-align: center;">Nama Pekerjaan</th>
                                    <th style="text-align: center;">Nama Pihak Pertama</th>
                                    <th style="text-align: center;">Nama Pihak Kedua</th>
                                    <th style="text-align: center;">No. Surat Permohonan Pembayaran</th>
                                    <th style="text-align: center;">No.Surat Perintah Kerja</th>
                                    <th style="text-align: center;">Nilai Pekerjaan</th>
                                    <th style="text-align: center;">PPN</th>
                                    <th style="text-align: center;">Total</th>
                                    <th style="text-align: center;">Nama Perusahaan Pihak Kedua</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pemetaan)) : ?>
                                    <?php $no = 1;
                                    foreach ($pemetaan as $pemetaan_ba) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $pemetaan_ba['nomor_ba']; ?></td>
                                            <td><?= $pemetaan_ba['nama_pekerjaan']; ?></td>
                                            <td><?= $pemetaan_ba['nama_ph1']; ?></td>
                                            <td><?= $pemetaan_ba['nama_ph2']; ?></td>
                                            <td><?= $pemetaan_ba['surat_permohonan_bayar']; ?></td>
                                            <td><?= $pemetaan_ba['nt_spk']; ?></td>
                                            <td>Rp. <?= number_format($pemetaan_ba['nilai_pekerjaan'], 0, ',', '.'); ?></td>
                                            <td>Rp. <?= number_format($pemetaan_ba['ppn'], 0, ',', '.'); ?></td>
                                            <td>Rp. <?= number_format($pemetaan_ba['total'], 0, ',', '.'); ?></td>
                                            <td><?= $pemetaan_ba['pelaksana']; ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('Kepalaseksi/view_ba/' . $pemetaan_ba['id_ba']); ?>" class="btn btn-sm btn-info" style="margin-right: 5px;">View</a>

                                                    <a href="<?= base_url('Kepalaseksi/cetak_berita_acara/' . $pemetaan_ba['id_ba']); ?>" class="btn btn-sm btn-primary" style="margin-right: 5px;" target="_blank">Cetak</a>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="17">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>