<?php

namespace App\Controllers;


use App\Models\Model_ba;
use App\Models\Model_suratketerangan;
use App\Models\Model_user;

class Direktur extends BaseController
{

    public function home()
    {
        $modelSm = new Model_suratketerangan();

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
            'isi' => 'direktur/v_home',
            'jumlah_verifikasi' => $jumlahVerifikasi,
            'jumlah_ditolak' => $jumlahDitolak,
            'jumlah_proses_verifikasi' => $jumlahProsesVerifikasi
        );

        return view('Direktur/v_wrapper', $data);
    }
    // FUNGSI UNTUK VIEWS PEMETAAN SWADAYA
    public function pemetaan_swadaya()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Pemetaan Swadaya',
            'isi' => 'Direktur/pemetaan_swadaya',
            'pemetaan' => $model_suratketerangan->get_pemetaan_swadaya()
        );
        return view('Direktur/v_wrapper', $data);
    }

    public function view_ps($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Pemetaan Swadaya',
            'isi' => 'Direktur/v_ps',
            'pemetaan' => $pemetaan,
        ];

        return view('Direktur/v_wrapper', $data);
    }

    public function update_status_by_kategori_ps($kategori, $status, $id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Validasi status
        $valid_status = ['terverifikasi', 'ditolak'];
        if (!in_array(strtolower($status), $valid_status)) {
            session()->setFlashdata('error', 'Status tidak valid.');
            return redirect()->to("Direktur/view_ps/{$id}"); // Redirect ke halaman view_ps dengan ID
        }

        // Perbarui status berdasarkan kategori
        if ($model_suratketerangan->update_status_by_category($kategori, ucfirst($status))) {
            session()->setFlashdata('success', 'Status berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui status.');
        }

        return redirect()->to("Direktur/view_ps/{$id}"); // Redirect ke halaman view_ps dengan ID
    }

    public function rehab_jaringan()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Pemetaan Swadaya',
            'isi' => 'direktur/rehab_jaringan',
            'pemetaan' => $model_suratketerangan->get_rehab_jaringan()
        );
        return view('Direktur/v_wrapper', $data);
    }

    public function view_rj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Pemetaan Rehab Jaringan',
            'isi' => 'Direktur/v_rj',
            'pemetaan' => $pemetaan,
        ];

        return view('Direktur/v_wrapper', $data);
    }
    public function update_status_by_kategori_rj($kategori, $status, $id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Validasi status
        $valid_status = ['terverifikasi', 'ditolak'];
        if (!in_array(strtolower($status), $valid_status)) {
            session()->setFlashdata('error', 'Status tidak valid.');
            return redirect()->to("Direktur/view_rj/{$id}"); // Redirect ke halaman view_ps dengan ID
        }
        // Perbarui status berdasarkan kategori
        if ($model_suratketerangan->update_status_by_category($kategori, ucfirst($status))) {
            session()->setFlashdata('success', 'Status berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui status.');
        }

        return redirect()->to("Direktur/view_rj/{$id}"); // Redirect ke halaman view_ps dengan ID
    }


    //TAMPILKAN PENGEMBANGAN JARINGAN
    public function pengembang_jaringan()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Pemetaan Pengembangan Jaringan',
            'isi' => 'Direktur/pengembang_jaringan',
            'pemetaan' => $model_suratketerangan->get_pengembangan_jaringan()
        );
        return view('Direktur/v_wrapper', $data);
    }

    public function view_pj($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Pemetaan Swadaya',
            'isi' => 'Direktur/v_pj',
            'pemetaan' => $pemetaan,
        ];

        return view('Direktur/v_wrapper', $data);
    }

    public function update_status_by_kategori_sm($kategori, $status, $id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Validasi status
        $valid_status = ['terverifikasi', 'ditolak'];
        if (!in_array(strtolower($status), $valid_status)) {
            session()->setFlashdata('error', 'Status tidak valid.');
            return redirect()->to("Direktur/view_sm/{$id}"); // Redirect ke halaman view_ps dengan ID
        }
        // Perbarui status berdasarkan kategori
        if ($model_suratketerangan->update_status_by_category($kategori, ucfirst($status))) {
            session()->setFlashdata('success', 'Status berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui status.');
        }

        return redirect()->to("Direktur/view_sm/{$id}"); // Redirect ke halaman view_ps dengan ID
    }

    public function sipil_me()
    {
        $model_suratketerangan = new Model_suratketerangan();

        $data = array(
            'title' => 'Sipil & Me',
            'isi' => 'Direktur/sipil_me',
            'pemetaan' => $model_suratketerangan->get_sipildanme()
        );
        return view('Direktur/v_wrapper', $data);
    }

    public function view_sm($id)
    {
        $model_suratketerangan = new Model_suratketerangan();
        $pemetaan = $model_suratketerangan->find($id);

        $data = [
            'title' => 'View Pemetaan Swadaya',
            'isi' => 'Direktur/v_sm',
            'pemetaan' => $pemetaan,
        ];

        return view('Direktur/v_wrapper', $data);
    }

    public function update_status_by_kategori_pj($kategori, $status, $id)
    {
        $model_suratketerangan = new Model_suratketerangan();

        // Validasi status
        $valid_status = ['terverifikasi', 'ditolak'];
        if (!in_array(strtolower($status), $valid_status)) {
            session()->setFlashdata('error', 'Status tidak valid.');
            return redirect()->to("Direktur/view_sm/{$id}"); // Redirect ke halaman view_ps dengan ID
        }
        // Perbarui status berdasarkan kategori
        if ($model_suratketerangan->update_status_by_category($kategori, ucfirst($status))) {
            session()->setFlashdata('success', 'Status berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui status.');
        }

        return redirect()->to("Direktur/view_sm/{$id}"); // Redirect ke halaman view_ps dengan ID
    }


    //TAMPILKAN BERITA ACARA
    public function berita_acara()
    {
        $model_ba = new Model_ba();

        // Mengambil data berita acara dengan data dari surat_keterangan
        $dataBeritaAcara = $model_ba->getAllBaWithSuratKeterangan();

        $data = array(
            'title' => 'Berita Acara Pembayaran',
            'isi' => 'Direktur/berita_acara_pembayaran',
            'pemetaan' => $dataBeritaAcara
        );
        return view('Direktur/v_wrapper', $data);
    }

    public function view_ba($id_ba)
    {
        $model_ba = new Model_ba();
        $pemetaan = $model_ba->find($id_ba);

        $data = [
            'title' => 'View Berita Acara Pembayaran',
            'isi' => 'Direktur/v_ba',
            'pemetaan' => $pemetaan,
        ];

        return view('Direktur/v_wrapper', $data);
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
            'isi' => 'direktur/v_profile',
            'user' => $user,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error')
        ];

        return view('direktur/v_wrapper', $data);
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
        echo view('Direktur/surat_keterangan_ps', $data);
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
        echo view('Direktur/surat_keterangan_rj', $data);
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
        echo view('Direktur/surat_keterangan_pj', $data);
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
        echo view('Direktur/surat_keterangan_sm', $data);
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
        return view('direktur/cetak_ba', $data);
    }
}
