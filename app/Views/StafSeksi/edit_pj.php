<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Pemetaan Pengembangan Jaringan - Staf Seksi Database</h1>
    <div class="col">
        <div class="col-14 grid-margin">
            <div class="card shadow">
                <div class="card-body">

                    <form method="POST" action="<?= base_url('StafSeksi/update_pj/' . $pemetaan['id']) ?>" class="form-sample">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jenis Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <?php
                                        // Decode JSON keterangan untuk digunakan dalam form
                                        $keterangan_data = json_decode($pemetaan['keterangan'], true);
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Pengembangan Jaringan Pipa" id="checkbox1" name="jenis_pekerjaan[]" <?= in_array('Pengembangan Jaringan Pipa', explode(',', $pemetaan['jenis_pekerjaan'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="checkbox1">
                                                Pengembangan Jaringan Pipa
                                            </label>
                                            <input type="text" class="form-control mt-2" placeholder="Keterangan" name="keterangan_pengembangan" value="<?= $keterangan_data['Pengembangan Jaringan Pipa'] ?? '' ?>">
                                        </div>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="Rehabilitasi Jaringan Pipa" id="checkbox2" name="jenis_pekerjaan[]" <?= in_array('Rehabilitasi Jaringan Pipa', explode(',', $pemetaan['jenis_pekerjaan'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="checkbox2">
                                                Rehabilitasi Jaringan Pipa
                                            </label>
                                            <input type="text" class="form-control mt-2" placeholder="Keterangan" name="keterangan_rehabilitasi" value="<?= $keterangan_data['Rehabilitasi Jaringan Pipa'] ?? '' ?>">
                                        </div>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="Perbaikan Kebocoran Pipa" id="checkbox3" name="jenis_pekerjaan[]" <?= in_array('Perbaikan Kebocoran Pipa', explode(',', $pemetaan['jenis_pekerjaan'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="checkbox3">
                                                Perbaikan Kebocoran Pipa
                                            </label>
                                            <input type="text" class="form-control mt-2" placeholder="Keterangan" name="keterangan_rkebocoran" value="<?= $keterangan_data['Perbaikan Kebocoran Pipa'] ?? '' ?>">
                                        </div>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="Pindah Tapping/PE-Nisasi" id="checkbox4" name="jenis_pekerjaan[]" <?= in_array('Pindah Tapping/PE-Nisasi', explode(',', $pemetaan['jenis_pekerjaan'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="checkbox4">
                                                Pindah Tapping/PE-Nisasi
                                            </label>
                                            <input type="text" class="form-control mt-2" placeholder="Keterangan" name="keterangan_pindah" value="<?= $keterangan_data['Pindah Tapping/PE-Nisasi'] ?? '' ?>">
                                        </div>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" value="Lain-lain" id="checkbox5" name="jenis_pekerjaan[]" <?= in_array('Lain-lain', explode(',', $pemetaan['jenis_pekerjaan'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="checkbox5">
                                                Lain-lain
                                            </label>
                                            <input type="text" class="form-control mt-2" placeholder="Keterangan" name="keterangan_lain" value="<?= $keterangan_data['Lain-lain'] ?? '' ?>">
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor Surat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="no_surat" value="<?= $pemetaan['no_surat'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_pekerjaan" value="<?= $pemetaan['nama_pekerjaan'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Lokasi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="lokasi" value="<?= $pemetaan['lokasi'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nilai Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nilai_pekerjaan" name="nilai_pekerjaan" value="Rp <?= number_format($pemetaan['nilai_pekerjaan'], 0, ',', '.') ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Pelaksana</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="pelaksana" value="<?= $pemetaan['pelaksana'] ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Bagian</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bagian" value="<?= $pemetaan['bagian'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor & Tanggal SPK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nt_spk" value="<?= $pemetaan['nt_spk'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor & Tanggal BA Perubahan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nt_ba_perubahan" value="<?= $pemetaan['nt_ba_perubahan'] ?>" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor & Tanggal BA Selesai Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nt_ba_selesai" value="<?= $pemetaan['nt_ba_selesai'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor & Tanggal BA Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nt_ba_pembayaran" value="<?= $pemetaan['nt_ba_pembayaran'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal Masuk Berkas</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="tgl_masuk_berkas" value="<?= $pemetaan['tgl_masuk_berkas'] ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Kepala Seksi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_kepsek" id="nama_kepsek" value="<?= $pemetaan['nama_kepsek'] ?>" required />
                                        <div class="invalid-feedback" id="nama_kepsek_error">Nama Kepala Seksi hanya boleh menggunakan huruf.</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">NIK Kepala Seksi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nik_kepsek" value="<?= $pemetaan['nik_kepsek'] ?>" pattern="\d+" title="Hanya angka yang diperbolehkan" required />
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Penginput</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_penginput" id="nama_penginput" value="<?= $pemetaan['nama_penginput'] ?>" required />
                                        <div class="invalid-feedback" id="nama_penginput_error">Nama Penginput hanya boleh menggunakan huruf.</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">NIK Penginput</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nik_penginput" value="<?= $pemetaan['nik_penginput'] ?>" pattern="\d+" title="Hanya angka yang diperbolehkan" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label class="col-sm-2 col-form-label">Catatan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="4" name="catatan"><?= $pemetaan['catatan'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div style="text-align: right;">
                                <a href="<?= base_url('StafSeksi/pengembang_jaringan'); ?>" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nilai_pekerjaan').on('input', function() {
            var value = $(this).val().replace(/Rp\s?/, '').replace(/\./g, '').replace(',', '.');
            // Check if value is not empty and is a number
            if (value === '' || isNaN(value)) {
                $(this).val(''); // Clear the input if value is not a number
            } else {
                $(this).val('Rp ' + parseFloat(value).toLocaleString('id-ID'));
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        function validateInput(event) {
            const input = event.target;
            // Pattern untuk hanya huruf, spasi, koma, dan titik
            const pattern = /^[A-Za-z\s,.]+$/;
            const errorElement = document.getElementById(`${input.id}_error`);

            if (!pattern.test(input.value)) {
                input.classList.add('is-invalid');
                errorElement.style.display = 'block';
            } else {
                input.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        }

        const inputs = document.querySelectorAll('input[name="nama_penginput"], input[name="nama_kepsek"]');

        inputs.forEach(input => {
            input.addEventListener('input', validateInput);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function validateNumericInput(event) {
            const input = event.target;
            const pattern = /^\d*$/; // Pola untuk hanya angka

            if (!pattern.test(input.value)) {
                input.classList.add('is-invalid');
                if (!document.getElementById(`${input.name}_error`)) {
                    const errorElement = document.createElement('small');
                    errorElement.id = `${input.name}_error`;
                    errorElement.classList.add('form-text', 'text-danger');
                    errorElement.textContent = 'Hanya angka yang diperbolehkan';
                    input.parentElement.appendChild(errorElement);
                }
            } else {
                input.classList.remove('is-invalid');
                const errorElement = document.getElementById(`${input.name}_error`);
                if (errorElement) {
                    errorElement.remove();
                }
            }
        }

        // Pilih semua input dengan nama 'nik_kepsek' dan 'nik_penginput'
        const inputs = document.querySelectorAll('input[name="nik_kepsek"], input[name="nik_penginput"]');

        // Tambahkan event listener ke setiap input
        inputs.forEach(input => {
            input.addEventListener('input', validateNumericInput);
        });
    });
</script>