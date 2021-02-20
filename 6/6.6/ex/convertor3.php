<?php
function case_ending(string $is): string {
    if (strpos($is, '.') !== FALSE ||
        (strlen($is) > 1 && $is[-2] == '1'))
        return 'ов';
    else {
        $is = $is[-1];
        if ($is == 1)
            return '';
        else if ($is >= 2 && $is <= 4)
            return 'а';
        else
            return 'ов';
    }
}
?>
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
                    $ins_ending = case_ending($ins);
                    $cents_ending = case_ending($cents);
                    echo "<p>{$ins} дюйм{$ins_ending} = {$cents} сантиметр{$cents_ending}.</p>";
                } else
                    echo '<p>Величина в дюймах должна быть больше нуля.</p>';
            }
        ?>
    </body>
</html>