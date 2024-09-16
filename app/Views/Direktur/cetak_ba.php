<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Pembayaran</title>
    <link rel="icon" href="<?= base_url() ?>/Assets/img/logo.png" type="image/png">
    <link href="<?= base_url() ?>/Assets/css/ba_ba.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <h2 style="text-decoration: underline;">BERITA ACARA PEMBAYARAN</h2>
        <center>
            <p>Nomor: <?= $berita_acara['nomor_ba'] ?? 'Tidak Ada'; ?></p>
        </center>

        <hr>
        <p>Pada hari ini <b><?= $berita_acara['hari'] ?? 'Tidak Ada'; ?></b> tanggal <b> <?= $berita_acara['tanggal'] ?? 'Tidak Ada'; ?></b> Bulan <b> <?= $berita_acara['bulan'] ?? 'Tidak Ada'; ?></b> tahun <b> <?= $berita_acara['tahun'] ?? 'Tidak Ada'; ?></b>, dengan mengambil kedudukan hukum di kota Pontianak, kami yang bertanda-tangan di bawah ini :</p>

        <div class="section">
            <div class="details">
                <div class="number">1.</div>
                <div class="info">
                    <p>Nama: <b><?= $berita_acara['nama_ph1'] ?? 'Tidak Ada'; ?></b></p>
                    <p>Jabatan: <?= $berita_acara['jabatan_ph1'] ?? 'Tidak Ada'; ?></p>
                    <p>Alamat: <?= $berita_acara['alamat_ph1'] ?? 'Tidak Ada'; ?></p>
                    <p>Bertindak dalam jabatannya, yang selanjutnya disebut <b>PIHAK PERTAMA</b>.</p>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="details">
                <div class="number">2.</div>
                <div class="info">
                    <p>Nama: <b><?= $berita_acara['nama_ph2'] ?? 'Tidak Ada'; ?></b></p>
                    <p>Jabatan:</b> <?= $berita_acara['jabatan_ph2'] ?? 'Tidak Ada'; ?></p>
                    <p>Alamat:</b> <?= $berita_acara['alamat_ph2'] ?? 'Tidak Ada'; ?></p>
                    <p>Bertindak dalam jabatannya, yang selanjutnya disebut <b>PIHAK KEDUA</b>.</p>
                </div>
            </div>
        </div>

        <p class="justified-text">Berdasarkan Surat permohonan pembayaran dari Instalatir <b><?= $berita_acara['pelaksana'] ?? 'Tidak Ada'; ?></b> Nomor: <b><?= $berita_acara['surat_permohonan_bayar'] ?? 'Tidak Ada'; ?></b> tanggal 13 Februari 2024 dengan Surat Perintah Kerja Nomor: <b><?= $berita_acara['nt_spk'] ?? 'Tidak Ada'; ?></b> tanggal 07 Februari 2024 pada Pekerjaan <b><?= $berita_acara['nama_pekerjaan'] ?? 'Tidak Ada'; ?></b> di lokasi <b><?= $berita_acara['lokasi'] ?? 'Tidak Ada'; ?></b>.</p>

        <p>Untuk hal tersebut diatas, maka <b>PIHAK KEDUA</b> berhak menerima pembayaran atas pelaksanaan pekerjaan dari <b>PIHAK PERTAMA</b> dengan rincian sebagai berikut :</p>
        <div class="value" style="display: flex;">
            <div class="section payment-details" style="display: flex; width: 100%;">
                <div class="label" style="width: 50%; padding-right: 10px;">
                    <p style="margin: 0;">Nilai Pekerjaan: 100% x <?= number_format($berita_acara['nilai_pekerjaan'], 0, ',', '.');
                                                                    'Tidak Ada'; ?></p>
                    <p style="margin: 0;">PPN 11%</p>
                    <p style="margin: 0;">Total</p>
                </div>

                <div style="width: 50%; text-align: right;">
                    <div style="width: 50%; text-align: right; display: flex; flex-direction: column; justify-content: center; align-items: flex-end;">
                        <p style="margin: 0;">= Rp. <?= number_format($berita_acara['nilai_pekerjaan'], 0, ',', '.'); ?></p>
                        <p style="margin: 0; text-decoration: underline; display: inline-block; width: calc(100% - 15px); position: relative;">
                            = Rp. <?= number_format($berita_acara['ppn'], 0, ',', '.'); ?> +

                        </p>
                        <p style="margin: 0;"><b>= Rp. <?= number_format($berita_acara['total'], 0, ',', '.'); ?></b></p>
                    </div>

                </div>
            </div>
        </div>
        <div class="section">
            <div class="terbilang-container">
                <div class="terbilang-label">
                    <p>Terbilang : <b>“<?= $berita_acara['terbilang'] ?? 'Tidak Ada'; ?>”</b></p>
                </div>
            </div>
        </div>

        <p>Demikian Berita Acara Pembayaran ini dibuat, untuk dapat dipergunakan sebagaimana mestinya.</p>

        <div class="signatures">
            <div class="signature">
                <p>Pihak Kedua</p>
                <p><b><?= $berita_acara['pelaksana'] ?? 'Tidak Ada'; ?></b< /p>
                        <div class="signature-space"></div>
                        <p style="text-decoration: underline;"><b><?= $berita_acara['nama_ph2'] ?? 'Tidak Ada'; ?></b></p>
                        <p><b><?= $berita_acara['ttd_jabatan_kedua'] ?? 'Tidak Ada'; ?></b></p>
            </div>
            <div class="signature">
                <p>Pihak Pertama</p>
                <p><b>Perumda Air Minum Tirta Khatulistiwa Kota Pontianak</b></p>
                <div class="signature-space"></div>
                <p style="text-decoration: underline;"><b><?= $berita_acara['nama_ph1'] ?? 'Tidak Ada'; ?></b></p>
                <p><b><?= $berita_acara['ttd_jabatan_pertama'] ?? 'Tidak Ada'; ?></b></p>
            </div>

        </div>
    </div>
    </div>
</body>

</html>