<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="/styles.css" rel="stylesheet" type="text/css">
        <title>Фотогалерея</title>
    </head>
    <body>
        <h1>Фотогалерея</h1>
        <section id="gallery">
            <?php
                $cnt = count($arr_images);
                for ($i = 0; $i < $cnt; $i++) {
            ?>
            <a href="/<?php echo $i ?>/">
                <img src="/images/<?php echo $arr_images[$i]['src'] ?>"
                title="<?php echo $arr_images[$i]['desc'] ?>">
            </a>
            <?php } ?>
        </section>
    </body>
</html>