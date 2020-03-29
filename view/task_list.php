<? if (!defined("APP")) die("Доступ запрещен!") ?>

<div class="row">
    <div class="col-12">
        <form method="get">
            <input type="hidden" name="page" value="<?=htmlspecialchars($page)?>">

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="sortField">Сортировать по:</label>
                        <select class="form-control form-control-sm" id="sortField" name="order_field" onchange="this.form.submit()">
                            <option value="user_name" <?if ($order_field == 'user_name') echo'selected'?>>Имени пользователя</option>
                            <option value="user_email" <?if ($order_field == 'user_email') echo'selected'?>>E-mail</option>
                            <option value="status" <?if ($order_field == 'status') echo'selected'?>>Статусу</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="sortDirect">Направление сортировки:</label>
                        <select class="form-control form-control-sm" id="sortDirect" name="order_direct" onchange="this.form.submit()">
                            <option value="asc" <?if ($order_direct == 'asc') echo'selected'?>>По возрастанию</option>
                            <option value="desc" <?if ($order_direct == 'desc') echo'selected'?>>По убыванию</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <? if ($is_admin) { ?>
                        <a href="logout.php" class="btn float-right mr-2 btn-primary">Выйти</a>
                    <? } else { ?>
                        <a href="login.php" class="btn float-right mr-2 btn-primary">Авторизация</a>
                    <? } ?>

                    <a href="add_task.php" class="btn float-right mr-2 btn-success">Добавить новую задачу</a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-12">
        <? foreach($tasks_list as $task_item) { ?>
            <div class="card mt-3 mb-3">
                <div class="card-header">
                    <?=htmlspecialchars($task_item['user_name'])?>
                    <small class="pl-2 text-muted"><?=htmlspecialchars($task_item['user_email'])?></small>

                    <? if ($task_item['status'] == 'complete') { ?>
                        <strong class="float-right text-success">Выполнено</strong>
                    <? } else { ?>
                        <strong class="float-right text-danger">Ожидает выполнения</strong>
                    <? } ?>
                </div>
                <div class="card-body">
                    <p class="card-text"><?=htmlspecialchars($task_item['text'])?></p>

                    <? if ($is_admin) { ?>
                        <a href="delete_task.php?id=<?=$task_item['id']?>" onclick="return confirm('Удалить задачу?')" class="btn btn-sm float-right mr-2 btn-danger">Удалить</a>
                        <a href="edit_task.php?id=<?=$task_item['id']?>" class="btn btn-sm float-right mr-2 btn-warning">Редактировать</a>

                        <? if ($task_item['status'] == 'complete') { ?>
                            <a href="set_status_task.php?id=<?=$task_item['id']?>&status=process" class="btn btn-sm float-right mr-2 btn-primary">Изменить статус на Ожидает выполнения</a>
                        <? } else { ?>
                            <a href="set_status_task.php?id=<?=$task_item['id']?>&status=complete" class="btn btn-sm float-right mr-2 btn-primary">Изменить статус на Выполнено</a>
                        <? } ?>
                    <? } ?>
                    <? if ($task_item['admin_edited']) { ?>
                        <small class="float-right text-muted mr-3">Отредактировано администратором</small>
                    <? } ?>
                </div>
            </div>
        <? } ?>
    </div>

    <div class="col-12">
        <? View::out('paginator.php', [
            'paginator' => $paginator
        ]); ?>
    </div>
</div>
