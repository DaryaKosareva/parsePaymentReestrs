<?php

function tattelekom($file_array1, $dirnameout) {
    for ($i = 0; $i < count($file_array1); $i++) {
        $file_array1[$i] = trim($file_array1[$i]);
        $file_array[$i] = array_filter(explode(" ", $file_array1[$i])); //делим строку на элементы массива и удаляем пустые элементы
        $file_array[$i] = array_slice($file_array[$i], 0); //переопределяем индексы массива

        for ($j = 0; $j < count($file_array[$i]); $j++) {
            if (count($file_array[$i]) < 3) {
                array_splice($file_array[$i], count($file_array[$i]), 0, ''); // добавляем элемент в массив до 3х
            }
        }
        if ($file_array[$i][0] == "date") { //дата оплаты 
            $date = $file_array[$i][2]; //ГГГГММДД
            $dateformat = substr($date, 6, 2) . '.' . substr($date, 4, 2) . '.' . substr($date, 0, 4); //меням формат даты на ДД.ММ.ГГГГ
        } elseif ($file_array[$i][0] == "amount") { //сумма операции
            $summaoplaty = $file_array[$i][2]; //сумма в копейках
        } elseif ($file_array[$i][0] == "lschet") { //номер телефона, лицевого счета
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nls = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "tran") { //номер квитанции
            $tran = $file_array[$i][2];
        }
    }

    echo $filenameout = $dirnameout . '/' . "619_00_001_" . $date . '_4999_100_' . "XXXX" . ".txt";

    $str_exp_out = array($dateformat, "", "", $summaoplaty, $nls, $tran); //создаем массив на выход


    $str_out = implode("|", $str_exp_out) . "\r\n";
    //echo '<br>';

    $fp = fopen($filenameout, "a"); // Открываем файл в режиме записи
    $test = fwrite($fp, $str_out); // Запись в файл

    fclose($fp);
    return array("$summaoplaty", "$date");
}

function tattelekom2($dirnameout, $arr) { //для записи итоговой суммы в названии файла  
    $r = 0;
    $k = 0;

    $date = "";
    //$itogsum = 0;
    for ($i = 0; $i < count($arr) + 1; $i++) {
        $poisk = $arr[$i][1];
        for ($j = $i + 1; $j < count($arr); $j++) {
            if ($poisk == $arr[$j][1]) {
                $arr[$j][0] = $arr[$i][0] + $arr[$j][0];
                $arr[$i] = "";
            }
        }
    }
    $arr = array_filter($arr);
    $arr = array_slice($arr, 0);

    $r = count($arr);
    for ($i = 0; $i < $r; $i++) {
        $itogsum = $arr[$i][0];
        $date = $arr[$i][1];
        $filenameout1 = $dirnameout . '/' . "619_00_001_" . $date . '_4999_100_' . "XXXX" . ".txt";
        $filenameout2 = $dirnameout . '/' . "619_00_001_" . $date . '_4999_100_' . $itogsum . ".txt";
        rename($filenameout1, $filenameout2);
    }
}

?>