<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Pemetaan Swadaya - Instalatir</h1>

    <!-- Page Heading -->
    <div class="col">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <center>
                        <button type="button" class="btn btn-primary shadow" data-toggle="modal" data-target="#myModal"> <i class="fas fa-plus fa-sm"></i>
                            Tambah Pekerjaan
                        </button>
                    </center>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <!-- Modal Pesan Sukses -->
                        <div class="modal fade" id="pesanSuksesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Success!!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?= session()->getFlashdata('success') ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <!-- Modal Pesan Error -->
                        <div class="modal fade" id="pesanErrorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Error!!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>
                                        <center>No</center>
                                    </th>
                                    <th>
                                        <center>Nama Pekerjaan</center>
                                    </th>
                                    <th>
                                        <center>Pelaksana</center>
                                    </th>
                                    <th>
                                        <center>Berkas</center>
                                    </th>
                                    <th style="text-align: center;">Status</th>
                                    <!-- <th style="text-align: center;">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pemetaan)) : ?>
                                    <?php $no = 1;
                                    foreach ($pemetaan as $pemetaan_s) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $pemetaan_s['nama_pekerjaan']; ?></td>
                                            <td><?= $pemetaan_s['pelaksana']; ?></td>
                                            <td><?= $pemetaan_s['berkas']; ?></td>
                                            <td>
                                                <?php if ($pemetaan_s['status'] == 'Proses Verifikasi') : ?>
                                                    <span class="btn btn-warning btn-sm"><?= $pemetaan_s['status']; ?></span>
                                                <?php elseif ($pemetaan_s['status'] == 'Terverifikasi') : ?>
                                                    <span class="btn btn-success btn-sm"><?= $pemetaan_s['status']; ?></span>
                                                <?php elseif ($pemetaan_s['status'] == 'Ditolak') : ?>
                                                    <span class="btn btn-danger btn-sm"><?= $pemetaan_s['status']; ?></span>
                                                <?php else : ?>
                                                    <span class="btn btn-secondary btn-sm"><?= $pemetaan_s['status']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <!-- <td>
                                                <button type="button" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#pdfModal" data-pdf="<?= base_url('Assets/Berkas/' . $pemetaan_s['berkas']); ?>">Lihat Berkas</button>
                                            </td> -->
                                        </tr>
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
                                                        <iframe src="<?= base_url('Assets/Berkas/' . esc($pemetaan_s['berkas'])); ?>" width="100%" height="500px" style="border: none;"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6">No data available</td>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/instalatir/simpan_pekerjaan_ps'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_pekerjaan">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="pelaksana">Pelaksana</label>
                        <input type="text" class="form-control" id="pelaksana" name="pelaksana" required>
                    </div>
                    <div class="form-group">
                        <label for="berkas">Berkas</label>
                        <input type="file" class="form-control" id="berkas" name="berkas" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>