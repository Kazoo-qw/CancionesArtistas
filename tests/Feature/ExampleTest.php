<?php

test('la portada muestra la bienvenida y el panel pide iniciar sesión', function () {
    // "/" es solo para invitados: enseña welcome.
    $this->get('/')->assertOk();

    // El panel exige sesión iniciada.
    $this->get('/home')->assertRedirect(route('login'));
});

test('las páginas de autenticación cargan sin error', function () {
    // Si un layout referencia un asset o un @vite que no existe, estas rutas truenan.
    $this->get(route('login'))->assertOk();
    $this->get(route('register'))->assertOk();
    $this->get(route('password.request'))->assertOk();
});
