<?php $session = session(); ?>

<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Profile</h1>
    <div class="col">

        <!-- Content Column -->
        <div class="col">
            <div class="col-14 grid-margin">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center mb-4">
                                <!-- Tampilkan gambar profil dengan src dinamis -->
                                <img src="<?= base_url('/Assets/foto/' . $session->get('profile')) ?>" id="profileImage" class="img-fluid rounded-circle" alt="Profile Picture" style="width: 250px;">
                            </div>
                            <div class="col-md-8 text-center d-flex flex-column align-items-start">
                                <h5>Email: <?= $session->get('email') ?></h5>
                                <h5>Username: <?= $session->get('username') ?></h5>
                                <h5>Nama Lengkap: <?= $session->get('nama_lengkap') ?></h5>
                                <h5>Deskripsi: <?= $session->get('deskripsi') ?></h5>
                                <!-- Button to trigger modal -->
                                <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#editProfileModal">
                                    Edit Profil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateProfileForm" action="<?= base_url('Instalatir/update_profile') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $session->get('email') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $session->get('username') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $session->get('nama_lengkap') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Upload Foto Profil Baru</label>
                            <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
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

    <!-- JavaScript to handle form submission and update profile picture -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('updateProfileForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update profile image src with new image URL
                            document.getElementById('profileImage').src = data.newProfilePictureUrl;
                            alert(data.message); // Show success message
                            $('#editProfileModal').modal('hide'); // Hide modal
                        } else {
                            alert(data.message); // Show error message
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</div>