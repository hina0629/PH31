<?php
require_once '../app.php';

use App\Controllers\UserController;

$controller = new UserController();
$controller->update();
