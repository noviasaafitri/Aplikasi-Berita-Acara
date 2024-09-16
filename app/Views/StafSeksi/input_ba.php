<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column min-vh-100">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Form Berita Acara Pembayaran</h1>
    <div class="col">
        <div class="col-14 grid-margin">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Menampilkan Pesan -->
                    <?php if (session()->getFlashdata('message')) : ?>
                        <div class="alert alert-info">
                            <?= session()->getFlashdata('message'); ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?= base_url('StafSeksi/save_ba') ?>" class="form-sample">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Bagian Kiri -->
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nomor Berita Acara</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nomor_ba" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pekerjaan Pada Surat Keterangan</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="id_suratketerangan" id="id_suratketerangan" required>
                                            <option value="">Pilih Surat Keterangan</option>
                                            <?php foreach ($surat_keterangan as $sk) : ?>
                                                <option value="<?= $sk['id']; ?>"><?= $sk['nama_pekerjaan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_pekerjaan" id="nama_pekerjaan" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pihak Pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_ph1" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jabatan Pihak Pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="jabatan_ph1" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat Pihak Pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="alamat_ph1" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nama Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama_ph2" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Jabatan Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="jabatan_ph2" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Alamat Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="alamat_ph2" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Lokasi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="lokasi" id="lokasi" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">No. Surat Permohonan Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="surat_permohonan_bayar" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">No. Surat Perintah Kerja</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nt_spk" id="nt_spk" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Nilai Pekerjaan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control rupiah" name="nilai_pekerjaan" id="nilai_pekerjaan" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Bagian Kanan -->
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">PPN</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control rupiah" name="ppn" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control rupiah" name="total" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Terbilang</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="terbilang" required />
                                        <small style="color: red;">* Harap masukkan terbilang dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Perusahaan Pihak Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="pelaksana" id="pelaksana" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Hari</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="hari" required />
                                        <small style="color: red;">* Harap masukkan hari dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="tanggal" required />
                                        <small style="color: red;">* Harap masukkan tanggal dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Bulan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bulan" required />
                                        <small style="color: red;">* Harap masukkan bulan dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tahun</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="tahun" required />
                                        <small style="color: red;">* Harap masukkan tahun dengan format abjad</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanda Tangan Jabatan Kedua</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="ttd_jabatan_kedua" required />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tanda Tangan Jabatan Pertama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="ttd_jabatan_pertama" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const idSuratKeteranganSelect = document.getElementById('id_suratketerangan');

        idSuratKeteranganSelect.addEventListener('change', function() {
            const id = this.value;
            if (id) {
                fetch(`<?= base_url('StafSeksi/get_surat_keterangan_data') ?>/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('nama_pekerjaan').value = data.nama_pekerjaan || '';
                        document.getElementById('lokasi').value = data.lokasi || '';
                        document.getElementById('nt_spk').value = data.nt_spk || '';
                        document.getElementById('pelaksana').value = data.pelaksana || '';
                        document.getElementById('nilai_pekerjaan').value = data.nilai_pekerjaan || '';
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('nama_pekerjaan').value = '';
                document.getElementById('lokasi').value = '';
                document.getElementById('nt_spk').value = '';
                document.getElementById('pelaksana').value = '';
                document.getElementById('nilai_pekerjaan').value = '';
            }
        });
    });
</script>

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
    });
</script>