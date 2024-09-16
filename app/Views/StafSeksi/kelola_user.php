<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Kelola User</h1>

    <!-- Page Heading -->
    <div class="col">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <center>
                        <button type="button" class="btn btn-primary shadow" data-toggle="modal" data-target="#myModal"> <i class="fas fa-plus fa-sm"></i>
                            Tambah User
                        </button>
                    </center>
                </div>
                <div class="card-body">
                    <!-- Modal Feedback -->
                    <?php
                    $session = session(); // Inisialisasi session
                    ?>
                    <?php if ($session->getFlashdata('success')) : ?>
                        <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="feedbackModalLabel">Berhasil</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?= $session->getFlashdata('success'); ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($session->getFlashdata('error')) : ?>
                        <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="feedbackModalLabel">Gagal</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?= $session->getFlashdata('error'); ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Deskripsi</th>
                                    <th>Profile</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $session = session();
                                $current_user_id = $session->get('id_user'); // ID user yang sedang login
                                ?>
                                <?php if (!empty($users)) : ?>
                                    <?php $no = 1;
                                    foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $user['email']; ?></td>
                                            <td><?= $user['nama_lengkap']; ?></td>
                                            <td><?= $user['username']; ?></td>
                                            <td><?= $user['level']; ?></td>
                                            <td><?= $user['deskripsi']; ?></td>
                                            <td>
                                                <img src="<?= base_url('Assets/foto/' . $user['profile']); ?>" alt="Profile Image" width="50">
                                            </td>
                                            <td>
                                                <center>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $user['id_user']; ?>">
                                                        Edit
                                                    </button>
                                                    <?php if ($current_user_id != $user['id_user']) : ?>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?= $user['id_user']; ?>">
                                                            Hapus
                                                        </button>
                                                    <?php else : ?>
                                                        <button type="button" class="btn btn-danger btn-sm" disabled>
                                                            Hapus
                                                        </button>
                                                    <?php endif; ?>
                                                </center>
                                            </td>

                                            <!-- Modal Edit User -->
                                            <div class="modal fade" id="modalEdit<?= $user['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel<?= $user['id_user']; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalEditLabel<?= $user['id_user']; ?>">Edit User</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="<?= base_url('StafSeksi/update_user/' . $user['id_user']); ?>" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="email_edit<?= $user['id_user']; ?>">Email</label>
                                                                    <input type="text" class="form-control" id="email_edit<?= $user['id_user']; ?>" name="email_edit" value="<?= $user['email']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nama_lengkap_edit<?= $user['id_user']; ?>">Nama Lengkap</label>
                                                                    <input type="text" class="form-control" id="nama_lengkap_edit<?= $user['id_user']; ?>" name="nama_lengkap_edit" value="<?= $user['nama_lengkap']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="username_edit<?= $user['id_user']; ?>">Username</label>
                                                                    <input type="text" class="form-control" id="username_edit<?= $user['id_user']; ?>" name="username_edit" value="<?= $user['username']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="password_edit<?= $user['id_user']; ?>">Password</label>
                                                                    <input type="password" class="form-control" id="password_edit<?= $user['id_user']; ?>" name="password_edit">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="level_edit<?= $user['id_user']; ?>">Level</label>
                                                                    <select class="form-control" id="level_edit<?= $user['id_user']; ?>" name="level_edit" required>

                                                                        <option value="1" <?= ($user['level'] == 1) ? 'selected' : ''; ?>>Staf Seksi Database</option>

                                                                        <option value="2" <?= ($user['level'] == 2) ? 'selected' : ''; ?>>Kepala Seksi</option>

                                                                        <option value="3" <?= ($user['level'] == 3) ? 'selected' : ''; ?>>Direktur</option>

                                                                        <option value="4" <?= ($user['level'] == 4) ? 'selected' : ''; ?>>Instalatir</option>

                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="deskripsi_edit<?= $user['id_user']; ?>">Deskripsi</label>
                                                                    <select class="form-control" id="deskripsi_edit<?= $user['id_user']; ?>" name="deskripsi_edit" required>

                                                                        <option value="Staf Seksi" <?= ($user['deskripsi'] == 'Staf Seksi') ? 'selected' : ''; ?>>Staf Seksi Database</option>

                                                                        <option value="Kepala Seksi" <?= ($user['deskripsi'] == 'Kepala Seksi') ? 'selected' : ''; ?>>Kepala Seksi</option>

                                                                        <option value="Direktur" <?= ($user['deskripsi'] == 'Direktur') ? 'selected' : ''; ?>>Direktur</option>

                                                                        <option value="Instalatir" <?= ($user['deskripsi'] == 'Instalatir') ? 'selected' : ''; ?>>Instalatir</option>

                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="profile_edit<?= $user['id_user']; ?>">Profile Image</label>
                                                                    <input type="file" class="form-control-file" id="profile_edit<?= $user['id_user']; ?>" name="profile_edit">
                                                                    <input type="hidden" name="old_profile" value="<?= $user['profile']; ?>">

                                                                    <br>
                                                                    <img src="<?= base_url('Assets/foto/' . $user['profile']); ?>" alt="Profile Image" width="100">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade" id="modalDelete<?= $user['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel<?= $user['id_user']; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalDeleteLabel<?= $user['id_user']; ?>">Konfirmasi Hapus User</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus user <?= $user['nama_lengkap']; ?>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                                                            <a href="<?= base_url('StafSeksi/delete_user/' . $user['id_user']); ?>" class="btn btn-danger">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8">No data available</td>
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
<!-- End of Main Content -->

<!-- Modal Tambah User -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('StafSeksi/simpan_user'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" id="level" name="level" required>
                            <option value="1">Staf Seksi</option>
                            <option value="2">Kepala Seksi</option>
                            <option value="3">Direktur</option>
                            <option value="4">Instalatir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <select class="form-control" id="deskripsi" name="deskripsi" required>
                            <option value="Staf Seksi">Staf Seksi</option>
                            <option value="Kepala Seksi">Kepala Seksi</option>
                            <option value="Direktur">Direktur</option>
                            <option value="Instalatir">Instalatir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile">Profile Image</label>
                        <input type="file" class="form-control-file" id="profile" name="profile">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include JS Libraries -->
<script src="<?= base_url('path/to/jquery.min.js'); ?>"></script>
<script src="<?= base_url('path/to/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('path/to/datatables.min.js'); ?>"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>