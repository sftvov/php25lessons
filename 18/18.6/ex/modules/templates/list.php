<?php require \Helpers\get_fragment_path('__header') ?>
<h2>Категории</h2>
<section id="categories">
    <?php foreach ($cats as $cat) { ?>
    <h3><a href="/cats/<?php echo $cat['slug'] ?>/">
        <?php echo $cat['name'] ?>
    </a></h3>
    <?php } ?>
</section>
<h2>Последние 3 изображения</h2>
<table id="gallery">
    <tr><th></th><th></th><th>Категория</th>
    <th>Опубликовано пользователем</th>
    <th>Дата и время публикации</th><th>Комментариев</th></tr>
    <?php foreach ($picts as $pict) { ?>
    <tr>
        <td><a href="/<?php echo $pict['id'] ?>/?ref=index">
            <img src="<?php echo \Settings\IMAGE_PATH . $pict['filename'] ?>">
        </a></td>
        <td><a href="/<?php echo $pict['id'] ?>/?ref=index">
            <h3><?php echo $pict['title'] ?></h3>
        </a></td>
        <td><h4><a href="/cats/<?php echo $pict['slug'] ?>">
            <?php echo $pict['cat_name'] ?>
        </a></h4></td>
        <td><h4><a href="/users/<?php echo $pict['user_name'] ?>">
            <?php echo $pict['user_name'] ?>
        </a></h4></td>
        <td><?php echo \Helpers\get_formatted_timestamp($pict['uploaded']) ?></td>
        <td><?php echo $pict['comment_count'] ?></td>
    </tr>
    <?php } ?>
</table>
<?php require \Helpers\get_fragment_path('__footer') ?>
