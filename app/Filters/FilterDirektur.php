<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FilterDirektur implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $currentURI = service('uri')->getPath();

        // Cek apakah rute saat ini adalah beranda dan tidak login
        if (session()->get('level') == "" && strpos($currentURI, 'web') === false) {
            session()->setFlashdata('pesan', 'Maaf, Anda Belum Login, Silahkan Login Dulu !!');
            return redirect()->to(base_url('Web/Beranda'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
        if (session()->get('level') == 3) {
            return redirect()->to(base_url('Direktur/home'));
        }
    }
}
