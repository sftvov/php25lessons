<?php require \Helpers\get_fragment_path('__header') ?>
<section id="gallery">
    <?php
        foreach ($list as $i => $img) {
    ?>
    <a href="/<?php echo $i ?>/">
        <img src="<?php echo \Settings\IMAGE_PATH . $img['src'] ?>"
        title="<?php echo $img['desc'] ?>">
    </a>
    <?php } ?>
</section>
<?php require \Helpers\get_fragment_path('__footer') ?>
