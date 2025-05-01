<?php
// manggil file site.php
require_once 'config/site.php';

// manggil autoload semua class dari folder core
spl_autoload_register(function($files){
    require_once    'core/' . $files . '.php';
    require_once __DIR__ . '/../vendor/autoload.php';

});
