<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="/styles.css" rel="stylesheet" type="text/css">
        <title><?php echo \Settings\SITE_NAME ?></title>
    </head>
    <body>
        <h1><?php echo \Settings\SITE_NAME ?></h1>
        <section id="gallery">
            <?php
                $cnt = \Models\Image::get_count();
                for ($i = 0; $i < $cnt; $i++) {
                    $img = \Models\Image::get_image($i);
            ?>
            <a href="/<?php echo $i ?>/">
                <img src="<?php echo \Settings\IMAGE_PATH . $img['src'] ?>"
                title="<?php echo $img['desc'] ?>">
            </a>
            <?php } ?>
        </section>
    </body>
</html>