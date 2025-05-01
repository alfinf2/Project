<?php

class Home extends BaseController
{
    public function index()
    {
        if (!isset($_SESSION['user']['nisn'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $nisn = $_SESSION['user']['nisn'];


        
        $siswaModel = $this->model('SiswaModel');
        $absensimodel = $this->model('AbsensiModel');
        $jadwalmodel = $this->model('JadwalModel');
        $siswa = $siswaModel->getSiswaById($nisn);
        $absensi = $absensimodel->getAbsensiByIdSiswa($nisn);
        $jadwal = $jadwalmodel->getJadwalByNisn($nisn);

        
        return parent::view('home/index', [
            'siswa' => $siswa,
            'kelas'=>$siswa,
            'absensi' => $absensi,
            'jadwal'=> $jadwal
        ]);
    }

}
