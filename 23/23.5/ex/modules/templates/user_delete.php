<?php require \Helpers\get_fragment_path('__header') ?>
<h2>Удаление пользователя</h2>
<form method="post">
    <input type="hidden" name="__token"
    value="<?php echo $__token ?>">
    <input type="submit" value="Удалить">
</form>
<?php require \Helpers\get_fragment_path('__footer') ?>
