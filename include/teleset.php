<?php

function teleset($file_array1, $dirnameout, $date) {
    $kvitan = "";
    $nom_op = "";
    $ttt = 0;
    $def =
            array(
                array("DATA", "D", 8), // дата платежа -> ДД.ММ.ГГГГ
                array("OC", "N", 6, 0), // номер отделения банка -> 8610
                array("N_KAS", "C", 5), // номер подразделения банка -> номер терминала
                array("NOM_OP", "N", 6, 0), // порядковый номер операции в подразделении банка
                array("KATEG", "C", 2), // категория получателя ("пусто")
                array("SUMMA", "N", 19, 2), // сумма платежа -> РРРР.КК
                array("TELEFON", "C", 15), // номер договора, номер телефона 
                array("KR_TEL", "C", 1), // 0 или 1
                array("KVITAN", "C", 15), // номер квитанции
                array("SROK_OP", "D", 8), // срок оплаты с квитанции ("пусто")
                array("TIR_ZAR", "C", 1), // операция (по счету, интернет и т.п.)
                array("DAT_OBR", "D", 8), // дата обработки -> текущая дата
                array("NAME", "C", 25) // ФИО плательщика (заполняется если нет штрих-кода)
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
        if ($file_array[$i][0] == "date") { //дата операции 
            $dat_opl = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "termnum") { //номер терминала
            $termnum = ""; //$file_array[$i][2];
        } elseif ($file_array[$i][0] == "amount") { //сумма операции
            $summaoplaty = $file_array[$i][2]; //сумма в копейках
            if (strlen($summaoplaty) == 1) {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.0' . substr($summaoplaty, -2); //сумма в рублях
            } else {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.' . substr($summaoplaty, -2); //сумма в рублях
            }
        } elseif ($file_array[$i][0] == "ident") { //номер телефона, лицевого счета
            /* $file_array[$i][2] = substr($file_array[$i][2], 1);
              $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
              $nls = $file_array[$i][2]; */

            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $kodgoroda = substr($file_array[$i][2], 0, -7);
            if ($kodgoroda == "855" && strlen($file_array[$i][2]) == 10) {
                //$nls = substr($file_array[$i][2],4);			
            } elseif ($kodgoroda == "843" && strlen($file_array[$i][2]) == 10) {
                $nls = substr($file_array[$i][2], 3);
            } else {
                $nls = $file_array[$i][2];
            }
            if (is_numeric($nls) == False) {
                $ttt = 1;
                //$nls="oshibka";	
            } else {
                //лицевой счет состоит только из цифр.
            }
        } elseif ($file_array[$i][0] == "tran") { //номер квитанции
            $tran = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "numschet") {
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            if ($file_array[$i][2] == "TAR_TLS" || $file_array[$i][2] == 'TAR_TLSIN' || $file_array[$i][2] == "TAR_TLSTB") {
                $nn = "kaz"; //"TLC";
            } else {
                $nn = "ch"; //"TLS";
            }
        }
    }

    $filenameout = $dirnameout . '/SB_TLC_' . $nn . "_" . $date . ".dbf";
    $str_exp_out = array($dat_opl, "8610", $termnum, $nom_op, "", $summaoplatyrub, $nls, "0", $tran, "", "", date('Ymd'), ""); //создаем массив на выход

    $db = dbase_open($filenameout, 2);

    if (!$db)
        $db = dbase_create($filenameout, $def);

    $ret = dbase_add_record($db, $str_exp_out);

    if ($ret == false)
        print "<strong>Error _ add!</strong>";

    dbase_close($db);


    if ($ttt == 1) {
        $fp = fopen($dirnameout . "/ошибка - ТЕЛЕСЕТ.txt", "a"); // Открываем файл в режиме записи
        $test = fwrite($fp, '#в лицевом счете ошибка# ФАЙЛ: ' . $filenameout . "\r\n"); // Запись в файл
        fclose($fp);
    }
}

?>