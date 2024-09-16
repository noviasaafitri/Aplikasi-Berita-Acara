<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Berita Acara</title>
    <link href="<?= base_url() ?>/Assets/css/sb_ba.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url() ?>/Assets/img/logo.png" type="image/png">

</head>

<body>
    <div class="container">
        <header>
            <div class="logos-container">
                <div class="logos">
                    <img src="<?= base_url('Assets/img/logo_left.png') ?>" alt="Logo Left" class="logo-left">
                    <div>
                        <h2>PEMERINTAH KOTA PONTIANAK</h2>
                        <h2>PERUSAHAAN UMUM DAERAH</h2>
                        <h2> MINUM TIRTA KHATULISTIWA</h2>
                        <h4>BAGIAN PERENCANAAN DAN PENGELOLA ASET</h4>
                        <h4>SEKSI DATA BASE ASET</h4>
                    </div>
                    <img src="<?= base_url('Assets/img/logo_right.png') ?>" alt="Logo Right" class="logo-right">
                </div>
            </div>
        </header>
        <h3 class="title">SURAT KETERANGAN</h3>
        <p class="nomor">Nomor: <?= $rj['no_surat'] ?? 'Tidak Ada'; ?></p>
        <p>Yang bertanda tangan di bawah ini menerangkan:</p>
        <form>
            <div class="form-group">
                <label>1. Jenis Pekerjaan</label>
                <div>
                    <div class="checkbox-container">
                        <div class="checkbox-item">
                            <input type="checkbox" <?= in_array("Pengembangan Jaringan Pipa", $jenis_pekerjaan) ? 'checked' : '' ?> id="pjp">
                            <label for="pjp">Pengembangan Jaringan Pipa dia.<span class="underline">
                                    <?= isset($keterangan['Pengembangan Jaringan Pipa']) && is_array($keterangan['Pengembangan Jaringan Pipa'])
                                        ? implode(', ', $keterangan['Pengembangan Jaringan Pipa'])
                                        : ($keterangan['Pengembangan Jaringan Pipa'] ?? ' ') ?>
                                </span></label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" <?= in_array("Rehabilitasi Jaringan Pipa", $jenis_pekerjaan) ? 'checked' : '' ?> id="rjp">
                            <label for="rjp">Rehabilitasi Jaringan Pipa dia.<span class="underline">
                                    <?= isset($keterangan['Rehabilitasi Jaringan Pipa']) && is_array($keterangan['Rehabilitasi Jaringan Pipa'])
                                        ? implode(', ', $keterangan['Rehabilitasi Jaringan Pipa'])
                                        : ($keterangan['Rehabilitasi Jaringan Pipa'] ?? ' ') ?>

                                </span></label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" <?= in_array("Perbaikan Kebocoran Pipa", $jenis_pekerjaan) ? 'checked' : '' ?> id="pkp">
                            <label for="pkp">Perbaikan Kebocoran Pipa dia.<span class="underline">
                                    <?= isset($keterangan['Perbaikan Kebocoran Pipa']) && is_array($keterangan['Perbaikan Kebocoran Pipa'])
                                        ? implode(', ', $keterangan['Perbaikan Kebocoran Pipa'])
                                        : ($keterangan['Perbaikan Kebocoran Pipa'] ?? ' ') ?>

                                </span></label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" <?= in_array("Pindah Tapping/PE-Nisasi", $jenis_pekerjaan) ? 'checked'
                                                        : '' ?> id="pt">
                            <label for="pt">Pindah Tapping/PE-Nisasi:<span class="underline">
                                    <?= isset($keterangan['Pindah Tapping/PE-Nisasi']) && is_array($keterangan['Pindah Tapping/PE-Nisasi'])
                                        ? implode(', ', $keterangan['Pindah Tapping/PE-Nisasi'])
                                        : ($keterangan['Pindah Tapping/PE-Nisasi'] ?? ' ') ?>

                                </span></label>
                        </div>

                        <div class="checkbox-item">
                            <input type="checkbox" <?= in_array("Lain-lain", $jenis_pekerjaan) ? 'checked' : '' ?> id="ll">
                            <label for="ll">Lain-lain: <span class="underline"><span contenteditable="true">
                                        <?= isset($keterangan['Lain-lain']) && is_array($keterangan['Lain-lain'])
                                            ? implode(', ', $keterangan['Lain-lain'])
                                            : ($keterangan['Lain-lain'] ?? ' ') ?>

                                    </span></span></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>2. Nama Pekerjaan</label>
                <div>
                    <?= $rj['nama_pekerjaan'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>3. Lokasi</label>
                <div>
                    <?= $rj['lokasi'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>4. Nilai Pekerjaan</label>
                <div>Rp.
                    <?= number_format($rj['nilai_pekerjaan'], 0, ',', '.') ?>
                </div>
            </div>

            <div class="form-group">
                <label>5. Pelaksana</label>
                <div>
                    <?= $rj['pelaksana'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>6. Bagian</label>
                <div>
                    <?= $rj['bagian'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>7. Nomor & Tanggal SPK</label>
                <div>
                    <?= $rj['nt_spk'] ?>
                </div>
            </div>
            <div class="form-group">
                <label class="label-indent">Nomor & Tanggal BA Perubahan*</label>
                <div>
                    <?= $rj['nt_ba_perubahan'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>8. Nomor & Tanggal BA Selesai Pekerjaan</label>
                <div>
                    <?= $rj['nt_ba_selesai'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>9. Nomor & Tanggal BA Pembayaran</label>
                <div>
                    <?= $rj['nt_ba_pembayaran'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>10. Tanggal masuk berkas</label>
                <div>
                    <?= $rj['tgl_masuk_berkas'] ?>
                </div>
            </div>
        </form>
        <p>Telah dilakukan proses input ABD (As-Built Drawing) oleh Seksi Data Base Aset Bagian Perencanaan dan
            Pengelola Aset.</p>
        <div class="signature-container">
            <div class="signature">
                <p>Diperiksa Oleh:</p>
                <p class="signature-title">Kepala Seksi Data Base Aset</p>
                <p style="margin: 0; text-decoration: underline;""><strong><b><?= $rj['nama_kespek'] ?? 'Tidak Ada'; ?></b></strong></p>
                <p>NIK. <?= $rj['nik_kespek'] ?? 'Tidak Ada'; ?></p>
            </div>
            <div class=" signature">
                <p id="date">Pontianak, ..................</p>
                <p>Diinput Oleh:</p>
                <p class="signature-title">Staf Seksi Data Base Aset</p>
                <p style="margin: 0; text-decoration: underline;""><strong><b><?= $rj['nama_penginput'] ?? 'Tidak Ada'; ?></b></strong></p>
                <p>NIK. <?= $rj['nik_penginput'] ?? 'Tidak Ada'; ?></p>
            </div>

          
            </div>
            <div class=" notes">
                    <label>Catatan:</label>
                <div class="box">
                    <?= $rj['catatan'] ?>
                </div>
                <p style="margin: 0; padding: 0;">
                    *Bila Ada Perubahan (Adendum)
                </p>
                <p style="margin: 0; padding: 0; text-align: center;">
                    Jl. Imam Bonjol No. 430 Pontianak, 78123 telp. (0561) 76799 (Hunting) Fax. (0561) 736057
                </p>
                <p style="margin: 0; padding: 0; text-align: center; ">
                    Website: www.pdam-kotapontianak.com
                </p>
            </div>
        </div>
</body>
<script>
    function formatDate() {
        const now = new Date();
        const day = now.getDate().toString().padStart(2, '0');
        const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-based
        const year = now.getFullYear();
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        return `${day} ${months[parseInt(month, 10) - 1]} ${year}`;
    }

    // Update the content of the paragraph with the current date
    document.getElementById('date').innerHTML = `Pontianak, ${formatDate()}`;
</script>

</html>