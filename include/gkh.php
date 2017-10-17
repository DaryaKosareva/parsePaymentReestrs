<?php

function gkh($file_array1, $dirnameout) {
    //$bankname="XXXX";
    for ($i = 0; $i < count($file_array1); $i++) {
        $file_array1[$i] = trim($file_array1[$i]);
        $file_array[$i] = array_filter(explode(" ", $file_array1[$i])); //делим строку на элементы массива и удаляем пустые элементы
        $file_array[$i] = array_slice($file_array[$i], 0); //переопределяем индексы массива

        for ($j = 0; $j < count($file_array[$i]); $j++) {
            if (count($file_array[$i]) < 3) {
                array_splice($file_array[$i], count($file_array[$i]), 0, ''); // добавляем элемент в массив до 3х
            }
        }
        if ($file_array[$i][0] == "schet") { //счет
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            echo $schet_in = $file_array[$i][2];  echo "<br><br><br>";
        } elseif ($file_array[$i][0] == "ident") { //первый штрих-код
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $shk1 = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "lschet") { //лицевой счет
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nls = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "date") { //дата платежа
            $date = $file_array[$i][2]; //ГГГГММДД
        } elseif ($file_array[$i][0] == "tran") { //номер квитанции
            $kvit = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "amount") { //сумма операции
            $summaoplaty = $file_array[$i][2]; //сумма в копейках
        } elseif ($file_array[$i][0] == "nazn") {
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nazn = explode(";", $file_array[$i][2]);
            $pok_nom1 = $nazn[0]; //номер счетчика
            $pok_zn1 = $nazn[1]; //показание счетчика
            $pok_nom2 = $nazn[2]; //номер счетчика
            $pok_zn2 = $nazn[3]; //показание счетчика
            $pok_nom3 = $nazn[4]; //номер счетчика
            $pok_zn3 = $nazn[5]; //показание счетчика
            $dplat = $nazn[6]; //период
        }elseif ($file_array[$i][0] == "inn") { //инн
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $inn = $file_array[$i][2];
        }

    }
    $file_array_set = file("//10.192.1.70/MassPay/doc_export/erc_all/ini_org/setorg.ini"); // Считывание файла в массив $file_array_set
    //$file_array_set = file("C:/Online/setorg.ini"); // Считывание файла в массив $file_array_set
    //print_r($file_array_set);
          for ($h = 0; $h < 165; $h++) {
               $str_in2 = explode(";", $file_array_set[$h]); //делим строку на элементы массива
                if($schet_in==$str_in2[9]){
                        $bankname=$str_in2[1];
                        break;
                }
          }
    $nom_pachki1 = date('ymdHi'); //номер пачки
    $nom_pachki2 = date('Hiymd');  //номер пачки
    $kolopl = 1; //для количества оплат в пачке

    return array($summaoplaty, $shk1, $nls, $nom_pachki1, $nom_pachki2, $date, $kvit, $bankname, $kolopl, $dplat, $pok_nom1, $pok_zn1, $pok_nom2, $pok_zn2, $pok_nom3, $pok_zn3, $inn);
}

