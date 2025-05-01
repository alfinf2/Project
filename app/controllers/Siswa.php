<?php

class Siswa extends BaseController
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
        $siswa = $siswaModel->getSiswaById($nisn);
        $absensi = $absensimodel->getAbsensiByNisn($nisn);

        return parent::view('siswa/index', [
            'siswa' => $siswa,
            'kelas' => $siswa,
            'absensi' => $absensi
        ]);
    }

    public function detail()
    {
        if (!isset($_SESSION['user']['nisn'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }



        $id = $_SESSION['user']['nisn'];


        $siswaModel = $this->model('SiswaModel');
        $mapelmdoel = $this->model('MapelModel');
        $siswa = $siswaModel->getDataByNisn($id);

        return parent::view('siswa/detail', [
            'siswa' => $siswa,
            'kelas' => $siswa,
            'mapel' => $siswa
        ]);
    }

    public function create()
    {
        $kelasmodel = $this->model('KelasModel');
        $data['kelas'] = $kelasmodel->getAll();
        $this->view('siswa/create', $data);
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return parent::redirect('admin', 'siswa');
            }

            $required = ['inp_nis', 'inp_nama', 'inp_kelas'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception('Semua field harus diisi');
                }
            }

            $result = $this->model('SiswaModel')->storeSiswa($_POST);

            if (
                isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
            ) {

                header('Content-Type: application/json');

                if ($result['status']) {
                    echo json_encode([
                        'status' => true,
                        'message' => 'Data siswa berhasil ditambahkan',
                        'redirect' => BASE_URL . '/admin/siswa'
                    ]);
                } else {
                    $error_message = match ($result['error']) {
                        'duplicate_nisn' => 'NISN sudah terdaftar! Silakan gunakan NISN lain.',
                        'validation_error' => 'Data tidak lengkap atau tidak valid.',
                        default => 'Gagal menyimpan data siswa'
                    };

                    echo json_encode([
                        'status' => false,
                        'error' => $result['error'] ?? 'unknown_error',
                        'message' => $error_message
                    ]);
                }
                exit;
            }

            if ($result['status']) {
                $this->success('Sukses!', 'Data siswa berhasil ditambahkan');
            } else {
                $error_message = match ($result['error']) {
                    'duplicate_nisn' => 'NISN sudah terdaftar! Silakan gunakan NISN lain.',
                    'validation_error' => 'Data tidak lengkap atau tidak valid.',
                    default => 'Gagal menyimpan data siswa'
                };
                $this->error('Gagal!', $error_message);
            }

            return parent::redirect('admin', 'siswa');

        } catch (Exception $e) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => false,
                    'error' => 'server_error',
                    'message' => $e->getMessage()
                ]);
                exit;
            }

            $this->error('Error!', $e->getMessage());
            return parent::redirect('admin', 'siswa');
        }
    }

    public function destroy($id)
    {
        $delete = $this->model('SiswaModel')->destroy($id);
        if ($delete) {
            $this->success('Sukses!', 'Data berhasil dihapus.');
        } else {
            $this->error('Gagal!', 'Data gagal dihapus.');
        }
        return parent::redirect('Admin', 'siswa');
    }

    public function edit($id)
    {
        
        $data['siswa'] = $this->model('SiswaModel')->find($id);
        $data['kelas'] = $this->model('KelasModel')->getAll($id);
        $this->view('siswa/edit', $data);
      
    }

    public function update($id)
    {
        $ubahProduct = $this->model('SiswaModel')->updateSiswa($_POST, $id);
        if ($ubahProduct) {
            $this->success('Sukses!', 'Data berhasil diubah.');
        } else {
            $this->error('Gagal!', 'Data gagal diubah.');
        }
        return parent::redirect('Admin', 'siswa');
    }

    public function profile()
    {
        if (!isset($_SESSION['user']['nisn'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $id = $_SESSION['user']['nisn'];
        $data = $this->model('SiswaModel')->getSiswaById($id);
        $this->view('siswa/profile', [
            'siswa' => $data,
            'kelas' => $data

        ]);
    }


    public function uploadImage()
    {
        header('Content-Type: application/json');

        if (!isset($_FILES['profile_image'])) {
            echo json_encode(['status' => false, 'message' => 'No file uploaded']);
            exit;
        }

        $file = $_FILES['profile_image'];
        
        $basePath = dirname(dirname(__DIR__));
        $uploadDir = $basePath . '/public/img/profile/';

        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $_SESSION['user']['nisn'] . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $result = $this->model('SiswaModel')->updateProfileImage($_SESSION['user']['nisn'], $filename);

            if ($result['status']) {
                echo json_encode([
                    'status' => true,
                    'filename' => $filename,
                    'message' => 'Foto profil berhasil diupdate'
                ]);
            } else {
                unlink($uploadPath);
                echo json_encode(['status' => false, 'message' => 'Gagal update database']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal upload file']);
        }
        exit;
    }

    public function deleteImage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nisn = $_SESSION['user']['nisn'];
            $result = $this->model('SiswaModel')->deleteFoto($nisn);

            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }



}
