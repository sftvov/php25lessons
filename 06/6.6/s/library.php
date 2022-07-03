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
