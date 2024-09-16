<?php

namespace App\Controllers;


use App\Models\Model_user;
use App\Models\Model_suratketerangan;
use App\Models\Model_ba;
use CodeIgniter\Email\Email;

class StafSeksi extends BaseController
{
    public function home()
    {
        $modelSm = new Model_suratketerangan();
        $modelUser = new Model_user();

        // Hitung jumlah data untuk user
        $totalUsers = $modelUser->count_users();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya memerlukan verifikasi!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan memerlukan verifikasi!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan memerlukan verifikasi!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me memerlukan verifikasi!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        // Hitung jumlah data untuk setiap status
        $jumlahVerifikasiPemetaanSwadaya = $modelSm->count_status_by_kategori('Terverifikasi', 'Pemetaan Swadaya');
        $jumlahVerifikasiRehabJaringan = $modelSm->count_status_by_kategori('Terverifikasi', 'Pemetaan Rehab Jaringan');
        $jumlahVerifikasiPengembanganJaringan = $modelSm->count_status_by_kategori('Terverifikasi', 'Pemetaan Pengembangan Jaringan');
        $jumlahVerifikasiSipilDanMe = $modelSm->count_status_by_kategori('Terverifikasi', 'Sipil & Me');

        // Total jumlah data terverifikasi
        $jumlahVerifikasi = $jumlahVerifikasiPemetaanSwadaya + $jumlahVerifikasiRehabJaringan + $jumlahVerifikasiPengembanganJaringan + $jumlahVerifikasiSipilDanMe;

        $jumlahDitolakPemetaanSwadaya = $modelSm->count_status_by_kategori('Ditolak', 'Pemetaan Swadaya');
        $jumlahDitolakRehabJaringan = $modelSm->count_status_by_kategori('Ditolak', 'Pemetaan Rehab Jaringan');
        $jumlahDitolakPengembanganJaringan = $modelSm->count_status_by_kategori('Ditolak', 'Pemetaan Pengembangan Jaringan');
        $jumlahDitolakSipilDanMe = $modelSm->count_status_by_kategori('Ditolak', 'Sipil & Me');

        // Total jumlah data ditolak
        $jumlahDitolak = $jumlahDitolakPemetaanSwadaya + $jumlahDitolakRehabJaringan + $jumlahDitolakPengembanganJaringan + $jumlahDitolakSipilDanMe;

        // Hitung jumlah data dalam Proses Verifikasi
        $jumlahProsesVerifikasiPemetaanSwadaya = $modelSm->count_status_by_kategori('Proses Verifikasi', 'Pemetaan Swadaya');
        $jumlahProsesVerifikasiRehabJaringan = $modelSm->count_status_by_kategori('Proses Verifikasi', 'Pemetaan Rehab Jaringan');
        $jumlahProsesVerifikasiPengembanganJaringan = $modelSm->count_status_by_kategori('Proses Verifikasi', 'Pemetaan Pengembangan Jaringan');
        $jumlahProsesVerifikasiSipilDanMe = $modelSm->count_status_by_kategori('Proses Verifikasi', 'Sipil & Me');

        // Total jumlah data dalam Proses Verifikasi
        $jumlahProsesVerifikasi = $jumlahProsesVerifikasiPemetaanSwadaya + $jumlahProsesVerifikasiRehabJaringan + $jumlahProsesVerifikasiPengembanganJaringan + $jumlahProsesVerifikasiSipilDanMe;

        // Kirim data ke view
        $data = array(
            'title' => 'Home',
            'isi' => 'StafSeksi/v_home',
            'totalUsers' => $totalUsers,
            'jumlah_verifikasi' => $jumlahVerifikasi,
            'jumlah_ditolak' => $jumlahDitolak,
            'jumlah_proses_verifikasi' => $jumlahProsesVerifikasi,
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts // Kirim data alerts ke view
        );

        return view('StafSeksi/v_wrapper', $data);
    }

    private function sendNotificationEmail($jumlahBaru)
    {
        $email = \Config\Services::email();

        $email->setFrom('novia.safitri778@gmail.com', 'Notifikasi Sistem');
        $email->setTo('noviasafitriiiiiii@gmail.com');
        $email->setSubject('Notifikasi Pekerjaan Baru');
        $email->setMessage("Terdapat $jumlahBaru pekerjaan baru.");

        if (!$email->send()) {
            log_message('error', 'Gagal mengirim email notifikasi.');
        }
    }

    public function kelolauser()
    {
        $model_user = new Model_user();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $data = array(
            'title' => 'Kelola User',
            'isi' => 'StafSeksi/kelola_user',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts, // Kirim data alerts ke view
            'users' => $model_user->all_data()
        );
        return view('StafSeksi/v_wrapper', $data);
    }

    public function simpan_user()
    {
        $session = session();
        $model_user = new Model_user();

        // Dapatkan data dari form
        $nama_lengkap = $this->request->getPost('nama_lengkap');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $level = $this->request->getPost('level');
        $deskripsi = $this->request->getPost('deskripsi');
        $email = $this->request->getPost('email');


        // Upload file profile
        $profile = $this->request->getFile('profile');
        $profileName = 'default.png'; // Default profile image name

        if ($profile->isValid() && !$profile->hasMoved()) {
            // Gunakan nama asli dari file yang diupload
            $profileName = $profile->getRandomName(); // Dapatkan nama file yang unik
            $profile->move(ROOTPATH . 'public/Assets/foto', $profileName);
        }

        // Data to be inserted
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'username' => $username,
            'password' => $password,
            'level' => $level,
            'profile' => $profileName,
            'deskripsi' => $deskripsi,
            'email' => $email
        ];

