<?php
require_once '../app.php';

use App\Controllers\LoginController;

$controller = new LoginController();
$controller->index();
