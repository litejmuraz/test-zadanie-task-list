<? if (!defined("APP")) die("Доступ запрещен!") ?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="view/static/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">

    <title><?=htmlspecialchars($title)?></title>
</head>
<body>

<? if (!isset($is_header)) $is_header = true;
if ($is_header) { ?>
    <nav class="navbar navbar-dark bg-dark">
        &nbsp;
    </nav>
<? } ?>

<? if (!isset($is_fluid)) $is_fluid = true; ?>
<div class="container<?=$is_fluid ? '-fluid' : ''?> pt-5">
    <h4><?=htmlspecialchars($title)?></h4>

    <? $bootstrap_msg_types = [
        'E' => 'alert-danger',
        'W' => 'alert-warning',
        'S' => 'alert-success',
        'N' => 'alert-info'
    ];
    foreach(View::getMessages() as $message_item) { ?>
        <div class="alert alert-dismissible <?=$bootstrap_msg_types[$message_item['type']]?> fade show" role="alert">
            <?=htmlspecialchars($message_item['text'])?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <? } ?>

    <? View::out($view['file'], $view['variables']); ?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>-->
<script src="view/static/bootstrap/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