        if ($model_user->save_user($data)) {
            $session->setFlashdata('success', 'User berhasil ditambahkan.');
        } else {
            $session->setFlashdata('error', 'Gagal menambahkan user.');
        }

        return redirect()->to(base_url('StafSeksi/kelolauser'));
    }

    public function update_user($id_user)
    {
        $model_user = new Model_user();

        // Dapatkan data dari form
        $nama_lengkap = $this->request->getPost('nama_lengkap_edit');
        $username = $this->request->getPost('username_edit');
        $password = $this->request->getPost('password_edit');
        $level = $this->request->getPost('level_edit');
        $deskripsi = $this->request->getPost('deskripsi_edit');
        $email = $this->request->getPost('email_edit');

        // Ambil nama file lama
        $oldProfile = $this->request->getPost('old_profile');

        // Upload file profile jika ada perubahan
        $profile = $this->request->getFile('profile_edit');
        if ($profile->isValid() && !$profile->hasMoved()) {
            // Ambil nama asli file dan ekstensi
            $profileName = $profile->getName();
            $profile->move(ROOTPATH . 'public/Assets/foto', $profileName);

            // Hapus file lama jika ada
            if (!empty($oldProfile) && file_exists(ROOTPATH . 'public/Assets/foto/' . $oldProfile)) {
                unlink(ROOTPATH . 'public/Assets/foto/' . $oldProfile);
            }
        } else {
            // Jika tidak ada file baru yang diupload, gunakan nama file lama
            $profileName = $oldProfile;
        }

        // Data yang akan diperbarui
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'username' => $username,
            'profile' => $profileName,
            'level' => $level,
            'deskripsi' => $deskripsi,
            'email' => $email
        ];

        // Perbarui password jika ada perubahan
        if (!empty($password)) {
            $data['password'] = $password;
        }

        // Perbarui data ke database
        $model_user->update_user($id_user, $data);

        return redirect()->to(base_url('StafSeksi/kelolauser'));
    }
    public function delete_user($id_user)
    {
        $model_user = new Model_user();
        $session = session();
        $current_user_id = $session->get('id_user'); // ID user yang sedang login

        // Periksa apakah pengguna yang sedang login adalah StafSeksi
        $current_user = $model_user->find($current_user_id);

        // Jika pengguna yang login adalah StafSeksi dan mencoba menghapus dirinya sendiri
        if ($current_user['id_user'] == $id_user && $current_user['level'] == 1) {
            $session->setFlashdata('error', 'Anda tidak dapat menghapus akun StafSeksi Anda sendiri.');
            return redirect()->to(base_url('StafSeksi/kelolauser'));
        }

        // Hapus user berdasarkan ID
        $model_user->delete($id_user);

        // Set flashdata untuk sukses
        $session->setFlashdata('success', 'User berhasil dihapus.');
        return redirect()->to(base_url('StafSeksi/kelolauser'));
    }

    // FUNGSI UNTUK VIEWS PEMETAAN SWADAYA
    public function pemetaan_swadaya()
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $data = array(
            'title' => 'Pemetaan Swadaya',
            'isi' => 'StafSeksi/pemetaan_swadaya',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts, // Kirim data alerts ke view
            'pemetaan' => $model_suratketerangan->get_pemetaan_swadaya()
        );
        return view('StafSeksi/v_wrapper', $data);
    }

    // Menampilkan halaman edit PS
    public function edit_ps($id)
    {
        // Inisialisasi model
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        // Mengambil data pemetaan swadaya berdasarkan ID dan kategori 'Pemetaan Swadaya'
        $pemetaan = $model_suratketerangan->where('kategori', 'Pemetaan Swadaya')->find($id);

        // Cek apakah data ditemukan
        if ($pemetaan === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Menyiapkan data untuk view
        $data = [
            'title' => 'Edit Pemetaan Swadaya',
            'isi' => 'StafSeksi/edit_ps',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan
        ];

        // Menampilkan view dengan data yang telah disiapkan
        return view('StafSeksi/v_wrapper', $data);
    }

    public function view_ps($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Pemetaan Swadaya',
            'isi' => 'StafSeksi/v_ps',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan
        ];

        return view('StafSeksi/v_wrapper', $data);
    }

    public function update_ps($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data dari form
        $jenis_pekerjaan = $this->request->getPost('jenis_pekerjaan');
        $keterangan_data = [];

        // Tambahan untuk checkbox jenis pekerjaan dengan keterangan
        if ($jenis_pekerjaan) {
            foreach ($jenis_pekerjaan as $jenis) {
                switch ($jenis) {
                    case 'Pengembangan Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_pengembangan');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Rehabilitasi Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_rehabilitasi');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Perbaikan Kebocoran Pipa':
                        $keterangan = $this->request->getPost('keterangan_rkebocoran');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Pindah Tapping/PE-Nisasi':
                        $keterangan = $this->request->getPost('keterangan_pindah');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Lain-lain':
                        $keterangan = $this->request->getPost('keterangan_lain');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                }
            }
        }

        // Data yang akan diupdate
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'jenis_pekerjaan' => implode(',', $jenis_pekerjaan),
            'lokasi' => $this->request->getPost('lokasi'),
            'nilai_pekerjaan' => str_replace(['Rp ', '.'], ['', ''], $this->request->getPost('nilai_pekerjaan')),
            'bagian' => $this->request->getPost('bagian'),
            'nt_spk' => $this->request->getPost('nt_spk'),
            'nt_ba_perubahan' => $this->request->getPost('nt_ba_perubahan'),
            'nt_ba_pembayaran' => $this->request->getPost('nt_ba_pembayaran'),
            'nt_ba_selesai' => $this->request->getPost('nt_ba_selesai'),
            'tgl_masuk_berkas' => $this->request->getPost('tgl_masuk_berkas'),
            'no_surat' => $this->request->getPost('no_surat'),
            'nama_kepsek' => $this->request->getPost('nama_kepsek'),
            'nik_kepsek' => $this->request->getPost('nik_kepsek'),
            'nama_penginput' => $this->request->getPost('nama_penginput'),
            'nik_penginput' => $this->request->getPost('nik_penginput'),
            'catatan' => $this->request->getPost('catatan'),
            'keterangan' => implode('; ', $keterangan_data), // Menggunakan format string biasa
        ];

        // Update data di database
        if ($model_suratketerangan->update($id, $data)) {
            $session = session();
            $session->setFlashdata('success', 'Data berhasil diupdate.');
        } else {
            $session = session();
            $session->setFlashdata('error', 'Gagal mengupdate data.');
        }

        return redirect()->to(base_url('StafSeksi/pemetaan_swadaya'));
    }

    public function delete_ps($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data berdasarkan ID untuk mendapatkan kategori
        $data = $model_suratketerangan->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to(base_url('StafSeksi/pemetaan_swadaya'));
        }

        $kategori = $data['kategori']; // Sesuaikan dengan nama kolom kategori di tabel Anda

        if ($model_suratketerangan->delete_by_kategori($kategori, $id)) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
        }

        return redirect()->to(base_url('StafSeksi/pemetaan_swadaya'));
    }


    // FUNGSI UNTUK VIEWS PEMETAAN SWADAYA
    public function rehab_jaringan()
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }


        $data = array(
            'title' => 'Pemetaan Rehab Jaringan',
            'isi' => 'StafSeksi/rehab_jaringan',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $model_suratketerangan->get_rehab_jaringan()
        );
        return view('StafSeksi/v_wrapper', $data);
    }

    // Menampilkan halaman edit PS
    public function edit_rj($id)
    {
        // Inisialisasi model
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }


        // Mengambil data pemetaan swadaya berdasarkan ID dan kategori 'Pemetaan Swadaya'
        $pemetaan = $model_suratketerangan->where('kategori', 'Pemetaan Rehab Jaringan')->find($id);

        // Cek apakah data ditemukan
        if ($pemetaan === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Menyiapkan data untuk view
        $data = [
            'title' => 'Edit Pemetaan Rehab Jaringan',
            'isi' => 'StafSeksi/edit_rj',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan,
        ];

        // Menampilkan view dengan data yang telah disiapkan
        return view('StafSeksi/v_wrapper', $data);
    }

    public function view_rj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Pemetaan Rehab Jaringan',
            'isi' => 'StafSeksi/v_rj',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan,
        ];

        return view('StafSeksi/v_wrapper', $data);
    }

    public function update_rj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data dari form
        $jenis_pekerjaan = $this->request->getPost('jenis_pekerjaan');
        $keterangan_data = [];

        // Tambahan untuk checkbox jenis pekerjaan dengan keterangan
        if ($jenis_pekerjaan) {
            foreach ($jenis_pekerjaan as $jenis) {
                switch ($jenis) {
                    case 'Pengembangan Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_pengembangan');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Rehabilitasi Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_rehabilitasi');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Perbaikan Kebocoran Pipa':
                        $keterangan = $this->request->getPost('keterangan_rkebocoran');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Pindah Tapping/PE-Nisasi':
                        $keterangan = $this->request->getPost('keterangan_pindah');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Lain-lain':
                        $keterangan = $this->request->getPost('keterangan_lain');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                }
            }
        }

        // Data yang akan diupdate
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'jenis_pekerjaan' => implode(',', $jenis_pekerjaan),
            'lokasi' => $this->request->getPost('lokasi'),
            'nilai_pekerjaan' => str_replace(['Rp ', '.'], ['', ''], $this->request->getPost('nilai_pekerjaan')),
            'bagian' => $this->request->getPost('bagian'),
            'nt_spk' => $this->request->getPost('nt_spk'),
            'nt_ba_perubahan' => $this->request->getPost('nt_ba_perubahan'),
            'nt_ba_pembayaran' => $this->request->getPost('nt_ba_pembayaran'),
            'nt_ba_selesai' => $this->request->getPost('nt_ba_selesai'),
            'tgl_masuk_berkas' => $this->request->getPost('tgl_masuk_berkas'),
            'no_surat' => $this->request->getPost('no_surat'),
            'nama_kepsek' => $this->request->getPost('nama_kepsek'),
            'nik_kepsek' => $this->request->getPost('nik_kepsek'),
            'nama_penginput' => $this->request->getPost('nama_penginput'),
            'nik_penginput' => $this->request->getPost('nik_penginput'),
            'catatan' => $this->request->getPost('catatan'),
            'keterangan' => implode('; ', $keterangan_data), // Menggunakan format string biasa
        ];

        // Update data di database
        if ($model_suratketerangan->update($id, $data)) {
            $session = session();
            $session->setFlashdata('success', 'Data berhasil diupdate.');
        } else {
            $session = session();
            $session->setFlashdata('error', 'Gagal mengupdate data.');
        }

        return redirect()->to(base_url('StafSeksi/rehab_jaringan'));
    }

    public function delete_rj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data berdasarkan ID untuk mendapatkan kategori
        $data = $model_suratketerangan->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to(base_url('StafSeksi/rehab_jaringan'));
        }

        $kategori = $data['kategori']; // Sesuaikan dengan nama kolom kategori di tabel Anda

        if ($model_suratketerangan->delete_by_kategori($kategori, $id)) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
        }

        return redirect()->to(base_url('StafSeksi/rehab_jaringan'));
    }

    // FUNGSI UNTUK VIEWS PEMETAAN SWADAYA
    public function pengembang_jaringan()
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $data = array(
            'title' => 'Pemetaan Swadaya',
            'isi' => 'StafSeksi/pengembang_jaringan',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $model_suratketerangan->get_pengembangan_jaringan()
        );
        return view('StafSeksi/v_wrapper', $data);
    }

    // Menampilkan halaman edit PS
    public function edit_pj($id)
    {
        // Inisialisasi model
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        // Mengambil data pemetaan swadaya berdasarkan ID dan kategori 'Pemetaan Swadaya'
        $pemetaan = $model_suratketerangan->where('kategori', 'Pemetaan Pengembangan Jaringan')->find($id);

        // Cek apakah data ditemukan
        if ($pemetaan === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Menyiapkan data untuk view
        $data = [
            'title' => 'Edit Pemetaan Pengembangan Jaringan',
            'isi' => 'StafSeksi/edit_pj',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan,
        ];

        // Menampilkan view dengan data yang telah disiapkan
        return view('StafSeksi/v_wrapper', $data);
    }

    public function view_pj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Pemetaan Pengembangan Jaringan',
            'isi' => 'StafSeksi/v_pj',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan,
        ];

        return view('StafSeksi/v_wrapper', $data);
    }

    public function update_pj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data dari form
        $jenis_pekerjaan = $this->request->getPost('jenis_pekerjaan');
        $keterangan_data = [];

        // Tambahan untuk checkbox jenis pekerjaan dengan keterangan
        if ($jenis_pekerjaan) {
            foreach ($jenis_pekerjaan as $jenis) {
                switch ($jenis) {
                    case 'Pengembangan Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_pengembangan');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Rehabilitasi Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_rehabilitasi');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Perbaikan Kebocoran Pipa':
                        $keterangan = $this->request->getPost('keterangan_rkebocoran');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Pindah Tapping/PE-Nisasi':
                        $keterangan = $this->request->getPost('keterangan_pindah');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Lain-lain':
                        $keterangan = $this->request->getPost('keterangan_lain');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                }
            }
        }

        // Data yang akan diupdate
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'jenis_pekerjaan' => implode(',', $jenis_pekerjaan),
            'lokasi' => $this->request->getPost('lokasi'),
            'nilai_pekerjaan' => str_replace(['Rp ', '.'], ['', ''], $this->request->getPost('nilai_pekerjaan')),
            'bagian' => $this->request->getPost('bagian'),
            'nt_spk' => $this->request->getPost('nt_spk'),
            'nt_ba_perubahan' => $this->request->getPost('nt_ba_perubahan'),
            'nt_ba_pembayaran' => $this->request->getPost('nt_ba_pembayaran'),
            'nt_ba_selesai' => $this->request->getPost('nt_ba_selesai'),
            'tgl_masuk_berkas' => $this->request->getPost('tgl_masuk_berkas'),
            'no_surat' => $this->request->getPost('no_surat'),
            'nama_kepsek' => $this->request->getPost('nama_kepsek'),
            'nik_kepsek' => $this->request->getPost('nik_kepsek'),
            'nama_penginput' => $this->request->getPost('nama_penginput'),
            'nik_penginput' => $this->request->getPost('nik_penginput'),
            'catatan' => $this->request->getPost('catatan'),
            'keterangan' => implode('; ', $keterangan_data), // Menggunakan format string biasa
        ];

        // Update data di database
        if ($model_suratketerangan->update($id, $data)) {
            $session = session();
            $session->setFlashdata('success', 'Data berhasil diupdate.');
        } else {
            $session = session();
            $session->setFlashdata('error', 'Gagal mengupdate data.');
        }

        return redirect()->to(base_url('StafSeksi/pengembang_jaringan'));
    }

    public function delete_pj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data berdasarkan ID untuk mendapatkan kategori
        $data = $model_suratketerangan->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to(base_url('StafSeksi/pengembang_jaringan'));
        }

        $kategori = $data['kategori']; // Sesuaikan dengan nama kolom kategori di tabel Anda

        if ($model_suratketerangan->delete_by_kategori($kategori, $id)) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
        }

        return redirect()->to(base_url('StafSeksi/pengembang_jaringan'));
    }


    // FUNGSI UNTUK VIEWS PEMETAAN SWADAYA
    public function sipil_me()
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }


        $data = array(
            'title' => 'Sipil & Me',
            'isi' => 'StafSeksi/sipil_me',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $model_suratketerangan->get_sipildanme()
        );
        return view('StafSeksi/v_wrapper', $data);
    }

    // Menampilkan halaman edit PS
    public function edit_sm($id)
    {
        // Inisialisasi model
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }


        // Mengambil data pemetaan swadaya berdasarkan ID dan kategori 'Pemetaan Swadaya'
        $pemetaan = $model_suratketerangan->where('kategori', 'Sipil & Me')->find($id);

        // Cek apakah data ditemukan
        if ($pemetaan === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Menyiapkan data untuk view
        $data = [
            'title' => 'Edit Sipil & Me',
            'isi' => 'StafSeksi/edit_sm',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan,
        ];

        // Menampilkan view dengan data yang telah disiapkan
        return view('StafSeksi/v_wrapper', $data);
    }

    public function view_sm($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Sipil & Me',
            'isi' => 'StafSeksi/v_sm',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan,
        ];

        return view('StafSeksi/v_wrapper', $data);
    }

    public function update_sm($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data dari form
        $jenis_pekerjaan = $this->request->getPost('jenis_pekerjaan');
        $keterangan_data = [];

        // Tambahan untuk checkbox jenis pekerjaan dengan keterangan
        if ($jenis_pekerjaan) {
            foreach ($jenis_pekerjaan as $jenis) {
                switch ($jenis) {
                    case 'Pengembangan Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_pengembangan');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Rehabilitasi Jaringan Pipa':
                        $keterangan = $this->request->getPost('keterangan_rehabilitasi');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Perbaikan Kebocoran Pipa':
                        $keterangan = $this->request->getPost('keterangan_rkebocoran');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Pindah Tapping/PE-Nisasi':
                        $keterangan = $this->request->getPost('keterangan_pindah');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                    case 'Lain-lain':
                        $keterangan = $this->request->getPost('keterangan_lain');
                        if (!empty($keterangan)) {
                            $keterangan_data[] = $keterangan;
                        }
                        break;
                }
            }
        }

        // Data yang akan diupdate
        $data = [
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'jenis_pekerjaan' => implode(',', $jenis_pekerjaan),
            'lokasi' => $this->request->getPost('lokasi'),
            'nilai_pekerjaan' => str_replace(['Rp ', '.'], ['', ''], $this->request->getPost('nilai_pekerjaan')),
            'bagian' => $this->request->getPost('bagian'),
            'nt_spk' => $this->request->getPost('nt_spk'),
            'nt_ba_perubahan' => $this->request->getPost('nt_ba_perubahan'),
            'nt_ba_pembayaran' => $this->request->getPost('nt_ba_pembayaran'),
            'nt_ba_selesai' => $this->request->getPost('nt_ba_selesai'),
            'tgl_masuk_berkas' => $this->request->getPost('tgl_masuk_berkas'),
            'no_surat' => $this->request->getPost('no_surat'),
            'nama_kepsek' => $this->request->getPost('nama_kepsek'),
            'nik_kepsek' => $this->request->getPost('nik_kepsek'),
            'nama_penginput' => $this->request->getPost('nama_penginput'),
            'nik_penginput' => $this->request->getPost('nik_penginput'),
            'catatan' => $this->request->getPost('catatan'),
            'keterangan' => implode('; ', $keterangan_data), // Menggunakan format string biasa
        ];

        // Update data di database
        if ($model_suratketerangan->update($id, $data)) {
            $session = session();
            $session->setFlashdata('success', 'Data berhasil diupdate.');
        } else {
            $session = session();
            $session->setFlashdata('error', 'Gagal mengupdate data.');
        }

        return redirect()->to(base_url('StafSeksi/sipil_me'));
    }

    public function delete_sm($id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Ambil data berdasarkan ID untuk mendapatkan kategori
        $data = $model_suratketerangan->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
            return redirect()->to(base_url('StafSeksi/sipil_me'));
        }

        $kategori = $data['kategori']; // Sesuaikan dengan nama kolom kategori di tabel Anda

        if ($model_suratketerangan->delete_by_kategori($kategori, $id)) {
            session()->setFlashdata('success', 'Data berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data.');
        }

        return redirect()->to(base_url('StafSeksi/sipil_me'));
    }

    public function get_surat_keterangan_data($id = null)
    {
        $modelSm = new Model_suratketerangan();

        if ($id) {
            $data = $modelSm->find($id);
            if ($data) {
                return $this->response->setJSON($data);
            }
        }

        return $this->response->setJSON([]);
    }


    //TAMPILKAN BERITA ACARA
    public function berita_acara()
    {
        $model_ba = new Model_ba();
        $modelSm = new Model_suratketerangan();

        // Mengambil data berita acara dengan data dari surat_keterangan
        $dataBeritaAcara = $model_ba->getAllBaWithSuratKeterangan();


        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $data = array(
            'title' => 'Berita Acara Pembayaran',
            'isi' => 'StafSeksi/berita_acara_pembayaran',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $dataBeritaAcara
        );
        return view('StafSeksi/v_wrapper', $data);
    }

    public function tambah_ba()
    {
        $modelSm = new Model_suratketerangan();

        // Mengambil semua data dari surat_keterangan untuk dropdown pilihan
        $dataSuratKeterangan = $modelSm->findAll();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $data = array(
            'title' => 'Tambah Berita Acara Pembayaran',
            'isi' => 'StafSeksi/input_ba',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'surat_keterangan' => $dataSuratKeterangan

        );
        return view('StafSeksi/v_wrapper', $data);
    }

    // SIMPAN DATA BERITA ACARA
    public function save_ba()
    {
        $model_ba = new Model_ba();

        // Ambil data dari post
        $id_suratketerangan = $this->request->getPost('id_suratketerangan');
        if (!$id_suratketerangan) {
            return redirect()->back()->with('error', 'ID Surat Keterangan tidak boleh kosong.');
        }

        $data = [
            'id_suratketerangan' => $id_suratketerangan,
            'nomor_ba' => $this->request->getPost('nomor_ba'),
            'nama_ph1' => $this->request->getPost('nama_ph1'),
            'jabatan_ph1' => $this->request->getPost('jabatan_ph1'),
            'alamat_ph1' => $this->request->getPost('alamat_ph1'),
            'lokasi' => $this->request->getPost('lokasi'),
            'nama_ph2' => $this->request->getPost('nama_ph2'),
            'jabatan_ph2' => $this->request->getPost('jabatan_ph2'),
            'alamat_ph2' => $this->request->getPost('alamat_ph2'),
            'surat_permohonan_bayar' => $this->request->getPost('surat_permohonan_bayar'),
            'nt_spk' => $this->request->getPost('nt_spk'),
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'nilai_pekerjaan' => str_replace(['Rp ', '.'], '', $this->request->getPost('nilai_pekerjaan')),
            'ppn' => str_replace(['Rp ', '.'], '', $this->request->getPost('ppn')),
            'total' => str_replace(['Rp ', '.'], '', $this->request->getPost('total')),
            'terbilang' => $this->request->getPost('terbilang'),
            'hari' => $this->request->getPost('hari'),
            'tanggal' => $this->request->getPost('tanggal'),
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'ttd_jabatan_kedua' => $this->request->getPost('ttd_jabatan_kedua'),
            'ttd_jabatan_pertama' => $this->request->getPost('ttd_jabatan_pertama')
        ];

        if ($model_ba->save($data)) {
            return redirect()->to(base_url('StafSeksi/berita_acara'))->with('success', 'Data berhasil ditambahkan!');
        } else {
            return redirect()->to(base_url('StafSeksi/tambah_ba'))->with('error', 'Gagal menambahkan data.');
        }
    }
    public function edit_ba($id_ba)
    {
        $model_ba = new Model_ba();
        $modelSm = new Model_suratketerangan();

        $dataBeritaAcara = $model_ba->find($id_ba);
        $dataSuratKeterangan = $modelSm->findAll();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $data = array(
            'title' => 'Edit Berita Acara Pembayaran',
            'isi' => 'StafSeksi/edit_ba',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'berita_acara' => $dataBeritaAcara,
            'surat_keterangan' => $dataSuratKeterangan
        );
        return view('StafSeksi/v_wrapper', $data);
    }

    public function update_ba($id_ba)
    {
        $model_ba = new Model_ba();

        $data = [
            'id_suratketerangan' => $this->request->getPost('id_suratketerangan'),
            'nomor_ba' => $this->request->getPost('nomor_ba'),
            'nama_pekerjaan' => $this->request->getPost('nama_pekerjaan'),
            'nama_ph1' => $this->request->getPost('nama_ph1'),
            'jabatan_ph1' => $this->request->getPost('jabatan_ph1'),
            'alamat_ph1' => $this->request->getPost('alamat_ph1'),
            'lokasi' => $this->request->getPost('lokasi'),
            'nama_ph2' => $this->request->getPost('nama_ph2'),
            'jabatan_ph2' => $this->request->getPost('jabatan_ph2'),
            'alamat_ph2' => $this->request->getPost('alamat_ph2'),
            'surat_permohonan_bayar' => $this->request->getPost('surat_permohonan_bayar'),
            'nt_spk' => $this->request->getPost('nt_spk'),
            'nilai_pekerjaan' => str_replace(['Rp ', '.'], '', $this->request->getPost('nilai_pekerjaan')),
            'ppn' => str_replace(['Rp ', '.'], '', $this->request->getPost('ppn')),
            'total' => str_replace(['Rp ', '.'], '', $this->request->getPost('total')),
            'terbilang' => $this->request->getPost('terbilang'),
            'hari' => $this->request->getPost('hari'),
            'tanggal' => $this->request->getPost('tanggal'),
            'bulan' => $this->request->getPost('bulan'),
            'tahun' => $this->request->getPost('tahun'),
            'pelaksana' => $this->request->getPost('pelaksana'),
            'ttd_jabatan_kedua' => $this->request->getPost('ttd_jabatan_kedua'),
            'ttd_jabatan_pertama' => $this->request->getPost('ttd_jabatan_pertama')
        ];

        if ($model_ba->update_ba($id_ba, $data)) {
            return redirect()->to(base_url('StafSeksi/berita_acara'))->with('success', 'Data berhasil diupdate!');
        } else {
            return redirect()->to(base_url('StafSeksi/berita_acara'))->with('error', 'Gagal mengupdate data.');
        }
    }

    public function view_ba($id_ba)
    {
        $model_ba = new Model_ba();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $pemetaan = $model_ba->find($id_ba);

        $data = [
            'title' => 'View Berita Acara Pembayaran',
            'isi' => 'StafSeksi/v_ba',
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'pemetaan' => $pemetaan,
        ];

        return view('StafSeksi/v_wrapper', $data);
    }
    public function delete_ba($id_ba)
    {
        // Panggil model untuk menghapus data
        if ($this->model_ba->delete_ba($id_ba)) {
            // Set flashdata sukses
            session()->setFlashdata('success', 'Data Berita Acara berhasil dihapus.');
        } else {
            // Set flashdata error
            session()->setFlashdata('error', 'Gagal menghapus data Berita Acara.');
        }

        // Redirect ke halaman daftar berita acara
        return redirect()->to(base_url('StafSeksi/berita_acara'));
    }



    public function profile()
    {
        $model_user = new Model_user();
        $modelSm = new Model_suratketerangan();

        // Hitung jumlah pekerjaan baru untuk setiap kategori
        $jumlahBaruPemetaanSwadaya = $modelSm->count_new_jobs_by_kategori('Pemetaan Swadaya');
        $jumlahBaruRehabJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Rehab Jaringan');
        $jumlahBaruPengembanganJaringan = $modelSm->count_new_jobs_by_kategori('Pemetaan Pengembangan Jaringan');
        $jumlahBaruSipilDanMe = $modelSm->count_new_jobs_by_kategori('Sipil & Me');

        // Total jumlah pekerjaan baru
        $jumlahBaru = $jumlahBaruPemetaanSwadaya + $jumlahBaruRehabJaringan + $jumlahBaruPengembanganJaringan + $jumlahBaruSipilDanMe;

        // Kirim notifikasi email jika ada pekerjaan baru
        if ($jumlahBaru > 0) {
            $this->sendNotificationEmail($jumlahBaru);
        }

        // Persiapkan notifikasi untuk ditampilkan di topbar
        $alerts = [];
        if ($jumlahBaruPemetaanSwadaya > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPemetaanSwadaya pekerjaan baru di Pemetaan Swadaya!",
                'url' => '/StafSeksi/pemetaan_swadaya'
            ];
        }
        if ($jumlahBaruRehabJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruRehabJaringan pekerjaan baru di Pemetaan Rehab Jaringan!",
                'url' => '/StafSeksi/rehab_jaringan'
            ];
        }
        if ($jumlahBaruPengembanganJaringan > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruPengembanganJaringan pekerjaan baru di Pemetaan Pengembangan Jaringan!",
                'url' => '/StafSeksi/pengembang_jaringan'
            ];
        }
        if ($jumlahBaruSipilDanMe > 0) {
            $alerts[] = [
                'message' => "Terdapat $jumlahBaruSipilDanMe pekerjaan baru di Sipil & Me!",
                'url' => '/StafSeksi/sipil_me'
            ];
        }

        $user_id = session()->get('id_user');

        // Debugging: Tampilkan ID pengguna
        log_message('debug', 'ID pengguna di session: ' . $user_id);

        if (!$user_id) {
            log_message('error', 'ID pengguna tidak ditemukan dalam session di profil.');
        }

        $user = $model_user->find($user_id);

        $data = [
            'title' => 'Profile',
            'isi' => 'StafSeksi/v_profile',
            'user' => $user,
            'jumlah_baru' => $jumlahBaru,
            'alerts' => $alerts,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error')
        ];

        return view('StafSeksi/v_wrapper', $data);
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

    // PROSES CETAK SURAT KETERANGAN
    public function __construct()
    {
        $this->model_suratketerangan = new Model_suratketerangan();
        $this->model_ba = new Model_ba();
    }

    protected $model_suratketerangan;
    protected $model_ba;

    public function surat_keterangan_ps($id)
    {
        // Mengambil data berdasarkan ID
        $data['ps'] = $this->model_suratketerangan->find($id);

        // Cek jika data ditemukan
        if ($data['ps'] === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Memisahkan jenis pekerjaan menjadi array
        $data['jenis_pekerjaan'] = !empty($data['ps']['jenis_pekerjaan'])
            ? explode(', ', $data['ps']['jenis_pekerjaan'])
            : [];

        // Menentukan data jenis pekerjaan lain jika ada
        $data['jenis_pekerjaan_lain'] = '';
        if (in_array('Lain-lain', $data['jenis_pekerjaan'])) {
            // Ambil nilai lain jika tersedia
            $data['jenis_pekerjaan_lain'] = isset($data['ps']['jenis_pekerjaan_lain'])
                ? $data['ps']['jenis_pekerjaan_lain']
                : '';
        }

        // Mendapatkan keterangan untuk setiap jenis pekerjaan
        $data['keterangan'] = [];
        foreach ($data['jenis_pekerjaan'] as $jenis) {
            $data['keterangan'][$jenis] = $this->model_suratketerangan->getKeterangan_ps($jenis);
        }

        // Filter data berdasarkan kategori 'Pemetaan Swadaya'
        if ($data['ps']['kategori'] === 'Pemetaan Swadaya') {
            // Mengambil data berdasarkan kategori 'Pemetaan Swadaya'
            $data['ps'] = $this->model_suratketerangan->where('kategori', 'Pemetaan Swadaya')->find($id);
        }

        // Load view
        echo view('StafSeksi/surat_keterangan_ps', $data);
    }

    public function surat_keterangan_rj($id)
    {
        // Mengambil data berdasarkan ID
        $data['rj'] = $this->model_suratketerangan->find($id);

        // Cek jika data ditemukan
        if ($data['rj'] === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Memisahkan jenis pekerjaan menjadi array
        $data['jenis_pekerjaan'] = !empty($data['rj']['jenis_pekerjaan'])
            ? explode(', ', $data['rj']['jenis_pekerjaan'])
            : [];

        // Menentukan data jenis pekerjaan lain jika ada
        $data['jenis_pekerjaan_lain'] = '';
        if (in_array('Lain-lain', $data['jenis_pekerjaan'])) {
            // Ambil nilai lain jika tersedia
            $data['jenis_pekerjaan_lain'] = isset($data['rj']['jenis_pekerjaan_lain'])
                ? $data['rj']['jenis_pekerjaan_lain']
                : '';
        }

        // Mendapatkan keterangan untuk setiap jenis pekerjaan
        $data['keterangan'] = [];
        foreach ($data['jenis_pekerjaan'] as $jenis) {
            $data['keterangan'][$jenis] = $this->model_suratketerangan->getKeterangan_rj($jenis);
        }

        // Filter data berdasarkan kategori 'Pemetaan Swadaya'
        if ($data['rj']['kategori'] === 'Pemetaan Swadaya') {
            // Mengambil data berdasarkan kategori 'Pemetaan Swadaya'
            $data['rj'] = $this->model_suratketerangan->where('kategori', 'Pemetaan Swadaya')->find($id);
        }

        // Load view
        echo view('StafSeksi/surat_keterangan_rj', $data);
    }

    public function surat_keterangan_pj($id)
    {
        // Mengambil data berdasarkan ID
        $data['pj'] = $this->model_suratketerangan->find($id);

        // Cek jika data ditemukan
        if ($data['pj'] === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Memisahkan jenis pekerjaan menjadi array
        $data['jenis_pekerjaan'] = !empty($data['pj']['jenis_pekerjaan'])
            ? explode(', ', $data['pj']['jenis_pekerjaan'])
            : [];

        // Menentukan data jenis pekerjaan lain jika ada
        $data['jenis_pekerjaan_lain'] = '';
        if (in_array('Lain-lain', $data['jenis_pekerjaan'])) {
            // Ambil nilai lain jika tersedia
            $data['jenis_pekerjaan_lain'] = isset($data['pj']['jenis_pekerjaan_lain'])
                ? $data['pj']['jenis_pekerjaan_lain']
                : '';
        }

        // Mendapatkan keterangan untuk setiap jenis pekerjaan
        $data['keterangan'] = [];
        foreach ($data['jenis_pekerjaan'] as $jenis) {
            $data['keterangan'][$jenis] = $this->model_suratketerangan->getKeterangan_pj($jenis);
        }

        // Filter data berdasarkan kategori 'Pemetaan Swadaya'
        if ($data['pj']['kategori'] === 'Pemetaan Swadaya') {
            // Mengambil data berdasarkan kategori 'Pemetaan Swadaya'
            $data['pj'] = $this->model_suratketerangan->where('kategori', 'Pemetaan Swadaya')->find($id);
        }

        // Load view
        echo view('StafSeksi/surat_keterangan_pj', $data);
    }

    public function surat_keterangan_sm($id)
    {
        // Mengambil data berdasarkan ID
        $data['sm'] = $this->model_suratketerangan->find($id);

        // Cek jika data ditemukan
        if ($data['sm'] === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data dengan ID $id tidak ditemukan.");
        }

        // Memisahkan jenis pekerjaan menjadi array
        $data['jenis_pekerjaan'] = !empty($data['sm']['jenis_pekerjaan'])
            ? explode(', ', $data['sm']['jenis_pekerjaan'])
            : [];

        // Menentukan data jenis pekerjaan lain jika ada
        $data['jenis_pekerjaan_lain'] = '';
        if (in_array('Lain-lain', $data['jenis_pekerjaan'])) {
            // Ambil nilai lain jika tersedia
            $data['jenis_pekerjaan_lain'] = isset($data['sm']['jenis_pekerjaan_lain'])
                ? $data['sm']['jenis_pekerjaan_lain']
                : '';
        }

        // Mendapatkan keterangan untuk setiap jenis pekerjaan
        $data['keterangan'] = [];
        foreach ($data['jenis_pekerjaan'] as $jenis) {
            $data['keterangan'][$jenis] = $this->model_suratketerangan->getKeterangan_sm($jenis);
        }

        // Filter data berdasarkan kategori 'Pemetaan Swadaya'
        if ($data['sm']['kategori'] === 'Pemetaan Swadaya') {
            // Mengambil data berdasarkan kategori 'Pemetaan Swadaya'
            $data['sm'] = $this->model_suratketerangan->where('kategori', 'Pemetaan Swadaya')->find($id);
        }

        // Load view
        echo view('StafSeksi/surat_keterangan_sm', $data);
    }

    public function cetak_berita_acara($id_ba)
    {
        // Ambil data berita acara berdasarkan ID
        $data['berita_acara'] = $this->model_ba->find($id_ba);

        // Pastikan data ditemukan
        if (!$data['berita_acara']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        // Tampilkan view cetak dengan data
        return view('StafSeksi/cetak_ba', $data);
    }
}