function gkh2($dirnameout, $arr) { //для записи строк в файл
             print_r($arr);
              echo "<br><br><br>";
    $arr_itog = array();
    $arr_itog = $arr;
    $r = 0;
    for ($i = 0; $i < count($arr_itog); $i++) {
        $poisk = $arr_itog[$i][1];
        for ($j = $i + 1; $j < count($arr_itog) - 1; $j++) {
            if ($poisk == $arr_itog[$j][1]) {
                $arr_itog[$j][0] = $arr_itog[$i][0] + $arr_itog[$j][0];
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
        $itogsum = $arr_itog[$i][0];
        $shk1 = $arr_itog[$i][1];
        $date = $arr_itog[$i][5];
        $dat = $arr_itog[$i][5] + 1;
        $bankname = $arr_itog[$i][7];
        $nom_pachki1 = $arr_itog[$i][3];
        $nom_pachki2 = $arr_itog[$i][4];
        $kolopl = $arr_itog[$i][8];
          $inn = $arr_itog[$i][16];
        $dateformat = substr($date, 6, 2) . '.' . substr($date, 4, 2) . '.' . substr($date, 0, 4); //меням формат даты на ДД.ММ.ГГГГ
        $dat = substr($dat, 6, 2) . '.' . substr($dat, 4, 2) . '.' . substr($dat, 0, 4); //меням формат даты на ДД.ММ.ГГГГ

        if (strlen($itogsum) == 1) {
            $itogsumrub = substr($itogsum, 0, -2) . '.0' . substr($itogsum, -2); //сумма в рублях
        } else {
            $itogsumrub = substr($itogsum, 0, -2) . '.' . substr($itogsum, -2); //сумма в рублях
        }

        $str_zop = "***|049205603|" . $shk1 . "|" . $nom_pachki1 . "|" . date('d.m.Y') . "|" . date('H:i:s') . "|" . date('d.m.Y') . "|1|0.00|" . $itogsumrub . "|0|0.00|!1.00|\r\n"; //заголовок объединенной пачки

        $str_zpo = "###|108|" . $shk1 . "|" . $nom_pachki2 . "|" . date('d.m.Y') . "|" . date('d.m.Y') . "|" . $kolopl . "|0.00|" . $itogsumrub . "|0|0.00|0|!1.00|\r\n"; //заголовок пачки оплаты


          /*$file_array = file("include/compl/setorg.ini"); // Считывание файла в массив $file_array
          for ($h = 0; $h < count($file_array); $h++) {
                $str_in = explode(";", $file_array[$h]); //делим строку на элементы массива
                if($inn==$str_in[5]){
                        echo $bankname=$str_in[1];
                        break;
                }
          }*/
              //echo $bankname;
        $filenameout = $dirnameout . '/' . "GKH" . $bankname . "E" . date('d') . ".txt";

        $fp = fopen($filenameout, "x"); // Открываем файл в режиме записи
        if ($fp) {
            $write = fwrite($fp, $str_zop); // Запись в файл заголовка объединенной пачки
            $write = fwrite($fp, $str_zpo); // Запись в файл заголовка пачки оплаты
        }
        //fclose($fp);
    }

    if ($handle = opendir($dirnameout)) {
        while (false !== ($filename = readdir($handle))) {
            if ($filename != "." && $filename != "..") {
                $file = $filename;
                $GKH = substr($filename, 0, 3);
                $kod_f = substr($filename, 0, -7);
                if ($GKH == "GKH") {
                    $fp = fopen($dirnameout . '/' . $filename, "a"); // Открываем файл в режиме записи
                    if ($fp) {
                        for ($i = 0; $i < count($arr); $i++) {
                            $summaoplaty = $arr[$i][0];
                            if (strlen($summaoplaty) == 1) {
                                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.0' . substr($summaoplaty, -2); //сумма в рублях
                            } else {
                                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.' . substr($summaoplaty, -2); //сумма в рублях
                            }
                            $shk1 = $arr[$i][1];
                            $date = $arr[$i][5];
                            $kvit = $arr[$i][6];
                            $nls = $arr[$i][2];
                            $bankname = $arr[$i][7];
                            $kolopl = $arr[$i][8];
                            $dplat = $arr[$i][9];
                            $pok_nom1 = $arr[$i][10];
                            $pok_zn1 = $arr[$i][11];
                            $pok_nom2 = $arr[$i][12];
                            $pok_zn2 = $arr[$i][13];
                            $pok_nom3 = $arr[$i][14];
                            $pok_zn3 = $arr[$i][15];
                                    $inn = $arr[$i][16];
                                    /*$file_array1 = file("include/compl/setorg.ini"); // Считывание файла в массив $file_array1
          for ($h1 = 0; $h1 < count($file_array1); $h1++) {
                $str_in = explode(";", $file_array1[$h1]); //делим строку на элементы массива
                if($inn==$str_in[5]){
                        $bankname=$str_in[1];
                        break;
                }
          }     */

                            if ($kod_f == "GKH" . $bankname) {
                                $str_inf = "@@@|" . $kvit . "|" . $shk1 . "|41|6|" . $nls . "|" . $dateformat . "|" . $dplat . "|0000|0.00|" . $summaoplatyrub . "|0|0|0|0.00||$pok_nom1,$pok_zn1;$pok_nom2,$pok_zn2;$pok_nom3,$pok_zn3|\r\n"; //информация об оплате

                                $write = fwrite($fp, $str_inf); // Запись в файл информации
                            }
                        }
                    }
                    fclose($fp);
                }
            }
        }
    }
}

?>