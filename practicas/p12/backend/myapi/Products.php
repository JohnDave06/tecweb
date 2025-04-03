<?php
namespace tecweb\myapi;

use tecweb\myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = [];

    public function __construct($user = 'root', $pass = 'contraseña_6', $db = 'marketzone') {
        parent::__construct($user, $pass, $db);
    }

}
?>
