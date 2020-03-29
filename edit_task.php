<?php
require_once 'model/model.php';

if (!Account::isLogin()) {
    redirect('login.php');
}

$item = Task::getById(isset($_GET['id']) ? $_GET['id'] : 0);

if (!$item) {
    View::addError('Задача не найдена');
    redirect('index.php');
}

if (empty($_POST)) {
    $vars = $item;
} else {
    $errors_list = [];

    $valid = Validate::validFieldString($_POST['text'], 'Текст', false);
    if ($valid !== true) $errors_list[] = $valid;

    if (empty($errors_list)) {
        Task::edit($item['id'], [
            'text' => $_POST['text'],
            'admin_edited' => 1
        ]);
        View::addSuccess('Задача успешно изменена');
        redirect('index.php');
    } else {
        foreach ($errors_list as $error) {
            View::addError($error);
        }
    }

    $vars = $_POST;
}

$vars['enable_user_data'] = false;

View::out('layout.php', [
    'title' => 'Редактирование задачи',
    'view' => [
        'file' => 'task_addedit.php',
        'variables' => $vars
    ]
]);
