<?php

namespace App\Controllers;

use App\Models\Model_Auth;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    protected $Model_Auth;
    protected $email;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->Model_Auth = new Model_Auth();
        // Load email library
        $this->email = \Config\Services::email();
    }

    public function register()
    {
        $data = array(
            'title' => 'Register',
        );
        return view('Login/v_register', $data);
    }

    public function save_register()
    {
        if ($this->validate([
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi dan Tidak Boleh Kosong !!!',
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi dan Tidak Boleh Kosong !!!',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi dan Tidak Boleh Kosong !!!',
                ]
            ],
            'repassword' => [
                'label' => 'Ulang Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} Wajib Diisi dan Tidak Boleh Kosong !!!',
                    'matches' => '{field} Tidak Sama !!!'
                ]
            ],
        ])) {
            $data = array(
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'), // Hashing dilakukan di Model_Auth
                'email' => $this->request->getPost('email'),
                'level' => 4,
                'profile' => 'images.png',
                'deskripsi' => 'Instalatir',

            );
            $this->Model_Auth->save_register($data);
            // Set session data for user profile
            session()->set([
                'username' => $data['username'],
                'nama_lengkap' => $data['nama_lengkap'],
                'profile' => $data['profile'],
                'deskripsi' => $data['deskripsi'],
                'email' => $data['email']
            ]);

            session()->setFlashdata('pesan', 'Register Berhasil !!!');
            return redirect()->to(base_url('Auth/register'));
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Auth/register'));
        }
    }

    public function login()
    {
        $data = array(
            'title' => 'Login',
        );
        return view('Login/v_login', $data);
    }

    public function cek_login()
    {
        if ($this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi dan Tidak Boleh Kosong !!!',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi dan Tidak Boleh Kosong !!!',
                ]
            ],
        ])) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $user = $this->Model_Auth->login($username, $password);

            if ($user) {
                session()->set('log', true);
                session()->set('email', $user['email']);
                session()->set('id_user', $user['id_user']);
                session()->set('nama_lengkap', $user['nama_lengkap']);
                session()->set('username', $user['username']);
                session()->set('level', $user['level']);
                session()->set('profile', $user['profile']);
                session()->set('deskripsi', $user['deskripsi']);
                return redirect()->to(base_url('home'));
            } else {
                session()->setFlashdata('pesan', 'Login Gagal !! Username Atau Password Salah !!');
                return redirect()->to(base_url('auth/login'));
            }
        } else {
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function logout()
    {
        session()->remove('log');
        session()->remove('email');
        session()->remove('nama_lengkap');
        session()->remove('level');
        session()->remove('profile');
        session()->remove('deskripsi');
        session()->setFlashdata('pesan', 'Logout Sukses !!');
        return redirect()->to(base_url('Web/Beranda'));
    }

    // Menampilkan halaman form lupa password
    public function forgot_password()
    {
        $data = [
            'title' => 'Lupa Password',
        ];
        return view('Login/v_lupapass', $data);
    }

    public function proses_forgot_password()
    {
        $email = $this->request->getPost('email');
        $user = $this->Model_Auth->where('email', $email)->first();

        if ($user) {
            // Buat token reset
            $token = bin2hex(random_bytes(32));
            $expires = Time::now()->addHours(1); // Token berlaku 1 jam

            // Simpan token dan waktu kedaluwarsa di database
            $updateResult = $this->Model_Auth->update_user($user['id_user'], [
                'reset_token' => $token,
                'reset_expires' => $expires->toDateTimeString()
            ]);

            if ($updateResult) {
                // Kirim email ke user dengan link untuk reset password
                $resetLink = base_url('auth/reset_password/' . $token);
                $message = "Klik tautan berikut untuk mereset password Anda: <a href='" . $resetLink . "'>" . $resetLink . "</a>";

                $this->email->setFrom('novia.safitri778@gmail.com', 'Your App Name');
                $this->email->setTo($email);
                $this->email->setSubject('Reset Password');
                $this->email->setMessage($message);
                $this->email->setMailType('html'); // Set email type to HTML

                if ($this->email->send()) {
                    session()->setFlashdata('pesan', 'Link reset password telah dikirimkan ke email Anda.');
                    return redirect()->to(base_url('auth/forgot_password'));
                } else {
                    $data = $this->email->printDebugger();
                    session()->setFlashdata('errors', ['email' => 'Gagal mengirim email: ' . print_r($data, true)]);
                    return redirect()->to(base_url('auth/forgot_password'));
                }
            } else {
                session()->setFlashdata('errors', ['email' => 'Gagal menyimpan token reset']);
                return redirect()->to(base_url('auth/forgot_password'));
            }
        } else {
            session()->setFlashdata('errors', ['email' => 'Email tidak ditemukan']);
            return redirect()->to(base_url('auth/forgot_password'));
        }
    }

    // Menampilkan halaman reset password
    public function reset_password($token)
    {
        $user = $this->Model_Auth->where('reset_token', $token)
            ->where('reset_expires >=', Time::now()->toDateTimeString())
            ->first();

        if ($user) {
            $data = [
                'title' => 'Reset Password',
                'token' => $token
            ];
            return view('Login/v_reset_password', $data);
        } else {
            session()->setFlashdata('errors', ['token' => 'Token tidak valid atau telah kedaluwarsa']);
            return redirect()->to(base_url('auth/forgot_password'));
        }
    }

    // Proses reset password
    public function proses_reset_password()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $repassword = $this->request->getPost('repassword');

        if (!is_string($token) || !is_string($password) || !is_string($repassword)) {
            session()->setFlashdata('errors', 'Input tidak valid.');
            return redirect()->to(base_url('auth/reset_password/' . $token));
        }

        if ($password === $repassword) {
            // Hash password sebelum disimpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = $this->Model_Auth->where('reset_token', $token)
                ->where('reset_expires >=', Time::now()->toDateTimeString())
                ->first();

            if ($user) {
                // Update password yang sudah di-hash
                $this->Model_Auth->update($user['id_user'], [
                    'password' => $hashedPassword,
                    'reset_token' => null,
                    'reset_expires' => null
                ]);

                session()->setFlashdata('pesan', 'Password berhasil direset. Silakan login.');
                return redirect()->to(base_url('auth/login'));
            } else {
                session()->setFlashdata('errors', ['token' => 'Token tidak valid atau telah kedaluwarsa']);
                return redirect()->to(base_url('auth/forgot_password'));
            }
        } else {
            session()->setFlashdata('errors', ['repassword' => 'Konfirmasi password tidak cocok']);
            return redirect()->to(base_url('auth/reset_password/' . $token));
        }
    }
}
