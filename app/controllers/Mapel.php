<?php

class Mapel extends BaseController {
   

   

    public function index() {
        
        $data['mapel'] = $this->model('MapelModel')->getAllMapel();
        $this->view('mapel/index', $data);
    }


    public function create(){
        $data['mapel'] = $this->model('MapelModel')->getAll();
        $this->view('mapel/create', $data);
    }

    public function store(){
        $simpan = $this->model('MapelModel')->storeMapel($_POST);
        if ($simpan) {
            $this->success('Sukses!', 'Data berhasil ditambahkan.');
        } else {
            $this->error('Gagal!', 'Data gagal ditambahkan.');
        }
        return parent::redirect('mapel', 'index');
    }


    public function edit($id)
    {
        $data['mapel'] = $this->model('MapelModel')->getMapelById($id);
        $this->view('mapel/edit',$data);
    }

    public function update($id)
    {
        $ubahProduct = $this->model('MapelModel')->updateMapel($_POST, $id);
        if ($ubahProduct) {
            $this->success('Sukses!', 'Data berhasil diubah.');
        } else {
            $this->error('Gagal!', 'Data gagal diubah.');
        }
        return parent::redirect('mapel', 'index');
    }

    public function destroy($id){
        $delete = $this->model('MapelModel')->deleteMapel($id);
        if ($delete) {
            $this->success('Sukses!', 'Data berhasil dihapus.');
        } else {
            $this->error('Gagal!', 'Data gagal dihapus.');
        }   
        return parent::redirect('mapel', 'index');
    }
}