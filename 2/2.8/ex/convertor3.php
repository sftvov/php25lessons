<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Конвертор</title>
    </head>
    <body>
        <h1>Преобразование из дюймов в сантиметры</h1>
        <form action="convertor3.php" method="post">
            <p>Величина в дюймах:
            <input type="text" name="inches" size="10"></p>
            <p><input type="submit" value="Преобразовать"></p>
        </form>
        <?php
            if (isset($_POST['inches'])) {
                $ins = (double)$_POST['inches'];
                if ($ins > 0) {
                    $cents = round($ins * 2.54);
                    echo '<p>', $ins, ' дюймов = ', $cents, ' сантиметров.</p>';
                } else
                    echo '<p>Величина в дюймах должна быть больше нуля.</p>';
            }
        ?>
    </body>
</html>