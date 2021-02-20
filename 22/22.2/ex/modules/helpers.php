<?php
namespace Helpers {
    function render(string $template, array $context) {
        global $base_path;
        extract($context);
        require $base_path . '\modules\templates\\' . $template . '.php';
    }

    function get_fragment_path(string $fragment): string {
        global $base_path;
        return $base_path . '\modules\templates\\' . $fragment . '.inc.php';
    }

    function connect_to_db(){
        $conn_str = 'mysql:host=' . \Settings\DB_HOST . ';dbname=' .
            \Settings\DB_NAME . ';charset=utf8';
        return new \PDO($conn_str, \Settings\DB_USERNAME,
            \Settings\DB_PASSWORD);
    }

    function get_GET_params(array $existing_param_names,
        array $new_params = []): string {
        $a = [];
        foreach ($existing_param_names as $name)
            if (!empty($_GET[$name]))
                $a[] = $name . '=' . urlencode($_GET[$name]);
        foreach ($new_params as $name => $value)
            $a[] = $name . '=' . urlencode($value);
        $s = implode('&', $a);
        if ($s)
            $s = '?' . $s;
        return $s;
    }

    function get_formatted_timestamp(string $timestamp): string {
        return strftime('%d.%m.%Y %H:%M:%S', strtotime($timestamp));
    }

    function redirect(string $url, int $status = 302) {
        header('Location: ' . $url, TRUE, $status);
    }

    function show_errors(string $fld_name, array $form_data) {
        if (isset($form_data['__errors'][$fld_name]))
            echo '<div class="error">' .
                $form_data['__errors'][$fld_name] . '</div>';
    }

    function get_filename(array $file): string {
        global $base_path;
        $image_file_path = $base_path . \Settings\IMAGE_FILE_PATH;
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = strftime('%Y%m%d%H%M');
        $postfix = '';
        $number = 0;
        while (file_exists($image_file_path . $name . $postfix .
            '.' . $ext))
            $postfix = '_' . ++$number;
        return $name . $postfix . '.' . $ext;
    }

    function save_file(array $file): string {
        global $base_path;
        $image_file_path = $base_path . \Settings\IMAGE_FILE_PATH;
        $filename = get_filename($file);
        move_uploaded_file($file['tmp_name'], $image_file_path .
            $filename);
        return $filename;
    }

    function delete_file(string $filename) {
        global $base_path;
        $file_path = $base_path . \Settings\IMAGE_FILE_PATH .
            $filename;
        if (file_exists($file_path))
            unlink($file_path);
    }

    function get_thumbnail(string $filename) {
        global $base_path;
        $thumb_file_name = pathinfo($filename, PATHINFO_FILENAME) .
            '.jpg';
        $thumb_path = $base_path . \Settings\THUMBNAIL_FILE_PATH .
            $thumb_file_name;
        if (!file_exists($thumb_path)) {
            $file_path = $base_path . \Settings\IMAGE_FILE_PATH .
                $filename;
            $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
            switch ($file_ext) {
                case 'gif':
                    $src_img = imagecreatefromgif($file_path);
                    break;
                case 'jpg':
                case 'jpeg':
                case 'jpe':
                    $src_img = imagecreatefromjpeg($file_path);
                    break;
                case 'png':
                    $src_img = imagecreatefrompng($file_path);
            }
            $img = imagescale($src_img, 100);
            $stwhite = imagecolorallocatealpha($img, 255, 255, 255,
                32);
            imagefilledrectangle($img, 0, 0, 100, 10, $stwhite);
            $height = imagesy($img);
            imagefilledrectangle($img, 0, $height - 10, 100, $height,
                $stwhite);
            imagejpeg($img, $thumb_path);
            imagedestroy($img);
            imagedestroy($src_img);
        }
        return \Settings\THUMBNAIL_PATH . $thumb_file_name;
    }

    function delete_thumbnail(string $filename) {
        global $base_path;
        $thumb_path = $base_path . \Settings\THUMBNAIL_FILE_PATH .
            pathinfo($filename, PATHINFO_FILENAME) . '.jpg';
        if (file_exists($thumb_path))
            unlink($thumb_path);
    }

    function render_text(string $template, array $values): string {
        $literals = [];
        $vals = [];
        foreach ($values as $key => $value) {
            $literals[] = '/%' . $key . '%/iu';
            $vals[] = $value;
        }
        return preg_replace($literals, $vals, $template);
    }

    function send_mail(string $to, string $subject, string $body,
        array $values) {
        global $base_path;
        require_once $base_path . 'modules\SendMailSmtpClass.php';
        if (\Settings\MAIL_SEND) {
            $letter = new \SendMailSmtpClass(\Settings\SMTP_LOGIN,
                \Settings\SMTP_PASSWORD, \Settings\SMTP_HOST,
                \Settings\SMTP_PORT);
            $s_path = $base_path . '\modules\templates\\' . $subject .
                '.txt';
            $s = render_text(file_get_contents($s_path), $values);
            $b_path = $base_path . '\modules\templates\\' . $body .
                '.txt';
            $b = render_text(file_get_contents($b_path), $values);
            $letter->send($to, $s, $b, \Settings\MAIL_FROM);
        }
    }
}
