<?php require \Helpers\get_fragment_path('__header') ?>
<h2>Добавление изображения</h2>
<?php require \Helpers\get_fragment_path('__picture_form') ?>
<?php $ret = '/users/' . $username .
    \Helpers\get_GET_params(['page', 'filter']) ?>
<p><a href="<?php echo $ret ?>">Назад</a></p>
<?php require \Helpers\get_fragment_path('__footer') ?>
