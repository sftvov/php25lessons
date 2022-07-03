<?php require_once 'library.php'; ?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Конвертор</title>
    </head>
    <body>
        <h1>Преобразование из дюймов в сантиметры</h1>
        <?php
            $ins = 20;
            $cents = $ins * 2.54;
            $cents = round($cents);
            $ins_ending = case_ending($ins);
            $cents_ending = case_ending($cents);
?>
        <p><?php echo $ins ?> дюйм<?php echo $ins_ending ?> =
        <?php echo $cents ?> сантиметр<?php echo $cents_ending ?>.</p>
    </body>
</html>