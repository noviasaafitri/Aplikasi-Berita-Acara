<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function Beranda()
    {
        $data = array(
            'title' => 'Beranda',
            'isi' => 'Login/v_beranda'
        );
        return view('Login/v_wrapper', $data);
    }
}
