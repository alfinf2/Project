<?php

class User extends BaseController {
    public function index() {
        
        $users = $this->model('UserModel')->getAll();
        return parent::view('admin/index', ['useradmin' => $users]);
    }

    public function create() {
        $this->view('user/create');
    }

    public function store() {
        $simpan = $this->model('UserModel')->storeUser($_POST);
        if ($simpan) {
            $this->success('Sukses!', 'Data berhasil ditambahkan.');
        } else {
            $this->error('Gagal!', 'Data gagal ditambahkan.');
        }
        return parent::redirect('user', 'index');
    }

    public function edit($id) {
        $data['user'] = $this->model('UserModel')->find($id);
        $this->view('user/edit', $data);
    }

    public function update($id) {
        $ubahUser = $this->model('UserModel')->updateUser($_POST, $id);
        if ($ubahUser) {
            $this->success('Sukses!', 'Data berhasil diubah.');
        } else {
            $this->error('Gagal!', 'Data gagal diubah.');
        }
        return parent::redirect('user', 'index');
    }

    public function destroy($id) {
        $delete = $this->model('UserModel')->destroy($id);
        if ($delete) {
            $this->success('Sukses!', 'Data berhasil dihapus.');
        } else {
            $this->error('Gagal!', 'Data gagal dihapus.');
        }
        return parent::redirect('user', 'index');
    }
}
