<?php

//возвращает контрольное число
$nomer="093300601094700000000094247";
echo get_control_digit($nomer);
function get_control_digit($nomer) { // расчет контрольной суммы

    $chet = 0;
    for ($i = 1; $i < strlen($nomer); $i = $i + 2) {
        $chet = $chet + intval(substr($nomer, $i, 1));
    };

    $nechet = 0;
    for ($i = 0; $i < strlen($nomer); $i = $i + 2) {
        $nechet = $nechet + substr($nomer, $i, 1);
    };

    $total = $chet  + $nechet*3;
    $contr_digit = 10 - substr($total, strlen($total) - 1, 1);

    if ($contr_digit == 10)
        $contr_digit = 0;

    return $contr_digit;
}

?>