<?php require \Helpers\get_fragment_path('__header') ?>
<?php require \Helpers\get_fragment_path('__filter_form') ?>
<?php $gets = \Helpers\get_GET_params(['page', 'filter']) ?>
<h2><?php echo $user['name'] ?></h2>
<?php if ($__current_user &&
    $__current_user['id'] == $user['id']) { ?>
<p><a href="<?php echo '/users/' . $user['name'] .
    '/pictures/add'. $gets ?>">Добавить изображение</a></p>
<?php } ?>
<table id="gallery">
    <tr><th></th><th></th><th>Категория</th>
    <th>Дата и время публикации</th><th>Комментариев</th>
    <th></th><th></th></tr>
    <?php foreach ($picts as $pict) { ?>
    <tr>
        <td><a href="/<?php echo $pict['id'], $gets ?>">
            <img src="<?php echo \Helpers\get_thumbnail($pict['filename']) ?>">
        </a></td>
        <td><a href="/<?php echo $pict['id'], $gets ?>">
            <h3><?php echo $pict['title'] ?></h3>
        </a></td>
        <td><h4><a href="/cats/<?php echo $pict['slug'] ?>">
            <?php echo $pict['cat_name'] ?>
        </a></h4></td>
        <td><?php echo \Helpers\get_formatted_timestamp($pict['uploaded']) ?></td>
        <td><?php echo $pict['comment_count'] ?></td>
        <?php if ($__current_user &&
            ($__current_user['id'] == $pict['user'] ||
            $__current_user['admin'])) { ?>
        <td><a href="<?php echo '/users/', $user['name'], '/pictures/',
            $pict['id'], '/edit', $gets ?>">Исправить</a></td>
        <td><a href="<?php echo '/users/', $user['name'], '/pictures/',
            $pict['id'], '/delete', $gets ?>">Удалить</a></td>
        <?php } else { ?>
            <td></td><td></td>
        <?php } ?>
    </tr>
    <?php } ?>
</table>
<?php require \Helpers\get_fragment_path('__paginator') ?>
<?php require \Helpers\get_fragment_path('__footer') ?>
