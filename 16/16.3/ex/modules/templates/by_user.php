<?php require \Helpers\get_fragment_path('__header') ?>
<?php require \Helpers\get_fragment_path('__filter_form') ?>
<?php $gets = \Helpers\get_GET_params(['page', 'filter']) ?>
<h2><?php echo $user['name'] ?></h2>
<table id="gallery">
    <tr><th></th><th></th><th>Категория</th>
    <th>Дата и время публикации</th><th>Комментариев</th></tr>
    <?php foreach ($picts as $pict) { ?>
    <tr>
        <td><a href="/<?php echo $pict['id'], $gets ?>">
            <img src="<?php echo \Settings\IMAGE_PATH . $pict['filename'] ?>">
        </a></td>
        <td><a href="/<?php echo $pict['id'], $gets ?>">
            <h3><?php echo $pict['title'] ?></h3>
        </a></td>
        <td><h4><a href="/cats/<?php echo $pict['slug'] ?>">
            <?php echo $pict['cat_name'] ?>
        </a></h4></td>
        <td><?php echo $pict['uploaded'] ?></td>
        <td><?php echo $pict['comment_count'] ?></td>
    </tr>
    <?php } ?>
</table>
<?php require \Helpers\get_fragment_path('__paginator') ?>
<?php require \Helpers\get_fragment_path('__footer') ?>
