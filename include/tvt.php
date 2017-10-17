<?php

function tvt($file_array1, $dirnameout, $date) {
    $filenameout = $dirnameout . '/' . "TVT" . $date . ".dbf";
    $dat_opl = "";
    $summaoplaty = 0;
    $nta = "";
    $nkv = "";
    $vid_op = "";
    $termnum = 0;

    $def =
            array(
                array("DOPL", "D", 8), // Дата платежа -> ДД.ММ.ГГГГ
                array("SUMOPL", "N", 8, 2), // Сумма платежа -> РРРР.КК
                array("NTA", "N", 10, 0), // Лицевой счет
                array("NKV", "N", 15, 0), // Номер квитанции      
                array("VID_OP", "N", 6, 0), // вид операции -> 010 - телефон, 016 - интернет       
                array("OS", "N", 10, 0), // Номер филиала -> 8610
                array("KASSA", "N", 5, 0) // Ном. Оператора (кассира) 
    );
    for ($i = 0; $i < count($file_array1); $i++) {
        $file_array1[$i] = trim($file_array1[$i]);
        $file_array[$i] = array_filter(explode(" ", $file_array1[$i])); //делим строку на элементы массива и удаляем пустые элементы
        $file_array[$i] = array_slice($file_array[$i], 0); //переопределяем индексы массива

        for ($j = 0; $j < count($file_array[$i]); $j++) {
            if (count($file_array[$i]) < 3) {
                array_splice($file_array[$i], count($file_array[$i]), 0, ''); // добавляем элемент в массив
            }
        }
        if ($file_array[$i][0] == "date") {// Дата платежа
            $dat_opl = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "amount") { // Сумма платежа
            $summaoplaty = $file_array[$i][2];  //сумма в копейках
            if (strlen($summaoplaty) == 1) {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.0' . substr($summaoplaty, -2); //сумма в рублях
            } else {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.' . substr($summaoplaty, -2); //сумма в рублях
            }
        } elseif ($file_array[$i][0] == "lschet") { //Лицевой счет
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nta = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "tran") { //Номер квитанции
            $nkv = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "numschet") {
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $vid_op = $file_array[$i][2];
            if ($vid_op == "TAR_TBT") {
                $vid_op = "010";
            } else {
                $vid_op = "016";
            }
        } elseif ($file_array[$i][0] == "termnum") { //Ном. Оператора (кассира) 
            $termnum = ""; //$file_array[$i][2];
        }
    }

    $str_exp_out = array($dat_opl, $summaoplatyrub, $nta, $nkv, $vid_op, "8610", $termnum); //создаем массив на выход

    $db = dbase_open($filenameout, 2);

    if (!$db)
        $db = dbase_create($filenameout, $def);

    $ret = dbase_add_record($db, $str_exp_out);

    if ($ret == false)
        print "<strong>Error _ add!</strong>";

    dbase_close($db);
}

?>