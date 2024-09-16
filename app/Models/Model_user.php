<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_user extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama_lengkap', 'username', 'password', 'level', 'profile', 'deskripsi', 'email'];


    //Method Untuk Mengambil semua data dari tabel
    public function all_data()
    {
        return $this->findAll();
    }

    public function save_user($data)
    {
        // Hash password sebelum menyimpan ke database
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->insert($data);
    }

    public function update_user($id_user, $data)
    {
        // Hash password jika ada perubahan password
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $this->update($id_user, $data);
    }


    // Method untuk menghitung jumlah pengguna
    public function count_users()
    {
        return $this->countAllResults(); // Menghitung semua baris di tabel
    }
}
