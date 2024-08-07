<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();
$f3->config("./app/configs/config.ini");

try {
    $db = new \DB\SQL('mysql:host=localhost;dbname=formularpraxe','root', '');
    $f3->set('DB', $db);
   // var_dump($db);
   // die;
} catch (\PDOException $e) {
    if ($e->getCode() == 1049) {
        echo ("Bez databáze! Nainstalujte ji pomocí /install");
    }
    throw $e;
}
$f3->run();
