<?php

use App\Models\AuthUser;

$auth_user = AuthUser::get();
?>

<nav id="side-menu" class="flex gap-1 p-4 h-full">
    <a href="" class="gap-3 px-3 py-3">
        <h1 class="text-xl font-bold"><?= SITE_TITLE ?></h1>
    </a>

    <a href="register/" class="gap-3 px-3 py-3 rounded-xl hover:bg-sky-50 text-slate-800 font-semibold transition">
        <span>Register</span>
    </a>

    <a href="login/" class="gap-3 px-3 py-3 rounded-xl hover:bg-sky-50 text-slate-800 font-semibold transition">
        <span>Signin</span>
    </a>

    <a href="about/" class="gap-3 px-3 py-3 rounded-xl hover:bg-sky-50 text-slate-800 font-semibold transition">
        <span>About</span>
    </a>

</nav>