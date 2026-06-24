<?php
require_once '../app.php';

use App\Controllers\RegisterController;

$controller = new RegisterController();
$controller->index();
