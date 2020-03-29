<?php
require_once 'model/model.php';

$order_field = isset($_GET['order_field']) ? $_GET['order_field'] : 'user_name';
$order_direct = isset($_GET['order_direct']) ? $_GET['order_direct'] : 'asc';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$count = Task::getCount();
$list = Task::getList($order_field, $order_direct, $page, TASKS_COUNT_IN_PAGE);

$params = $_GET;
$params['page'] = '__PAGE__';

View::out('layout.php', [
    'title' => 'Список задач',
    'view' => [
        'file' => 'task_list.php',
        'variables' => [
            'order_field' => $order_field,
            'order_direct' => $order_direct,
            'is_admin' => Account::isLogin(),
            'page' => $page,

            'tasks_list' => $list,
            'paginator' => View::createPaginate('?'.http_build_query($params), $page, ceil($count / TASKS_COUNT_IN_PAGE), 3),
        ]
    ]
]);
