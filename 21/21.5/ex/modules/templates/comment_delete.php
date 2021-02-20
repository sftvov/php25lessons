<?php require \Helpers\get_fragment_path('__header') ?>
<?php $ret = '/' . $picture .
    \Helpers\get_GET_params(['page', 'filter', 'ref']) ?>
<h2>Правка комментария</h2>
<p>Оставлен пользователем: <?php echo $comment['user_name'] ?></p>
<p><?php echo $comment['contents'] ?></p>
<p>Опубликован:
<?php echo \Helpers\get_formatted_timestamp($comment['uploaded']) ?></p>
<form method="post">
    <input type="submit" value="Удалить">
</form>
<p><a href="<?php echo $ret ?>">Назад</a></p>
<?php require \Helpers\get_fragment_path('__footer') ?>
