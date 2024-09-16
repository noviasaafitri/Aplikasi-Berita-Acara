<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="col">
        <div class="col-14 grid-margin">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title">Isi Data Berikut ini :</h4>
                    <!-- Menampilkan Pesan -->
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-info">
                            <?= session()->getFlashdata('message'); ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('StafSeksi/update_ba/' . $berita_acara['id_ba']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="id_suratketerangan">ID Surat Keterangan:</label>
                            <select name="id_suratketerangan" id="id_suratketerangan" class="form-control" required>
                                <?php foreach ($surat_keterangan as $sk) : ?>
                                    <option value="<?= $sk['id'] ?>" <?= $berita_acara['id_suratketerangan'] == $sk['id'] ? 'selected' : '' ?>>
                                        <?= $sk['nama_pekerjaan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Bagian Kiri -->
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor BA</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nomor_ba" value="<?= $berita_acara['nomor_ba']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_pekerjaan" value="<?= $berita_acara['nama_pekerjaan']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pihak Pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_ph1" value="<?= $berita_acara['nama_ph1']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jabatan Pihak Pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="jabatan_ph1" value="<?= $berita_acara['jabatan_ph1']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat Pihak Pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="alamat_ph1" value="<?= $berita_acara['alamat_ph1']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_ph2" value="<?= $berita_acara['nama_ph2']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jabatan Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="jabatan_ph2" value="<?= $berita_acara['jabatan_ph2']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="alamat_ph2" value="<?= $berita_acara['alamat_ph2']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Lokasi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="lokasi" value="<?= $berita_acara['lokasi']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Surat Permohonan Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="surat_permohonan_bayar" value="<?= $berita_acara['surat_permohonan_bayar']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Surat Perintah Kerja</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nt_spk" value="<?= $berita_acara['nt_spk']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nilai Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control rupiah" name="nilai_pekerjaan" value="<?= 'Rp ' . number_format($berita_acara['nilai_pekerjaan'], 0, ',', '.'); ?>" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Bagian Kanan -->
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">PPN</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control rupiah" name="ppn" value="<?= 'Rp ' . number_format($berita_acara['ppn'], 0, ',', '.'); ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control rupiah" name="total" value="<?= 'Rp ' . number_format($berita_acara['total'], 0, ',', '.'); ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Terbilang</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="terbilang" value="<?= $berita_acara['terbilang']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Perusahaan Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="pelaksana" value="<?= $berita_acara['pelaksana']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Hari</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="hari" value="<?= $berita_acara['hari']; ?>" required />
                                        <small style="color: red;">* Harap masukkan hari dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="tanggal" value="<?= $berita_acara['tanggal']; ?>" required />
                                        <small style="color: red;">* Harap masukkan tanggal dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Bulan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bulan" value="<?= $berita_acara['bulan']; ?>" required />
                                        <small style="color: red;">* Harap masukkan bulan dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tahun</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="tahun" value="<?= $berita_acara['tahun']; ?>" required />
                                        <small style="color: red;">* Harap masukkan tahun dengan format abjad</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">TTD Jabatan Pihak pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="ttd_jabatan_pertama" value="<?= $berita_acara['ttd_jabatan_pertama']; ?>" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">TTD Jabatan Pihak kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="ttd_jabatan_kedua" value="<?= $berita_acara['ttd_jabatan_kedua']; ?>" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div style="text-align: right;">
                                <a href="<?= base_url('StafSeksi/berita_acara'); ?>" class="btn btn-danger">Batal</a>
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
        $('.rupiah').on('input', function() {
            var value = $(this).val().replace(/[^,\d]/g, '');
            var split = value.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            $(this).val('Rp ' + rupiah);
        });

        // Format input fields on page load
        $('.rupiah').each(function() {
            var value = $(this).val().replace(/[^,\d]/g, '');
            var split = value.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            $(this).val('Rp ' + rupiah);
        });
    });
</script>