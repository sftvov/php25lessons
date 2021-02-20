<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Конвертор</title>
    </head>
    <body>
        <h1>Преобразование из дюймов в сантиметры</h1>
        <?php
            $aIns = [20, 24, 27, 32, 45];
            $cnt = count($aIns);
            for ($i = 0; $i < $cnt; $i++) {
                $ins = $aIns[$i];
                $cents = $ins * 2.54;
                $cents = round($cents);
        ?>
        <p><?php echo $ins ?> дюймов = <?php echo $cents ?> сантиметров.</p>
        <?php } ?>
    </body>
</html>