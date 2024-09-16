<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Auth extends Model
{

    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user'; // Sesuaikan dengan primary key tabel
    protected $allowedFields = [
        'id_user', 'username', 'nama_lengkap', 'email', 'password', 'level', 'profile', 'deskripsi',  'reset_token', 'reset_expires'
    ];

    public function save_register($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT); // Hash password sebelum menyimpan ke database
        $this->db->table($this->table)->insert($data);
    }

    public function login($username, $password)
    {
        $user = $this->db->table($this->table)->where('username', $username)->get()->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function update_user($id_user, $data)
    {


        if (!empty($data)) {
            // Hash password jika ada perubahan password
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            }

            // Update data pengguna
            return $this->db->table($this->table)->where('id_user', $id_user)->update($data);
        }

        return false; // Tidak ada data yang diperbarui
    }
}
