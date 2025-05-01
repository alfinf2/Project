<?php

class Jadwal extends BaseController {
   

   

    public function index() {
        $data['jadwal'] = $this->model('JadwalModel')->getDataJadwal();
        $this->view('jadwal/index', $data);
    }


    public function create(){
        $data['guru'] = $this->model('GuruModel')->getAll();
        $data['mapel'] = $this->model('MapelModel')->getAll();
        $data['kelas'] = $this->model('KelasModel')->getAll();
        $this->view('jadwal/create', $data);
    }

    public function store(){
        $simpan = $this->model('JadwalModel')->storeJadwal($_POST);
        if ($simpan) {
            $this->success('Sukses!', 'Data berhasil ditambahkan.');
        } else {
            $this->error('Gagal!', 'Data gagal ditambahkan.');
        }
        return parent::redirect('jadwal', 'index');
    }


    public function edit($id)
    {
        $data['jadwal'] = $this->model('JadwalModel')->find($id);
        $data['guru'] = $this->model('GuruModel')->getAll($id);
        $data['mapel'] = $this->model('MapelModel')->getAll($id);
        $data['kelas'] = $this->model('KelasModel')->getAll($id);
        $this->view('jadwal/edit',$data);
    }

    public function update($id)
    {
        $ubahProduct = $this->model('JadwalModel')->updateJadwal($_POST, $id);
        if ($ubahProduct) {
            $this->success('Sukses!', 'Data berhasil diubah.');
        } else {
            $this->error('Gagal!', 'Data gagal diubah.');
        }
        return parent::redirect('jadwal', 'index');
    }

    public function destroy($id){
        $delete = $this->model('JadwalModel')->destroy($id);
        if ($delete) {
            $this->success('Sukses!', 'Data berhasil dihapus.');
        } else {
            $this->error('Gagal!', 'Data gagal dihapus.');
        }   
        return parent::redirect('jadwal', 'index');
    }
}