<?php

class Password extends BaseController
{
    public function index()
    {

        $this->view('password/index');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $guru_id = $_SESSION['user']['guru_id'];
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            
            if ($new_password !== $confirm_password) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Password baru dan konfirmasi tidak cocok!'
                ];
                header('Location: ' . BASE_URL . '/password/index');
                exit;
            }

            $guruModel = $this->model('GuruModel');
            $result = $guruModel->changePassword($guru_id, $old_password, $new_password);

            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }

    public function updateSiswa()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nisn = $_SESSION['user']['nisn'];
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            
            if ($new_password !== $confirm_password) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Password baru dan konfirmasi tidak cocok!'
                ];
                header('Location: ' . BASE_URL . '/siswa/index');
                exit;
            }

            if (strlen($new_password) < 6) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Password minimal 6 karakter!'
                ];
                header('Location: ' . BASE_URL . '/siswa/index');
                exit;
            }

            $siswaModel = $this->model('SiswaModel');
            $result = $siswaModel->changePassword($nisn, $old_password, $new_password);

            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }

}