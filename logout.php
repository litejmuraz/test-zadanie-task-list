<?php
require_once 'model/model.php';

Account::logout();

View::addSuccess('Выход из аккаунта успешно произведен');

redirect('index.php');
