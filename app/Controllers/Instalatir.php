<?php

namespace App\Controllers;

use App\Models\Model_suratketerangan;
use App\Models\Model_user;

class Instalatir extends BaseController
{
    public function home()
    {
        $data = array(
            'title' => 'Home',
            'isi' => 'Instalatir/v_home'
        );
        return view('Instalatir/v_wrapper', $data);
    }

    // FUNGSI UNTUK VIEWS PEMETAAN SWADAYA
    public function pemetaan_swadaya()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Pemetaan Swadaya',
            'isi' => 'Instalatir/pemetaan_swadaya',
            'pemetaan' => $model_suratketerangan->get_pemetaan_swadaya()
        );
        return view('Instalatir/v_wrapper', $data);
    }

    public function simpan_pekerjaan_ps()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $file = $this->request->getFile('berkas');

        // Periksa apakah file berhasil diunggah dan valid
        if ($file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $maxSize = 100 * 1024 * 1024;

            // Validasi tipe MIME dan ukuran file
            if (in_array($file->getMimeType(), $allowedTypes) && $file->getSize() <= $maxSize) {
                $fileName = $file->getClientName();
                // Pindahkan file ke direktori yang ditentukan
                $file->move(ROOTPATH . 'public/Assets/Berkas', $fileName);
            } else {
                // Set flash data untuk pesan error jika file tidak valid
                session()->setFlashdata('error', 'File harus berformat PDF atau DOC/DOCX dan tidak boleh lebih dari 100 MB.');
                return redirect()->back()->withInput();
            }
        } else {
            $fileName = ''; // Atur default jika file tidak valid atau tidak diunggah
        }

        // Data untuk disimpan ke dalam database
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'berkas' => $fileName, // Simpan nama file saja
            'status' => 'Proses Verifikasi',
            'kategori' => 'Pemetaan Swadaya'
            // Tambahkan field lain sesuai kebutuhan
        ];

        // Lakukan insert data menggunakan model
        if ($model_suratketerangan->insert($data)) {
            // Set flash data untuk pesan berhasil
            session()->setFlashdata('success', 'Data pekerjaan Pemetaan Swadaya berhasil ditambahkan.');
        } else {
            // Set flash data untuk pesan error
            session()->setFlashdata('error', 'Gagal menambahkan data pekerjaan Pemetaan Swadaya.');
        }
        // Redirect setelah berhasil menyimpan data
        return redirect()->to('/Instalatir/pemetaan_swadaya');
    }

    // FUNGSI UNTUK VIEWS PEMETAAN SWADAYA
    public function rehab_jaringan()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Pemetaan Rehab Jaringan',
            'isi' => 'Instalatir/rehab_jaringan',
            'pemetaan' => $model_suratketerangan->get_rehab_jaringan()
        );
        return view('Instalatir/v_wrapper', $data);
    }

    public function simpan_pekerjaan_rj()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $file = $this->request->getFile('berkas');

        // Periksa apakah file berhasil diunggah dan valid
        if ($file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $maxSize = 100 * 1024 * 1024;

            // Validasi tipe MIME dan ukuran file
            if (in_array($file->getMimeType(), $allowedTypes) && $file->getSize() <= $maxSize) {
                $fileName = $file->getClientName();
                // Pindahkan file ke direktori yang ditentukan
                $file->move(ROOTPATH . 'public/Assets/Berkas', $fileName);
            } else {
                // Set flash data untuk pesan error jika file tidak valid
                session()->setFlashdata('error', 'File harus berformat PDF atau DOC/DOCX dan tidak boleh lebih dari 100 MB.');
                return redirect()->back()->withInput();
            }
        } else {
            $fileName = ''; // Atur default jika file tidak valid atau tidak diunggah
        }

        // Data untuk disimpan ke dalam database
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'berkas' => $fileName, // Simpan nama file saja
            'status' => 'Proses Verifikasi',
            'kategori' => 'Rehab Jaringan', // Tambahkan kategori jika diperlukan
            'kategori' => 'Pemetaan Rehab Jaringan'
        ];

        // Lakukan insert data menggunakan model
        if ($model_suratketerangan->insert($data)) {
            // Set flash data untuk pesan berhasil
            session()->setFlashdata('success', 'Data pekerjaan Pemetaan Rehab Jaringan berhasil ditambahkan.');
        } else {
            // Set flash data untuk pesan error
            session()->setFlashdata('error', 'Gagal menambahkan data pekerjaan Pemetaan Rehab Jaringan.');
        }

        // Redirect setelah berhasil menyimpan data
        return redirect()->to('/Instalatir/rehab_jaringan');
    }

    public function pengembang_jaringan()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Pemetaan Pengembangan Jaringan',
            'isi' => 'Instalatir/pengembang_jaringan',
            'pemetaan' => $model_suratketerangan->get_pengembangan_jaringan()
        );
        return view('Instalatir/v_wrapper', $data);
    }

    public function simpan_pekerjaan_pj()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $file = $this->request->getFile('berkas');

        // Periksa apakah file berhasil diunggah dan valid
        if ($file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $maxSize = 100 * 1024 * 1024;

            // Validasi tipe MIME dan ukuran file
            if (in_array($file->getMimeType(), $allowedTypes) && $file->getSize() <= $maxSize) {
                $fileName = $file->getClientName();
                // Pindahkan file ke direktori yang ditentukan
                $file->move(ROOTPATH . 'public/Assets/Berkas', $fileName);
            } else {
                // Set flash data untuk pesan error jika file tidak valid
                session()->setFlashdata('error', 'File harus berformat PDF atau DOC/DOCX dan tidak boleh lebih dari 100 MB.');
                return redirect()->back()->withInput();
            }
        } else {
            $fileName = ''; // Atur default jika file tidak valid atau tidak diunggah
        }

        // Data untuk disimpan ke dalam database
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'berkas' => $fileName, // Simpan nama file saja
            'status' => 'Proses Verifikasi',
            'kategori' => 'Pemetaan Pengembangan Jaringan'
        ];
        // Lakukan insert data menggunakan model
        if ($model_suratketerangan->insert($data)) {
            // validasi menggunakan flash data untuk pesan berhasil
            session()->setFlashdata('success', 'Data pekerjaan Pemetaan Pengembangan Jaringan berhasil ditambahkan.');
        } else {
            //validasi menggunakan flash data untuk pesan error
            session()->setFlashdata('error', 'Gagal menambahkan data pekerjaan Pemetaan Pengembangan Jaringan .');
        }

        // Redirect setelah berhasil menyimpan data
        return redirect()->to('/Instalatir/pengembang_jaringan');
    }

    public function sipil_me()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Sipil & Me',
            'isi' => 'Instalatir/sipil_me',
            'pemetaan' => $model_suratketerangan->get_sipildanme()
        );
        return view('Instalatir/v_wrapper', $data);
    }

    public function simpan_pekerjaan_sm()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $file = $this->request->getFile('berkas');

        // Periksa apakah file berhasil diunggah dan valid
        if ($file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $maxSize = 100 * 1024 * 1024;

            // Validasi tipe MIME dan ukuran file
            if (in_array($file->getMimeType(), $allowedTypes) && $file->getSize() <= $maxSize) {
                $fileName = $file->getClientName();
                // Pindahkan file ke direktori yang ditentukan
                $file->move(ROOTPATH . 'public/Assets/Berkas', $fileName);
            } else {
                // Set flash data untuk pesan error jika file tidak valid
                session()->setFlashdata('error', 'File harus berformat PDF atau DOC/DOCX dan tidak boleh lebih dari 100 MB.');
                return redirect()->back()->withInput();
            }
        } else {
            $fileName = ''; // Atur default jika file tidak valid atau tidak diunggah
        }

        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'berkas' => $fileName, // Simpan nama file saja
            'status' => 'Proses Verifikasi',
            'kategori' => 'Sipil & Me'
        ];

        // Lakukan insert data menggunakan model
        if ($model_suratketerangan->insert($data)) {
            // Set flash data untuk pesan berhasil
            session()->setFlashdata('success', 'Data pekerjaan Sipill & Me berhasil ditambahkan.');
        } else {
            // Set flash data untuk pesan error
            session()->setFlashdata('error', 'Gagal menambahkan data pekerjaan Sipil & Me.');
        }

        // Redirect setelah berhasil menyimpan data
        return redirect()->to('/Instalatir/sipil_me');
    }

    public function profile()
    {
        $model_user = new Model_user();
        $user_id = session()->get('id_user');

        // Debugging: Tampilkan ID pengguna
        log_message('debug', 'ID pengguna di session: ' . $user_id);

        if (!$user_id) {
            log_message('error', 'ID pengguna tidak ditemukan dalam session di profil.');
        }

        $user = $model_user->find($user_id);

        $data = [
            'title' => 'Profile',
            'isi' => 'instalatir/v_profile',
            'user' => $user,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error')
        ];

        return view('Instalatir/v_wrapper', $data);
    }

    public function update_profile()
    {
        $session = session();
        $model_user = new Model_user();

        // Ambil ID pengguna dari session
        $id_user = $session->get('id_user');

        // Debugging: Log atau echo ID pengguna untuk memeriksa nilai
        if (!$id_user) {
            log_message('error', 'ID pengguna tidak ditemukan dalam session di update_profile.');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID pengguna tidak ditemukan.'
            ]);
        }

        // Ambil data dari form
        $email = $this->request->getPost('email');
        $username = $this->request->getPost('username');
        $nama_lengkap = $this->request->getPost('nama_lengkap');

        // Ambil file profile jika ada perubahan
        $profile = $this->request->getFile('profile_picture');
        $profileName = $session->get('profile'); // Simpan nama file lama sebagai default

        if ($profile && $profile->isValid() && !$profile->hasMoved()) {
            // Ambil nama file baru
            $profileName = $profile->getRandomName(); // Menghasilkan nama acak untuk menghindari bentrokan nama file
            $profile->move(ROOTPATH . 'public/Assets/foto', $profileName);

            // Hapus file lama jika ada dan bukan file default 'images.png'
            $oldProfile = $session->get('profile');
            if (!empty($oldProfile) && $oldProfile !== 'images.png' && file_exists(ROOTPATH . 'public/Assets/foto/' . $oldProfile)) {
                unlink(ROOTPATH . 'public/Assets/foto/' . $oldProfile);
            }
        }

        // Update session profile name jika ada perubahan
        $session->set('profile', $profileName);

        // Data untuk diperbarui di database
        $data = [
            'email' => $email,
            'username' => $username,
            'nama_lengkap' => $nama_lengkap,
            'profile' => $profileName
        ];

        // Perbarui data di database
        if ($model_user->update($id_user, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
                'newProfilePictureUrl' => base_url('/Assets/foto/' . $profileName)
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui profil.'
            ]);
        }
    }
}
