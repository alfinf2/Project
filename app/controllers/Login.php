<?php

class Login extends BaseController
{
    private $sessionTimeout = 7200; 
    private $maxLoginAttempts = 5; 
    private $db;

    public function index()
    {
        
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        parent::view('login/index');
    }

    public function proses()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Akses Ditolak!");
        }

        
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF Attack Detected!");
        }

        if (!isset($_POST['nisn']) || !isset($_POST['password'])) {
            $_SESSION['flash'] = [
                'type' => 'negative',
                'title' => 'Login Gagal',
                'message' => 'Harap isi NISN dan Password'
            ];
            return parent::redirect('login', 'index');
        }

        $nisn = trim($_POST['nisn']);
        $password = $_POST['password'];

        
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        if ($_SESSION['login_attempts'] >= $this->maxLoginAttempts) {
            $_SESSION['flash'] = [
                'type' => 'negative',
                'title' => 'Login Gagal',
                'message' => 'Terlalu banyak percobaan login, coba lagi nanti'
            ];
            return parent::redirect('login', 'index');
        }

        $db = new Database();

        $db->query("SELECT * FROM usersiswa WHERE nisn = :nisn");
        $db->bind(':nisn', $nisn);
        $userSiswa = $db->single();

        $db->query("SELECT * FROM useradmin WHERE username = :username OR nuptk = :nuptk");
        $db->bind(':username', $nisn);
        $db->bind(':nuptk', $nisn);
        $userAdmin = $db->single();

        if ($userSiswa && password_verify($password, $userSiswa['password'])) {
            session_regenerate_id(true); 

            unset($userSiswa['password']);
            $_SESSION['user']['id'] = $userSiswa['id'];
            $_SESSION['user']['nisn'] = $userSiswa['nisn'];
            $_SESSION['user']['id_siswa'] = $userSiswa['id_siswa'];
            $_SESSION['role'] = 'siswa';

            $_SESSION['login_attempts'] = 0;

            return parent::redirect('home', 'index');
        }

        if ($userAdmin && password_verify($password, $userAdmin['password'])) {
            session_regenerate_id(true);

            unset($userAdmin['password']);
            $_SESSION['user'] = $userAdmin;

            $_SESSION['login_attempts'] = 0;

            if ($userAdmin['role'] == 'admin' || $userAdmin['role'] == 'guru') {
                return parent::redirect('absensi', 'index');
            }
        }

        $_SESSION['login_attempts']++; 

        $_SESSION['flash'] = [
            'type' => 'negative',
            'title' => 'Login Gagal',
            'message' => 'NISN atau Password salah'
        ];
        return parent::redirect('login', 'index');
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 42000, '/');

        return parent::redirect('login', 'index');
    }
}
