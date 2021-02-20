<?php require \Helpers\get_fragment_path('__header') ?>
<h2><?php echo $cat['name'] ?></h2>
<table id="gallery">
    <tr><th></th><th></th><th>Опубликовано пользователем</th>
    <th>Дата и время публикации</th><th>Комментариев</th></tr>
    <?php foreach ($picts as $pict) { ?>
    <tr>
        <td><a href="/<?php echo $pict['id'] ?>/?ref=cat">
            <img src="<?php echo \Settings\IMAGE_PATH . $pict['filename'] ?>">
        </a></td>
        <td><a href="/<?php echo $pict['id'] ?>/?ref=cat">
            <h3><?php echo $pict['title'] ?></h3>
        </a></td>
        <td><h4><a href="/users/<?php echo $pict['user_name'] ?>">
            <?php echo $pict['user_name'] ?>
        </a></h4></td>
        <td><?php echo $pict['uploaded'] ?></td>
        <td><?php echo $pict['comment_count'] ?></td>
    </tr>
    <?php } ?>
</table>
<?php require \Helpers\get_fragment_path('__footer') ?>
