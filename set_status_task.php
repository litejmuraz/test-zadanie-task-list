<?php
require_once 'model/model.php';

if (!Account::isLogin()) {
    redirect('login.php');
}

$item = Task::getById(isset($_GET['id']) ? $_GET['id'] : 0);

if ($item) {
    if (in_array($_GET['status'], ['process', 'complete'])) {
        Task::edit($item['id'], [
            'status' => $_GET['status']
        ]);
        View::addSuccess('Статус задачи успешно изменен');
        redirect('index.php');
    }
} else {
    View::addError('Не удалось изменить статус задачи');
}

redirect('index.php');
