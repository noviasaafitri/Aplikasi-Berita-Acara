<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_ba extends Model
{
    protected $table = 'tbl_ba'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id_ba'; // Sesuaikan dengan primary key tabel
    protected $allowedFields = [
        'id_suratketerangan', 'nomor_ba', 'nama_ph1', 'jabatan_ph1', 'alamat_ph1', 'lokasi',
        'nama_ph2', 'jabatan_ph2', 'alamat_ph2', 'surat_permohonan_bayar', 'nt_spk',
        'nama_pekerjaan', 'nilai_pekerjaan', 'ppn', 'total', 'terbilang',
        'pelaksana', 'ttd_jabatan_kedua', 'ttd_jabatan_pertama',
        'hari', 'tanggal', 'bulan', 'tahun'
    ];

    public function getAllBaWithSuratKeterangan()
    {
        return $this->select('tbl_ba.*, surat_keterangan.lokasi, surat_keterangan.nt_spk, surat_keterangan.nama_pekerjaan, surat_keterangan.pelaksana , surat_keterangan.nilai_pekerjaan')
            ->join('surat_keterangan', 'surat_keterangan.id = tbl_ba.id_suratketerangan')
            ->findAll();
    }

    public function save_data($data)
    {
        return $this->insert($data);
    }

    public function update_ba($id_ba, $data)
    {
        return $this->update($id_ba, $data);
    }

    public function delete_ba($id_ba)
    {
        return $this->delete($id_ba);
    }
}
