<?php 

class BaseController {
    public static function view($view, $data = []) {
        if ($view === 'login/index') {
            include "../app/views/{$view}.php"; 
        }elseif ($view === 'admin/index') {
            include "../app/views/layout/adminheader.php"; 
            include "../app/views/{$view}.php"; 
        }elseif ($view === 'absensi/index' || $view === 'absensi/edit' || $view === 'absensi/create' || $view === 'absensi/detail' || 
        $view === 'absensi/absen' || $view === 'admin/index' || $view === 'admin/create' || $view === 'admin/edit' || $view === 'admin/siswa' ||
        $view === 'admin/data' || $view === 'siswa/create' || $view === 'siswa/edit' || $view === 'password/index' || $view === 'jadwal/index' ||
        $view === 'jadwal/create' || $view === 'jadwal/edit' || $view === 'mapel/edit' || $view === 'mapel/index' || $view === 'mapel/create') {
            include "../app/views/layout/adminheader.php"; 
            include "../app/views/{$view}.php"; 
        }else {
            include "../app/views/layout/header.php"; 
            include "../app/views/{$view}.php";       
            include "../app/views/layout/footer.php";
        }
    }
    
    public static function redirect($controller, $method, $data = []){
        header('location: ' . BASE_URL . '/' . $controller . '/' . $method);
        exit;
    }

    public function model($model){
        require_once "../app/models/{$model}.php";
        return new $model;
    }
    public function success($title, $message = ''){
        return $_SESSION['flash'] = [
                    'type' => 'positive',
                    'title' => $title,
                    'message' => $message
        ];
    }
    public function error($title, $message = ''){
        return $_SESSION['flash'] = [
                    'type' => 'negative',
                    'title' => $title,
                    'message' => $message
        ];
    }
}