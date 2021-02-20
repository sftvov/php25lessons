<form class="bigform" method="post" enctype="multipart/form-data">
    <label for="picture_category">Категория</label>
    <select id="picture_category" name="category">
        <?php foreach ($categories as $category) { ?>
            <option value="<?php echo $category['id'] ?>"
            <?php if ($form['category'] == $category['id']) { ?>selected<?php } ?>>
                <?php echo $category['name'] ?>
            </option>
        <?php } ?>
    </select>
    <label for="picture_title">Название</label>
    <input type="text" id="picture_title" name="title"
    value="<?php echo $form['title'] ?>">
    <?php \Helpers\show_errors('title', $form) ?>
    <label for="picture_description">Описание</label>
    <textarea id="picture_description" name="description"><?php echo $form['description'] ?></textarea>
    <label for="picture_file">Файл с изображением</label>
    <input type="file" id="picture_file" name="picture">
    <?php \Helpers\show_errors('picture', $form) ?>
    <input type="submit" value="Отправить">
</form>
