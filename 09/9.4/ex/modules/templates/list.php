<?php require \Helpers\get_fragment_path('__header') ?>
<section id="gallery">
    <?php
        for ($i = 0; $i < $cnt; $i++) {
            $img = \Models\Image::get_image($i);
    ?>
    <a href="/<?php echo $i ?>/">
        <img src="<?php echo \Settings\IMAGE_PATH . $img['src'] ?>"
        title="<?php echo $img['desc'] ?>">
    </a>
    <?php } ?>
</section>
<?php require \Helpers\get_fragment_path('__footer') ?>
