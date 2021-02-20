<?php require \Helpers\get_fragment_path('__header') ?>
<h2>Правка комментария</h2>
<?php require \Helpers\get_fragment_path('__comment_form') ?>
<?php $ret = '/' . $picture .
    \Helpers\get_GET_params(['page', 'filter', 'ref']) ?>
<p><a href="<?php echo $ret ?>">Назад</a></p>
<?php require \Helpers\get_fragment_path('__footer') ?>
