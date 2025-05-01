<?php

class Error extends BaseController 
{
    public function index()
    {
        $data['title'] = '404 Not Found';
        $data['message'] = 'Halaman yang Anda cari tidak ditemukan.';
        $this->view('error/index', $data);
    }

    public function forbidden()
    {
        $data['title'] = '403 Forbidden';
        $data['message'] = 'Anda tidak memiliki akses ke halaman ini.';
        $this->view('error/index', $data);
    }

    public function serverError()
    {
        $data['title'] = '500 Server Error';
        $data['message'] = 'Terjadi kesalahan pada server.';
        $this->view('error/index', $data);
    }

    public function unauthorized()
    {
        $data['title'] = '401 Unauthorized';
        $data['message'] = 'Silakan login terlebih dahulu.';
        $this->view('error/index', $data);
    }
}