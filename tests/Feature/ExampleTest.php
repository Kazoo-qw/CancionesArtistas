<?php

test('la portada redirige al panel y el panel pide iniciar sesión', function () {
    $this->get('/')->assertRedirect(route('home'));

    $this->get('/home')->assertRedirect(route('login'));
});

test('las páginas de autenticación cargan sin error', function () {
    // Si un layout referencia un asset o un @vite que no existe, estas rutas truenan.
    $this->get(route('login'))->assertOk();
    $this->get(route('register'))->assertOk();
    $this->get(route('password.request'))->assertOk();
});
