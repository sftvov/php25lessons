<?php require \Helpers\get_fragment_path('__header') ?>
<?php $ref = '/users/' . $username .
    \Helpers\get_GET_params(['page', 'filter']) ?>
<h2>Удаление изображения</h2>
<p><?php echo $picture['title'] ?></p>
<p>Опубликовано пользователем: <?php echo $username ?></p>
<p>Дата и время публикации:
<?php echo \Helpers\get_formatted_timestamp($picture['uploaded']) ?></p>
<form method="post">
    <input type="submit" value="Удалить">
</form>
<p><a href="<?php echo $ref ?>">Назад</a></p>
<?php require \Helpers\get_fragment_path('__footer') ?>
