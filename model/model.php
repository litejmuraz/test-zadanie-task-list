<?php
define('DATABASE_NAME', 'test_zadanie');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', '');

define('TASKS_COUNT_IN_PAGE', 3);

define('APP', true);

$db = new PDO('mysql:host=localhost;dbname='.DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->query("SET NAMES utf8");

session_start();


function redirect($url) {
    header('location: '.$url);
    exit;
}


class Task {

    public static function getCount() {
        global $db;
        $st = $db->prepare('SELECT COUNT(*) FROM tasks');
        $st->execute();
        return $st->fetchColumn(0);
    }


    public static function getList($order_field, $order_direct, $page, $count_in_page) {
        global $db;

        if (!in_array($order_field, ['user_name', 'user_email', 'status'])) $order_field = 'user_name';
        if (!in_array($order_direct, ['asc', 'desc'])) $order_direct = 'asc';

        $count_in_page = intval($count_in_page);
        if ($count_in_page < 0) $count_in_page = 0;

        $page = intval($page);
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $count_in_page;

        $st = $db->prepare('SELECT * FROM tasks ORDER BY '.$order_field.' '.$order_direct.' LIMIT '.$count_in_page.' OFFSET '.$offset);

        $st->execute();
        return $st->fetchAll();
    }


    public static function getById($id) {
        global $db;
        $id = intval($id);
        if (!$id) return false;
        $st = $db->prepare('SELECT * FROM tasks WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch();
    }


    public static function getFields() {
        return ['user_name', 'user_email', 'text', 'status', 'admin_edited'];
    }


    public static function add($data) {
        global $db;

        if (empty($data)) return false;

        $fields_list = self::getFields();

        foreach($data as $field => $value) {
            if (!in_array($field, $fields_list)) unset($data[$field]);
        }

        $places = [];
        foreach($data as $field => $value) {
            $places[] = '?';
        }

        $db->prepare('INSERT INTO tasks ('.implode(',', array_keys($data)).') VALUES ('.implode(',', $places).')')->execute(array_values($data));
        return $db->lastInsertId();
    }


    public static function edit($id, $data) {
        global $db;

        if (empty($data)) return;

        $fields_list = self::getFields();

        foreach($data as $field => $value) {
            if (!in_array($field, $fields_list)) unset($data[$field]);
        }

        $sets = [];
        foreach($data as $field => $value) {
            $sets[] = $field.' = ?';
        }

        $data[] = $id;

        $db->prepare('UPDATE tasks SET '.implode(', ', $sets).' WHERE id = ?')->execute(array_values($data));
    }


    public static function delete($id) {
        global $db;
        $db->prepare('DELETE FROM tasks WHERE id = ?')->execute([$id]);
    }

}


class View {

    public static function out($view_file, $variables = []) {
        extract($variables);
        include 'view/'.$view_file;
    }


    /*
     * Постраница в виде массива
     * $url_tmpl - шаблон URL
     * $page - номер страницы на которой мы находимся
     * $pages_count - Общее количество страниц
     * $display_pages_count - Количество страниц с каждой стороны
     */
    public static function createPaginate($url_tmpl, $page = 1 , $pages_count = 50, $display_pages_count = 2) {
        $pages_list = [];

        $start_page = ($page - $display_pages_count);
        if($start_page < 1) $start_page = 1;

        $end_page = $page + $display_pages_count;
        if ($end_page > $pages_count) $end_page = $pages_count;

        $pages_list['first'] = array(
            'page' => 1,
            'href' => str_replace('__PAGE__', 1, $url_tmpl),
            'active' => $page != 1
        );
        $pages_list['prev'] = array(
            'page' => $page - 1,
            'href' => str_replace('__PAGE__', $page - 1, $url_tmpl),
            'active' => $page != 1
        );
        $pages_list['next'] = array(
            'page' => $page + 1,
            'href' => str_replace('__PAGE__', $page + 1, $url_tmpl),
            'active' => $page != $pages_count
        );
        $pages_list['last'] = array(
            'page' => $pages_count,
            'href' => str_replace('__PAGE__', $pages_count, $url_tmpl),
            'active' => $page != $pages_count
        );

        $pages_list['pages'] = array();

        for ($i = $start_page; $i <= $end_page; $i++) {
            $pages_list['pages'][$i]['page'] = $i;
            $pages_list['pages'][$i]['href'] = str_replace('__PAGE__', $i, $url_tmpl);
            $pages_list['pages'][$i]['active'] = $i != $page;
        }
        return $pages_list;
    }


    public static function addError($msg_text) {
        self::appendMessages($msg_text, 'E');
    }

    public static function addWarning($msg_text) {
        self::appendMessages($msg_text, 'W');
    }

    public static function addSuccess($msg_text) {
        self::appendMessages($msg_text, 'S');
    }

    public static function addNotice($msg_text) {
        self::appendMessages($msg_text, 'N');
    }


    private static function appendMessages($msg_text, $msg_type) {
        if (!isset($_SESSION['messages'])) $_SESSION['messages'] = [];
        $_SESSION['messages'][] = [
            'text' => $msg_text,
            'type' => $msg_type,
        ];
    }


    public static function getMessages() {
        if (!isset($_SESSION['messages'])) $_SESSION['messages'] = [];
        $messages_list = $_SESSION['messages'];
        $_SESSION['messages'] = [];
        return $messages_list;
    }

}


class Account {

    public static function isLogin() {
        return isset($_SESSION['login']) && $_SESSION['login'] == 1;
    }

    public static function login($login, $password) {
        if ($login == 'admin' && $password == '123') {
            $_SESSION['login'] = 1;
            return true;
        }
        return false;
    }

    public static function logout() {
        unset($_SESSION['login']);
    }
}


class Validate {

    public static function checkEmail($email) {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    public static function validFieldEmail($email, $title, $require) {
        if (strlen($email)) {
            if (!self::checkEmail($email)) {
                return 'В поле '.$title.' введен неверный E-mail';
            }
        } else {
            if ($require) return 'Не заполнено поле ' . $title;
        }
        return true;
    }


    public static function validFieldString($string, $title, $require, $min_len = null, $max_len = null) {
        $l = strlen($string);
        if ($l > 0) {
            if ($min_len !== null && $min_len > $l) {
                return 'В поле ' . $title . ' размер строки должен быть не меньше ' . $min_len . ' символов';
            } else if ($max_len !== null && $max_len < $l) {
                return 'В поле ' . $title . ' размер строки должен быть не больше ' . $max_len . ' символов';
            }
        } else {
            if ($require) return 'Не заполнено поле ' . $title;
        }
        return true;
    }

}
