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
            <input type="number" name="inches" size="10"></p>
            <p><input type="submit" value="Преобразовать"></p>
        </form>
        <?php
            if (isset($_POST['inches'])) {
                $ins = $_POST['inches'];
                $cents = round($ins * 2.54);
                echo '<p>', $ins, ' дюймов = ', $cents, ' сантиметров.</p>';
            }
        ?>
    </body>
</html>