<?php
require_once 'model/model.php';

if (empty($_POST)) {
    $vars = [
        'user_name' => '',
        'user_email' => '',
        'text' => ''
    ];
} else {
    $errors_list = [];

    $valid = Validate::validFieldString($_POST['user_name'], 'Имя пользователя', true, 2, 100);
    if ($valid !== true) $errors_list[] = $valid;

    $valid = Validate::validFieldEmail($_POST['user_email'], 'E-mail пользователя', true);
    if ($valid !== true) $errors_list[] = $valid;

    $valid = Validate::validFieldString($_POST['text'], 'Текст', false);
    if ($valid !== true) $errors_list[] = $valid;

    if (empty($errors_list)) {
        Task::add([
            'user_name' => $_POST['user_name'],
            'user_email' => $_POST['user_email'],
            'text' => $_POST['text']
        ]);
        View::addSuccess('Задача успешно создана');
        redirect('index.php');
    } else {
        foreach ($errors_list as $error) {
            View::addError($error);
        }
    }

    $vars = $_POST;
}

$vars['enable_user_data'] = true;

View::out('layout.php', [
    'title' => 'Добавление новой задачи',
    'view' => [
        'file' => 'task_addedit.php',
        'variables' => $vars
    ]
]);
