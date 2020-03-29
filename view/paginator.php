<? if (!defined("APP")) die("Доступ запрещен!") ?>

<? if (isset($paginator) && count($paginator['pages']) > 1) { ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <? if ($paginator['first']['active']) { ?>
                <li class="page-item"><a class="page-link" href="<?=htmlspecialchars($paginator['first']['href'])?>">&laquo;&laquo;&laquo;</a></li>
            <? } else { ?>
                <li class="page-item disabled"><span class="page-link">&laquo;&laquo;&laquo;</span></li>
            <? } ?>
            <? if ($paginator['prev']['active']) { ?>
                <li class="page-item"><a class="page-link" href="<?=htmlspecialchars($paginator['prev']['href'])?>">&laquo;</a></li>
            <? } else { ?>
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            <? } ?>

            <? foreach ($paginator['pages'] as $PageItem) {
                if ($PageItem['active']) { ?>
                    <li class="page-item"><a class="page-link" href="<?=htmlspecialchars($PageItem['href'])?>"><?=htmlspecialchars($PageItem['page'])?></a></li>
                <? } else { ?>
                    <li class="page-item disabled"><span class="page-link"><?=htmlspecialchars($PageItem['page'])?></span></li>
                <? }
            } ?>

            <? if ($paginator['next']['active']) { ?>
                <li class="page-item"><a class="page-link" href="<?=htmlspecialchars($paginator['next']['href'])?>">&raquo;</a></li>
            <? } else { ?>
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            <? } ?>
            <? if ($paginator['last']['active']) { ?>
                <li class="page-item"><a class="page-link" href="<?=htmlspecialchars($paginator['last']['href'])?>">&raquo;&raquo;&raquo;</a></li>
            <? } else { ?>
                <li class="page-item disabled"><span class="page-link">&raquo;&raquo;&raquo;</span></li>
            <? } ?>
        </ul>
    </nav>
<? } ?>
