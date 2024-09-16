<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_suratketerangan extends Model
{
    protected $table = 'surat_keterangan'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id'; // Sesuaikan dengan primary key tabel
    protected $allowedFields = ['nama_pekerjaan', 'kategori', 'pelaksana', 'berkas', 'jenis_pekerjaan', 'lokasi', 'nilai_pekerjaan', 'bagian', 'nt_spk', 'nt_ba_selesai', 'nt_ba_pembayaran', 'tgl_masuk_berkas', 'status', 'catatan', 'keterangan', 'no_surat', 'nama_kepsek', 'nik_kepsek', 'nama_penginput', 'nik_penginput'];

    // Fungsi untuk menghitung jumlah berdasarkan kategori dan status
    public function count_status_by_kategori($status, $kategori)
    {
        return $this->where('status', $status)
            ->where('kategori', $kategori)
            ->countAllResults();
    }

    // Fungsi untuk mengambil semua data dengan filter kategori 'pemetaan swadaya'
    public function get_pemetaan_swadaya()
    {
        return $this->where('kategori', 'Pemetaan Swadaya')->findAll();
    }

    public function get_rehab_jaringan()
    {
        return $this->where('kategori', 'Pemetaan Rehab Jaringan')->findAll();
    }

    public function get_pengembangan_jaringan()
    {
        return $this->where('kategori', 'Pemetaan Pengembangan Jaringan')->findAll();
    }

    public function get_sipildanme()
    {
        return $this->where('kategori', 'Sipil & Me')->findAll();
    }

    public function update_status_by_category($kategori, $status)
    {
        // Validasi status
        $valid_status = ['Terverifikasi', 'Ditolak'];
        if (!in_array($status, $valid_status)) {
            return false;
        }

        // Perbarui status
        return $this->where('kategori', $kategori)
            ->set(['status' => $status])
            ->update();
    }

    public function delete_by_kategori($kategori, $id)
    {
        // Validasi kategori
        $valid_categories = ['Pemetaan Swadaya', 'Pemetaan Rehab Jaringan', 'Pemetaan Pengembangan Jaringan', 'Sipil & Me'];
        if (!in_array($kategori, $valid_categories)) {
            return false;
        }

        // Hapus data berdasarkan kategori dan ID
        return $this->where('kategori', $kategori)
            ->where('id', $id)
            ->delete();
    }

    public function getKeterangan_ps($jenis)
    {
        return $this->select('keterangan')
            ->where('jenis_pekerjaan', $jenis)
            ->where('kategori', 'Pemetaan Swadaya')
            ->first();
    }

    public function getKeterangan_rj($jenis)
    {
        return $this->select('keterangan')
            ->where('jenis_pekerjaan', $jenis)
            ->where('kategori', 'Pemetaan Rehab Jaringan')
            ->first();
    }

    public function getKeterangan_pj($jenis)
    {
        return $this->select('keterangan')
            ->where('jenis_pekerjaan', $jenis)
            ->where('kategori', 'Pemetaan Pengembangan Jaringan')
            ->first();
    }

    public function getKeterangan_sm($jenis)
    {
        return $this->select('keterangan')
            ->where('jenis_pekerjaan', $jenis)
            ->where('kategori', 'Sipil & Me')
            ->first();
    }

    public function count_new_jobs_by_kategori($kategori)
    {
        return $this->where('kategori', $kategori)
            ->where('status', 'Proses Verifikasi')
            ->countAllResults();
    }

    // public function getByCategory($category)
    // {
    //     return $this->where('kategori', $category)->findAll();
    // }
}
