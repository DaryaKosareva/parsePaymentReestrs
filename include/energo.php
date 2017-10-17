<?php

function energo($file_array1, $dirnameout) { //параметр , $kol
    $rpu = "0000";
    $ofc_nom = 0;
    $ofc_mail = 0;
    $rpu_ofc =
            array(
                array(9160, 'pit@ensal.tatenergo.ru', 900, 'officeazn@ensal.tatenergo.ru'),
                array(9160, 'pit@ensal.tatenergo.ru', 1400, 'alrpu@ensal.tatenergo.ru'),
                array(9160, 'pit@ensal.tatenergo.ru', 3600, 'muslumrpu@ensal.tatenergo.ru'),
                array(9160, 'pit@ensal.tatenergo.ru', 3700, 'algpu@ensal.tatenergo.ru'),
                array(9160, 'pit@ensal.tatenergo.ru', 4400, 'sarmanoffice@ensal.tatenergo.ru'),
                array(9160, 'pit@ensal.tatenergo.ru', 9700, 'algpu@ensal.tatenergo.ru'),
                array(9161, 'pit@ensbg.tatenergo.ru', 1800, 'belovua-bv@ensbg.tatenergo.ru'),
                array(9161, 'pit@ensbg.tatenergo.ru', 2000, 'bugrpu@ensbg.tatenergo.ru'),
                array(9161, 'pit@ensbg.tatenergo.ru', 3200, 'kvashinav-ln@ensbg.tatenergo.ru'),
                array(9161, 'pit@ensbg.tatenergo.ru', 4900, 'hcerpu@ensbg.tatenergo.ru'),
                array(9161, 'pit@ensbg.tatenergo.ru', 4901, 'lankinaev-ch@ensbg.tatenergo.ru'),
                array(9161, 'pit@ensbg.tatenergo.ru', 5100, 'hakimovaga-utz@ensbg.tatenergo.ru'),
                array(9161, 'pit@ensbg.tatenergo.ru', 6000, 'bgpu@ensbg.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 1500, 'apasrpu@ensbu.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 2100, 'BuinOPU@ensbu.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 2200, 'vuslrpu@ensbu.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 2400, 'DrojRPU1@ensbu.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 2800, 'KaybRPU@ensbu.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 2900, 'KUstRPU@ensbu.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 4600, 'TetOPU@ensbu.tatenergo.ru'),
                array(9162, 'pit@ensbu.tatenergo.ru', 5300, 'Nurrpu@ensbu.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 800, 'agriz_sbyt@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 801, 'agriz@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 2500, 'elarpu_sbyt@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 3000, 'kuk_sbyt@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 3300, 'mamd_sbyt@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 3400, 'zinnatullinarr@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 4300, 'sabi_sbyt@ ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 4800, 'tul_sbyt@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 6100, 'egpu_sbyt@ensel.tatenergo.ru'),
                array(9163, 'pit@ensel.tatenergo.ru', 8900, 'kuk_sbyt@ensel.tatenergo.ru'),
                array(9164, 'pit@enskzn.tatenergo.ru', 100, 'kaz_sbyt_rpu1@enskzn.tatenergo.ru'),
                array(9164, 'pit@enskzn.tatenergo.ru', 200, 'kaz_sbyt_rpu2@enskzn.tatenergo.ru'),
                array(9164, 'pit@enskzn.tatenergo.ru', 300, 'kaz_sbyt_rpu3@enskzn.tatenergo.ru'),
                array(9164, 'pit@enskzn.tatenergo.ru', 400, 'yakupovamz@enskzn.tatenergo.ru'),
                array(9164, 'pit@enskzn.tatenergo.ru', 500, 'kaz_sbyt_rpu5@enskzn.tatenergo.ru'),
                array(9164, 'pit@enskzn.tatenergo.ru', 600, 'yakupovamz@enskzn.tatenergo.ru'),
                array(9164, 'pit@enskzn.tatenergo.ru', 700, 'kaz_sbyt_rpu7@enskzn.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 1100, 'fattahovarf@ensnk.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 1102, 'fattahovarf@ensnk.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 2600, 'mitrofanovaem@ensnk.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 3500, 'salihovaga@ensnk.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 3800, 'husnutdinovaOK@ensnk.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 4700, 'shaihattarovrm@ensnk.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 5900, 'husnutdinovaOK@ensnk.tatenergo.ru'),
                array(9165, 'pit@ensnk.tatenergo.ru', 6300, 'husnutdinovaOK@ensnk.tatenergo.ru'),
                array(9166, 'pit@ensnch.tatenergo.ru', 5400, 'musinalr@svrpu.ensnch.tatenergo.ru'),
                array(9166, 'pit@ensnch.tatenergo.ru', 5500, 'kronberguv@ensnch.tatenergo.ru'),
                array(9166, 'pit@ensnch.tatenergo.ru', 6600, 'musinalr@svrpu.ensnch.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 1600, 'arskrpy@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 1700, 'atnarpy@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 1900, 'baltasirpy@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 2300, 'vgorarpy@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 2700, 'zelopy@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 3100, 'kulakoffac@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 4100, 'pesrpu@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 4200, 'DEMENTIEVANA@ENSVG.TATENERGO.RU'),
                array(9167, 'pit@ensvg.tatenergo.ru', 5700, 'prigrpu@ensvg.tatenergo.ru'),
                array(9167, 'pit@ensvg.tatenergo.ru', 6400, 'zelopy@ensvg.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 1000, 'aksubrpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 1200, 'aleksrpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 1201, 'aleksrpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 1300, 'alkrpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 3900, 'novrpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 4000, 'nurlrpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 4500, 'Spasrpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 5000, 'chirpu@enschi.tatenergo.ru'),
                array(9168, 'pit@enschi.tatenergo.ru', 6500, 'chigpu@enschi.tatenergo.ru')
    );

    for ($i = 0; $i < count($file_array1); $i++) {
        //echo $i."####<br>";
        $file_array1[$i] = trim($file_array1[$i]);
        $file_array[$i] = array_filter(explode(" ", $file_array1[$i])); //делим строку на элементы массива и удаляем пустые элементы
        $file_array[$i] = array_slice($file_array[$i], 0); //переопределяем индексы массива

        for ($j = 0; $j < count($file_array[$i]); $j++) {
            if (count($file_array[$i]) < 3) {
                array_splice($file_array[$i], count($file_array[$i]), 0, ''); // добавляем элемент в массив
            }
        }

        if ($file_array[$i][0] == "nazn") {
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nazn = explode(";", $file_array[$i][2]);
            $rpu = $nazn[3]; //РПУ
            $kodls = $nazn[1]; //код лицевого счета
            $pokaz = $nazn[2]; //показание счетчика
            for ($l = 0; $l < count($rpu_ofc); $l++) {
                if ($rpu_ofc[$l][2] == $rpu) {
                    $ofc_nom = $rpu_ofc[$l][0];
                    $ofc_mail = $rpu_ofc[$l][1];
                }
            }
        } elseif ($file_array[$i][0] == "date") { //дата платежа
            $date = $file_array[$i][2]; //ГГГГММДД            
        } elseif ($file_array[$i][0] == "amount") { //сумма
            $summaoplaty = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "fio") { //e-mail
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $email = $file_array[$i][2];
        }
    }
    $kolopl = 1;
    return array($rpu, $date, $summaoplaty, $email, $kodls, $pokaz, $ofc_nom, $ofc_mail, $kolopl);
}

function energo2($dirnameout, $arr) { //параметр , $k
    //ПЕРВЫЙ ФАЙЛ
    //print_r($arr);
    $arr_itog = array();
    $arr_itog = $arr;
    $r = 0;
    for ($i = 0; $i < count($arr_itog); $i++) {
        $poisk_rpu = $arr_itog[$i][0];
        $poisk_date = $arr_itog[$i][1];
        for ($j = $i + 1; $j < count($arr_itog) - 1; $j++) {
            if ($poisk_rpu == $arr_itog[$j][0] && $poisk_date == $arr_itog[$j][1]) {
                $arr_itog[$j][2] = $arr_itog[$i][2] + $arr_itog[$j][2];
                $arr_itog[$j][8] = $arr_itog[$i][8] + $arr_itog[$j][8];
                $arr_itog[$i] = "";
                break;
            }
        }
    }
    $arr_itog = array_filter($arr_itog);
    $arr_itog = array_slice($arr_itog, 0);
    $r = count($arr_itog);
    for ($i = 0; $i < $r; $i++) {
        $rpu = $arr_itog[$i][0];
        $date = $arr_itog[$i][1];
        $itogsum = $arr_itog[$i][2];
        $email = $arr_itog[$i][3];

        $str_zag = "WINDOWS|2|ЭРО-4|" . date('d.m.Y') . "|ОСБ ВВСБРФ №8610 Банк Татарстан|30101810600000000603|\r\n"; //заголовок файла
        $filenameout = $dirnameout . '/Erpue_' . $date . '-' . $date . '-' . $rpu . '^' . $email . ".txt";
        $fp = fopen($filenameout, "x"); // Открываем файл в режиме записи
        if ($fp) {
            $write = fwrite($fp, $str_zag); // Запись в файл заголовка 
        }
    }
    for ($i = 0; $i < count($arr); $i++) {
        $rpu = $arr[$i][0];
        $date = $arr[$i][1];
        $summaoplaty = $arr[$i][2];
        $email = $arr[$i][3];
        $kodls = $arr[$i][4];
        $pokaz = $arr[$i][5];
        $str_inf = "0208|$kodls|$date|$summaoplaty|$pokaz|\r\n";
        $filenameout = $dirnameout . '/Erpue_' . $date . '-' . $date . '-' . $rpu . '^' . $email . ".txt";
        $fp = fopen($filenameout, "a"); // Открываем файл в режиме записи
        if ($fp) {
            $write = fwrite($fp, $str_inf); // Запись в файл заголовка объединенной пачки
        }
        fclose($fp);
    }

    //ВТОРОЙ ФАЙЛ
    $arr_itog_ofc = array();
    $arr_itog_ofc = $arr;
    $r = 0;
    for ($i = 0; $i < count($arr_itog_ofc); $i++) {
        $poisk_rpu = $arr_itog_ofc[$i][0];
        $poisk_date = $arr_itog_ofc[$i][1];
        for ($j = $i + 1; $j < count($arr_itog_ofc) - 1; $j++) {
            if ($poisk_rpu == $arr_itog_ofc[$j][0] && $poisk_date == $arr_itog_ofc[$j][1]) {
                $arr_itog_ofc[$j][2] = $arr_itog_ofc[$i][2] + $arr_itog_ofc[$j][2];
                $arr_itog_ofc[$j][8] = $arr_itog_ofc[$i][8] + $arr_itog_ofc[$j][8];
                $arr_itog_ofc[$i] = "";
                break;
            }
        }
    }
    $arr_itog_ofc = array_filter($arr_itog_ofc);
    $arr_itog_ofc = array_slice($arr_itog_ofc, 0);
    $r = count($arr_itog_ofc);
    for ($i = 0; $i < $r; $i++) {
        $ofc_nom = $arr_itog_ofc[$i][6];
        $date = $arr_itog_ofc[$i][1];
        $itogsum = $arr_itog_ofc[$i][2];
        $ofc_mail = $arr_itog_ofc[$i][7];
        $kolopl = $arr_itog_ofc[$i][8];
        $filenameout = $dirnameout . '/Eofce_' . $date . '-' . $date . '-' . $ofc_nom . '^' . $ofc_mail . ".txt";
        $fp = fopen($filenameout, "x"); // Открываем файл в режиме записи
        if ($fp) {
            $write = fwrite($fp, " РПУ    ¦     платежи  ¦      сумма    \r\n"); // Запись в файл заголовка 
            $write = fwrite($fp, "---------------------­———---------------\r\n"); // Запись в файл заголовка 
        }
    }
    echo "<br><br>";
    //print_r($arr_itog_ofc);
    for ($i = 0; $i < count($arr_itog_ofc); $i++) {
        $date = $arr_itog_ofc[$i][1];
        $ofc_nom = $arr_itog_ofc[$i][6];
        $ofc_mail = $arr_itog_ofc[$i][7];
        echo $rpu = $arr_itog_ofc[$i][0];
        while (strlen($rpu) < 7) {
            $rpu = " " . $rpu;
        }
        $kolopl = $arr_itog_ofc[$i][8];
        while (strlen($kolopl) < 13) {
            $kolopl = " " . $kolopl;
        }
        $summaoplaty = $arr_itog_ofc[$i][2];

        if (strlen($summaoplaty) == 1) {
            $summaoplatyrub = '0,0' . substr($summaoplaty, -2); //сумма оплаты в рублях
        } else {
            $summaoplatyrub = substr($summaoplaty, 0, -2) . ',' . substr($summaoplaty, -2); //сумма оплаты в рублях
        }
        while (strlen($summaoplatyrub) < 15) {
            $summaoplatyrub = " " . $summaoplatyrub;
        }

        $str_inf = $rpu . " ¦" . $kolopl . " ¦" . $summaoplatyrub . "\r\n";
        $filenameout = $dirnameout . '/Eofce_' . $date . '-' . $date . '-' . $ofc_nom . '^' . $ofc_mail . ".txt";
        $fp = fopen($filenameout, "a"); // Открываем файл в режиме записи
        if ($fp) {
            $write = fwrite($fp, $str_inf); // Запись в файл заголовка объединенной пачки
        }
        fclose($fp);
    }
    for ($i = 0; $i < count($arr_itog_ofc); $i++) {
        $poisk_ofc = $arr_itog_ofc[$i][6];
        $poisk_date = $arr_itog_ofc[$i][1];
        for ($j = $i + 1; $j < count($arr_itog_ofc) - 1; $j++) {
            if ($poisk_ofc == $arr_itog_ofc[$j][6] && $poisk_date == $arr_itog_ofc[$j][1]) {
                $arr_itog_ofc[$j][2] = $arr_itog_ofc[$i][2] + $arr_itog_ofc[$j][2];
                $arr_itog_ofc[$j][8] = $arr_itog_ofc[$i][8] + $arr_itog_ofc[$j][8];
                $arr_itog_ofc[$i] = "";
                break;
            }
        }
    }
    $arr_itog_ofc = array_filter($arr_itog_ofc);
    $arr_itog_ofc = array_slice($arr_itog_ofc, 0);
    $r = count($arr_itog_ofc);
    for ($i = 0; $i < $r; $i++) {
        $ofc_nom = $arr_itog_ofc[$i][6];
        $date = $arr_itog_ofc[$i][1];
        $itogsum = $arr_itog_ofc[$i][2];
        if (strlen($itogsum) == 1) {
            $itogsumrub = '0,0' . substr($itogsum, -2); //сумма оплаты в рублях
        } else {
            $itogsumrub = substr($itogsum, 0, -2) . ',' . substr($itogsum, -2); //сумма оплаты в рублях
        }

        while (strlen($itogsumrub) < 15) {
            $itogsumrub = " " . $itogsumrub;
        }
        $ofc_mail = $arr_itog_ofc[$i][7];
        $kolopl = $arr_itog_ofc[$i][8];
        while (strlen($kolopl) < 13) {
            $kolopl = " " . $kolopl;
        }
        $filenameout = $dirnameout . '/Eofce_' . $date . '-' . $date . '-' . $ofc_nom . '^' . $ofc_mail . ".txt";
        $fp = fopen($filenameout, "a"); // Открываем файл в режиме записи
        if ($fp) {
            $write = fwrite($fp, "---------------------­———---------------\r\n"); // Запись в файл подвала 
            $write = fwrite($fp, " Итого: ¦$kolopl ¦$itogsumrub \r\n"); // Запись в файл подвала
        }
    }
}

?>