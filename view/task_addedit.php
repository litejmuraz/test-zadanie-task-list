<? if (!defined("APP")) die("Доступ запрещен!") ?>

<form method="post">
    <div class="form-group">
        <label for="userName">Имя пользователя</label>
        <input type="text" class="form-control" id="userName" <?if (!$enable_user_data) echo 'disabled'?> name="user_name" value="<?=htmlspecialchars($user_name)?>">
    </div>

    <div class="form-group">
        <label for="userEmail">E-mail пользователя</label>
        <input type="email" class="form-control" id="userEmail" <?if (!$enable_user_data) echo 'disabled'?> name="user_email" value="<?=htmlspecialchars($user_email)?>">
    </div>

    <div class="form-group">
        <label for="text">Текст задачи</label>
        <textarea class="form-control" id="text" rows="8" name="text"><?=htmlspecialchars($text)?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a href="index.php" class="btn btn-secondary">Отменить</a>
</form>
