<?php
require_once 'model/model.php';

if (!empty($_POST)) {
    if (!strlen($_POST['login']) || !strlen($_POST['password'])) {
        View::addError('Введите логин и пароль');
    } elseif (!Account::login($_POST['login'], $_POST['password'])) {
        View::addError('Неверный логин или пароль');
    } else {
        View::addSuccess('Авторизация успешно прошла');
        redirect('index.php');
    }
}


View::out('layout.php', [
    'title' => 'Авторизация',
    'is_header' => false,
    'is_fluid' => false,
    'view' => [
        'file' => 'login.php',
        'variables' => []
    ]
]);
