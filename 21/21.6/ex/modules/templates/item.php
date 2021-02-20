<?php require \Helpers\get_fragment_path('__header') ?>
<h2><?php echo $pict['title'] ?></h2>
<?php
    switch ($_GET['ref'] ?? '') {
        case 'index':
            $ref = '/';
            break;
        case 'cat':
            $ref = '/cats/' . $pict['slug'] . '/';
            $ref .= \Helpers\get_GET_params(['page', 'filter']);
            break;
        default:
            $ref = '/users/' . $pict['user_name'] . '/';
            $ref .= \Helpers\get_GET_params(['page', 'filter']);
    }
?>
<p><a href="<?php echo $ref ?>">Назад</a></p>
<section id="gallery-item">
    <img src="<?php echo \Settings\IMAGE_PATH . $pict['filename'] ?>">
</section>
<p><?php echo $pict['description'] ?></p>
<H4>Категория: <a href="/cats/<?php echo $pict['slug'] ?>/">
<?php echo $pict['cat_name'] ?></a></h4>
<h4>Опубликовано пользователем:
<a href="/users/<?php echo $pict['user_name'] ?>/">
<?php echo $pict['user_name'] ?></a></h4>
<p>Дата и время публикации:
<?php echo \Helpers\get_formatted_timestamp($pict['uploaded']) ?></p>
<?php if ($__current_user) { ?>
<h3>Добавить комментарий</h3>
<?php require \Helpers\get_fragment_path('__comment_form') ?>
<?php } ?>
<?php $u2 = \Helpers\get_GET_params(['page', 'filter', 'ref']) ?>
<h3>Комментарии</h3>
<?php foreach ($comments as $comment) { ?>
    <h5><?php echo $comment['user_name'] ?></h5>
    <p><?php echo $comment['contents'] ?></p>
    <p>Опубликован:
    <?php echo \Helpers\get_formatted_timestamp($comment['uploaded']) ?></p>
    <?php if ($__current_user &&
        ($__current_user['id'] == $comment['user_id'] ||
        $__current_user['admin'])) { ?>
    <?php $u1 = '/' . $pict['id'] . '/comments/' . $comment['id'] ?>
    <p><a href="<?php echo $u1 . '/edit' . $u2 ?>">Исправить</a>
    <a href="<?php echo $u1 . '/delete' . $u2 ?>">Удалить</a></p>
    <?php } ?>
    <p>&nbsp;</p>
<?php } ?>
<p><a href="<?php echo $ref ?>">Назад</a></p>
<?php require \Helpers\get_fragment_path('__footer') ?>
