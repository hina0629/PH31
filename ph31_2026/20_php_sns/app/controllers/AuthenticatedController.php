<?php

namespace App\Controllers;

use App\Models\AuthUser;

abstract class AuthenticatedController
{
    protected array $authUser;

    public function __construct()
    {
        $this->authUser = AuthUser::checkLogin();
    }
}
