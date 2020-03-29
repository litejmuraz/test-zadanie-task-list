<?php
require_once 'model/model.php';

if (!Account::isLogin()) {
    redirect('login.php');
}

$item = Task::getById(isset($_GET['id']) ? $_GET['id'] : 0);

if ($item) {
    Task::delete($item['id']);
    View::addSuccess('Задача успешно удалена');
} else {
    View::addError('Не удалось удалить задачу');
}

redirect('index.php');
