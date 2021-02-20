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
                    $is = (string)$ins;
                    if (strpos($is, '.') !== FALSE || (strlen($is) > 1 && $is[-2] == '1'))
                        $ins_ending = 'ов';
                    else {
                        $is = $is[-1];
                        if ($is == 1)
                            $ins_ending = '';
                        else if ($is >= 2 && $is <= 4)
                            $ins_ending = 'а';
                        else
                            $ins_ending = 'ов';
                    }
                    $cs = (string)$cents;
                    if (strlen($cs) > 1 && $cs[-2] == '1')
                        $cents_ending = 'ов';
                    else {
                        $cs = $cs[-1];
                        if ($cs == 1)
                            $cents_ending = '';
                        else if ($cs >= 2 && $cs <= 4)
                            $cents_ending = 'а';
                        else
                            $cents_ending = 'ов';
                    }
                    echo "<p>{$ins} дюйм{$ins_ending} = {$cents} сантиметр{$cents_ending}.</p>";
                } else
                    echo '<p>Величина в дюймах должна быть больше нуля.</p>';
            }
        ?>
    </body>
</html>