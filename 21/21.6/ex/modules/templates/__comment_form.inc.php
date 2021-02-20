<form class="bigform" method="post">
    <label for="comment_contents">Содержание</label>
    <textarea id="comment_contents" name="contents"><?php echo $form['contents'] ?></textarea>
    <?php \Helpers\show_errors('contents', $form) ?>
    <input type="submit" value="Отправить">
</form>
