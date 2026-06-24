<?php
require_once '../app.php';

use App\Controllers\HomeController;

$controller = new HomeController();
$controller->user_tweets();
