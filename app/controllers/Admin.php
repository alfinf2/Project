<?php

class Admin extends BaseController
{
    public function index()
    {
       
        $mapel = $this->model('GuruModel')->getAllData();
        return parent::view('admin/index', ['guru' => $mapel]);
    }

    public function create()
    {
        $mapelModel = $this->model('MapelModel');
        $data['mapel'] = $mapelModel->getAll();
        $this->view('admin/create', $data);
    }
    public function store()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $simpan = $this->model('GuruModel')->storeGuru($_POST);

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => $simpan,
                    'message' => $simpan ? 'Data berhasil ditambahkan' : 'Gagal menambahkan data'
                ]);
                exit;
            }

            $simpan = $this->model('GuruModel')->storeGuru($_POST);
            if ($simpan) {
                $this->success('Sukses!', 'Data berhasil ditambahkan.');
            } else {
                $this->error('Gagal!', 'Data gagal ditambahkan.');
            }
            return parent::redirect('admin', 'index');
        }
    }


    public function update($id)
    {
        $ubahProduct = $this->model('GuruModel')->updateGuru($_POST, $id);
        if ($ubahProduct) {
            $this->success('Sukses!', 'Data berhasil diubah.');
        } else {
            $this->error('Gagal!', 'Data gagal diubah.');
        }
        return parent::redirect('admin', 'index');
    }

    public function siswa()
    {
        $siswamodel = $this->model('SiswaModel');
        $data['siswa'] = $siswamodel->getAllSiswa();
        $kelasModel = $this->model('KelasModel');
        $data['kelas'] = $kelasModel->getAll();
        return parent::view('admin/siswa', $data);
    }
    public function data($id = null)
    {
        $siswaModel = $this->model('SiswaModel');
        $data['siswa'] = $siswaModel->getAllSiswa($id);
        $this->view('admin/data', $data);
    }

    public function upload()
    {
        if (!isset($_FILES['profile_image'])) {
            return false;
        }

        $file = $_FILES['profile_image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes) || $file['size'] > $maxSize) {
            echo "<script>alert('File harus berupa gambar (JPG/PNG) dan maksimal 5MB!');</script>";
            return false;
        }

        $fileName = time() . '_' . $_SESSION['user']['id'] . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $uploadPath = 'img/uploads/' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
           
            $this->model('UserModel')->updateUserImage($_SESSION['user']['id'], $fileName);
            $_SESSION['user']['image'] = $fileName;

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function getSiswaByKelas($id_kelas)
    {
        $siswaModel = $this->model('SiswaModel');
        $siswa = $siswaModel->getSiswaByKelas($id_kelas);

        header('Content-Type: application/json');
        echo json_encode($siswa);
        exit;
    }

    public function edit($id)
    {
        
        $data['guru'] = $this->model('GuruModel')->find($id);
        $data['mapel'] = $this->model('MapelModel')->getAll($id);
        $this->view('admin/edit', $data);
    }

    public function destroy($id)
    {
        $delete = $this->model('GuruModel')->deleteGuru($id);
        if ($delete) {
            $this->success('Sukses!', 'Data berhasil dihapus.');
        } else {
            $this->error('Gagal!', 'Data gagal dihapus.');
        }
        return parent::redirect('admin', 'index');
    }
}