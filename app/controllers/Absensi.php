<?php

class Absensi extends BaseController
{
    public function index()
    {
        if (!isset($_SESSION['user']['id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $nisn = $_SESSION['user']['id'];


        $gurumodel = $this->model('GuruModel');
        $guru = $gurumodel->getGuruByKode($nisn);

        return parent::view('absensi/index', [
            'guru' => $guru,
        ]);
    }
}

