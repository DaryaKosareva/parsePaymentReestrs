<?php

function gas($file_array1, $dirnameout, $dirnamein, $filename) {
    $namefile = "GZ";
    $summa1 = 0;
    $summa2 = 0;
    $keks_num = 0;
    $sgazrub = "";
    $stobrub = "";
    $koduslugi = "";
    $pok_zn = 0;
    $pok_dat = "00000000";
    $keks_num_bezshki = 99;
    $keks_num_0 = "";
    $nazn = array();
    $keks = array(
        "Альметьевскгая РЭГС(город)", "Альметьевскгая РЭГС(село)", "Актанышская РЭГС", "Джалильская РЭГС", "Мактаминская РЭГС",
        "Муслюмовская РЭГС", "Сармановская РЭГС", "Арская РЭГС", "Балтасигаз", "Бугульминская РЭГС(город)", "Бугульминская РЭГС(село)",
        "Азнакаевская РЭГС", "Актюбинская РЭГС", "Бавлинская РЭГС", "Карабашская РЭГС", "Ютазинская РЭГС", "Апастовская РЭГС",
        "Буинскгая РЭГС(город)", "Дрожжановская РЭГС", "Кайбицкая РЭГС", "Тетюшская РЭГС", "Агрызская РЭГС", "Елабужская РЭГС",
        "Мамадышская РЭГС", "Менделеевская РЭГС", "Васильевская РЭГС", "ВерхнеУслонская РЭГС", "Зеленодольскгая РЭГС(город)",
        "Камско-Устьинская РЭГС", "Нурлатская РЭГС", "Центральная КЭГС", "Московская КЭГС", "КЭГС 'Горки'", "КЭГС 'Дербышки'", "Юдинская КЭГС",
        "Лениногорская РЭГС(город)", "Лениногорская РЭГС(село)", "Аксубаевская РЭГС", "Черемшанская РЭГС", "Заинская РЭГС",
        "Нижнекамскгая РЭГС(город)", "Нижнекамскгая РЭГС(село)", "Новошешминская РЭГС", "Нурлатская РЭГС", "Лаишевская РЭГС",
        "Пестречинская РЭГС", "Приволжская РЭГС", "Р-Слободская РЭГС", "Сабинская РЭГС", "Тюлячинская РЭГС", "Шеморданский ГУ",
        "Центральная РЭГС", "Атнинская РЭГС", "В-Горская РЭГС", "Кукморская РЭГС", "Челнинская РЭГС(город)", "Челнинская РЭГС(село)",
        "Мензелинская РЭГС", "Тукаевская РЭГС", "Алексеевская РЭГС", "Алькеевская РЭГС", "Спасская РЭГС", "Чистопольская РЭГС",
        "Буинскгая РЭГС(село)", "Акташский ГУ", "частный сектор", "Микрорайон Мирный", "Большеключинский ГУ", "Нижневязовский ГУ",
        "Зеленодольский ГУ"
    );
    $keks2 = array(
        "AL", "AL", "AL", "AL", "AL", "AL", "AL", "SB", "BL", "BG",
        "BG", "BG", "BG", "BG", "BG", "BG", "BU", "BU", "BU", "BU",
        "BU", "BU", "EL", "EL", "EL", "ZL", "ZL", "ZL", "BU", "ZL",
        "KZ", "KZ", "KZ", "KZ", "KZ", "LE", "LE", "LE", "LE", "NI",
        "NI", "NI", "NI", "NU", "PR", "PR", "PR", "SB", "SB", "SB",
        "SB", "ZG", "ZG", "ZG", "ZG", "NC", "NC", "NC", "NC", "CH",
        "CH", "CH", "CH", "BU", "AL", "AL", "ZL", "ZL", "ZL", "ZL"
    );


    $def =
            array(
                array("Dat_opl", "D", 8), // дата оплаты
                array("shki", "C", 28), // штрих-код считанный с квитанции
                array("Nls", "N", 10, 0), // номер лицевого счета абонента в горгазе
                array("Adr", "C", 40), // адрес абонента
                array("Sgaz", "N", 8, 2), // сумма оплаты за газ без штрих-кода
                array("Stob", "N", 8, 2), // сумма оплаты за техобслуживание без штрих-кода
                array("Pok_zn", "N", 12, 3), // текущие показания счетчика, указываемые абонентом при оплате квитанции
                array("Pok_dat", "D", 8) // дата показания счетчика, указываемые абонентом при оплате квитанции
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

        if ($file_array[$i][0] == "date") { //дата оплаты
            $date = $file_array[$i][2];
        }elseif ($file_array[$i][0] == "lschet") { //штрих-код считанный с квитанции
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $shki = $file_array[$i][2];
                $nls = substr($shki, 4, 9);// лицевой счет
                $koduslugi = substr($shki, 2, 2);// код услуги
                //проверка контрольной суммы
                $shki_bezsumm = substr($shki, 0, -1);
                $shki_controlsumm = substr($shki, -1);
                $contrl_summ = get_control_digit($shki_bezsumm);
                if ($contrl_summ == $shki_controlsumm && strlen($shki) == 28) {
                    //echo "проверка";
                } else {
                    $fp = fopen($dirnameout . "/Ошибка! #$tran# Контрольная сумма неверна.txt", "w+"); // Открываем файл в режиме записи
                    $test = fwrite($fp, "Ошибка в транзакции: $tran \r\n"); // Запись в файл
                    return 1;
                }
        }elseif ($file_array[$i][0] == "amount") { //сумма
            $summaoplaty = $file_array[$i][2];
            if (strlen($summaoplaty) == 1) {
                $summaoplatyrub = '0.0' . substr($summaoplaty, -2); //сумма оплаты в рублях
            } else {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.' . substr($summaoplaty, -2); //сумма оплаты в рублях
            }
        }elseif ($file_array[$i][0] == "tran") { //номер транзакции
            $file_array1[$i] = substr($file_array1[$i], 11);
            $file_array1[$i] = substr($file_array1[$i], 0, -1);
            $tran = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "nazn") {
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nazn = explode(";", $file_array[$i][2]);

            /*for ($j = 0; $j < count($nazn); $j++) {
                if (count($nazn) < 3) {
                    array_splice($file_array[$i], count($file_array[$i]), 0, ''); // добавляем элемент в массив
                }
            }*/
                $keks_num = $nazn[3];
            $pok_zn = $nazn[2]; //показание счетчика
            $pok_dat = $nazn[4]; //дата снятия показания прибора
            if ($pok_dat != "00000000") {
                $pok_dat = "20" . substr($pok_dat, -2, 2) . substr($pok_dat, 3, 2) . substr($pok_dat, 0, 2);
            }
            $pok_znformat = substr($pok_zn, 0, -3) . '.' . substr($pok_zn, -3); //меням формат показания счетчика
        }
    }

    if ($koduslugi == "33") {
        $sgaz = $summaoplaty;
        if (strlen($summaoplaty) == 1) {
            $sgazrub = '0.0' . substr($sgaz, -2); //сумма оплаты в рублях
        } else {
            $sgazrub = substr($sgaz, 0, -2) . '.' . substr($sgaz, -2); //сумма оплаты в рублях
        }
    } elseif ($koduslugi == "35") {
        $stob = $summaoplaty;
        if (strlen($summaoplaty) == 1) {
            $stobrub = '0.0' . substr($stob, -2); //сумма оплаты в рублях
        } else {
            $stobrub = substr($stob, 0, -2) . '.' . substr($stob, -2); //сумма оплаты в рублях
        }
    }


    $str_out = array($date, $shki, $nls, "", $sgazrub, $stobrub, $pok_zn, $pok_dat); //массив в выходной файл

    if (strlen($keks_num) == 1) {
        $keks_num_0 = "0" . $keks_num;
    } else {
        $keks_num_0 = $keks_num;
    }
    $fl=$namefile . $keks2[$keks_num-1] . $keks_num_0 . "E" . substr($date, -2);
    $filenameout = $dirnameout . '/' . $fl; //имя выходного файла

    $db = dbase_open($filenameout . ".dbf", 2);
    if (!$db)
        $db = dbase_create($filenameout . ".dbf", $def);
    $ret = dbase_add_record($db, $str_out);
    if ($ret == false)
        print "<strong>Error _ add!</strong>";
    $nn = dbase_numrecords($db);

    $nf = dbase_numfields($db);

    for ($j = 0; $j < $nn + 1; $j++) {
        $rec = dbase_get_record($db, $j);

        $summa1 = $rec[4] + $summa1;

        $summa2 = $rec[5] + $summa2;

        //$summa1 = substr($rec[4], 0, -3) . substr($rec[4], -2) + $summa1;
        //$summa2 = substr($rec[5], 0, -3) . substr($rec[5], -2) + $summa2;
    }

    $summa = $summa1 + $summa2;

    $fp = fopen($filenameout . ".txt", "w+"); // Открываем файл в режиме записи
    $test = fwrite($fp, "      Сопроводительный документ\r\n"); // Запись в файл
    $test = fwrite($fp, "Дискеты NN:\r\n"); // Запись в файл
    $test = fwrite($fp, "ОТ КУДА: Отделение 'Банк Татарстан' №8610 СБРФ\r\n"); // Запись в файл
    $test = fwrite($fp, "\r\n"); // Запись в файл
    $test = fwrite($fp, "Дата:         " . substr($date, -2) . "." . substr($date, 4, 2) . "." . substr($date, 0, 4) . "\r\n"); // Запись в файл
    $test = fwrite($fp, "\r\n"); // Запись в файл
    $test = fwrite($fp, "Имя файла:   " . $fl . ".dbf\r\n"); // Запись в файл     
    $test = fwrite($fp, "Количество записей: " . dbase_numrecords($db) . "\r\n"); // Запись в файл
    $test = fwrite($fp, "Сумма:            $summa\r\n"); // Запись в файл
    $test = fwrite($fp, "Передал:  Оператор  ________________\r\n"); // Запись в файл
    $test = fwrite($fp, "          Контролер ________________ \r\n"); // Запись в файл
    $test = fwrite($fp, "\r\n"); // Запись в файл
    $test = fwrite($fp, "Принял:   Оператор  ________________ \r\n"); // Запись в файл
    $test = fwrite($fp, "          Контролер ________________ \r\n"); // Запись в файл
    fclose($fp);

    dbase_close($db);
}

//} else
/* if ($summaoplaty != substr($shki, 13, 8)) {
  $fp = fopen($dirnameout . "/Ошибка! Сумма не совпадает.txt", "w+"); // Открываем файл в режиме записи
  $test = fwrite($fp, "Ошибка! ГАЗ!\r\n"); // Запись в файл
  $test = fwrite($fp, "Сумма, введенная плательщиком НЕ СОВПАДАЕТ с суммой по штрих-коду.\r\n"); // Запись в файл
  $test = fwrite($fp, "Дата оплаты: " . substr($date, -2) . "." . substr($date, 4, 2) . "." . substr($date, 0, 4) . "\r\n"); // Запись в файл
  $test = fwrite($fp, "Номер транзакции: " . $tran . "\r\n"); // Запись в файл
  $test = fwrite($fp, "=============================================\r\n"); // Запись в файл
  dbase_close($db);
  } */
?>