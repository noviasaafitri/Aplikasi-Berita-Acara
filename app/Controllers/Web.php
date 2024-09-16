<?php

namespace App\Controllers;

class Web extends BaseController
{
    public function Beranda()
    {
        $data = array(
            'title' => 'Beranda',
        );
        return view('Login/v_beranda', $data);
    }
}
