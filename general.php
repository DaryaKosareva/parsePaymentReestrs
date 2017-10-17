<?php

$dirnamein = "C:/WORK/ARH_REESTR/REESTRS/IN";
$dirnameout = "C:/WORK/ARH_REESTR/REESTRS/OUT";

include("include/compl/get_control_digit.php");
include("include/tattelekom.php");
include("include/tvt.php");
include("include/teleset.php");
include("include/tnpko.php");
include("include/energo.php");
include("include/gas.php");
include("include/gkh.php");
require_once('include/compl/pclzip.lib.php');



$date = "";
$sum = 0;
$arr = array();
$arr_TTC = array();
$arr_GKH = array();
$arr_ENRGO = array();
$a_GKH = array();
$flag = 0;
$flag_gkh = false;
$flag_tattelekom = false;
$flag_energo = false;
if ($handle = opendir($dirnamein)) {
    while (false !== ($filename = readdir($handle))) {
        if ($filename != "." && $filename != "..") {
            echo "<br>$filename<br>";
            $filenamein = $dirnamein . '/' . $filename;
            $file_array = file($filenamein); // Считывание файла в массив $file_array
            for ($i = 0; $i < count($file_array); $i++) {
                $file_array[$i] = trim($file_array[$i]);
            }
            $S1 = $file_array[0];
            $S2 = $file_array[1];
            $file_array[0] = "";
            $file_array[1] = "";
            $file_array = array_filter($file_array); //удаляем пустые элементы
            $file_array = array_slice($file_array, 0); //переопределяем индексы массива
            $tran_array = array();
            for ($i = 0; $i < count($file_array); $i++) {
                $file_array[$i] = trim($file_array[$i]);
                $str_in = array_filter(explode(" ", $file_array[$i])); //делим строку на элементы массива и удаляем пустые элементы
                $str_in = array_slice($str_in, 0); //переопределяем индексы массива
                for ($j = 0; $j < count($str_in); $j++) {
                    if (count($str_in) < 3) {
                        array_splice($str_in, count($str_in), 0, ''); // добавляем элемент в массив
                    }
                }
                if ($str_in[0] == "srvcode") {
                    array_push($tran_array, $i);
                }
            }
            if (count($tran_array) > 1) {
                $blok = $tran_array[1] - $tran_array[0];
            } else {
                $blok = count($file_array);
            }

            $file_array = array_chunk($file_array, $blok); //разбиваем файл на блоки

            for ($i = 0; $i < count($tran_array); $i++) {
                for ($j = 0; $j < count($file_array[$i]); $j++) {

                    $file_array[$i][$j] = trim($file_array[$i][$j]);
                    $str_in = array_filter(explode(" ", $file_array[$i][$j])); //делим строку на элементы массива и удаляем пустые элементы
                    $str_in = array_slice($str_in, 0); //переопределяем индексы массива

                    for ($k = 0; $k < count($str_in); $k++) {
                        if (count($str_in) < 3) {
                            array_splice($str_in, count($str_in), 0, ''); // добавляем элемент в массив
                        }
                    }
                    if ($str_in[0] == 'date') {
                        $date = $str_in[2];
                        $datef = substr($str_in[2], 4, 2) . substr($str_in[2], 6, 2);
                        $dateftn = substr($str_in[2], 6, 2) . substr($str_in[2], 4, 2);
                    }
                    $str_in[2] = substr($str_in[2], 1);
                    $str_in[2] = substr($str_in[2], 0, -1);



                    if ($str_in[2] == "TAR_TTC" || $str_in[2] == "TAR_TTCIN") {
                        if ($str_in[0] == "numschet") {
                            $a_TTC = tattelekom($file_array[$i], $dirnameout);
                            array_push($arr_TTC, $a_TTC);
                            $flag_tattelekom = true;
                        }
                    } elseif ($str_in[2] == "TAR_TKO" || $str_in[2] == "TAR_TKOIN" || $str_in[2] == "TAR_TKOTB") {
                        if ($str_in[0] == "numschet") {
                            tnpko($file_array[$i], $dirnameout, $dateftn);
                        }
                    } elseif ($str_in[2] == "TAR_TLS" || $str_in[2] == 'TAR_TLSIN' || $str_in[2] == "TAR_TLSTB") {
                        if ($str_in[0] == "numschet") {
                            teleset($file_array[$i], $dirnameout, $dateftn);
                        }
                    } elseif ($str_in[2] == "TAR_TLSCH" || $str_in[2] == "TAR_TCHIN" || $str_in[2] == "TAR_TCHTB") {
                        if ($str_in[0] == "numschet") {
                            teleset($file_array[$i], $dirnameout, $dateftn);
                        }
                    } elseif ($str_in[2] == 'TAR_TBTIN' || $str_in[2] == 'TAR_TBT' || $str_in[2] == 'TAR_TBTTB') {
                        if ($str_in[0] == "numschet") {
                            tvt($file_array[$i], $dirnameout, $datef);
                        }
                    } elseif ($str_in[2] == "TAR_GKH") {
                        if ($str_in[0] == "numschet") {
                            $a_GKH = gkh($file_array[$i], $dirnameout);
                            array_push($arr_GKH, $a_GKH);
                            $flag_gkh = true;
                        }
                    }elseif ($str_in[2] =="TAR_GASSH") {
                        if ($str_in[0] == "numschet") {
                            $tran = gas($file_array[$i], $dirnameout, $dirnamein, $filename);

                            if ($tran == 1) {
                                $file_array[$i][$j + 1] = "resdoc = 5";
                                //print_r($file_array);
                            }

                            //$file_array[$i][$j + 1];
                        }
                    } elseif ($str_in[2] == "TAR_ENRGO") {
                        if ($str_in[0] == "numschet") {
                            $a_ENRGO = energo($file_array[$i], $dirnameout); //energo параметр , count($tran_array)
                            array_push($arr_ENRGO, $a_ENRGO);
                            $flag_energo = true;
                        }
                    }
                }
            }
                $filenameout = $dirnamein . "/копия_".$filename;
                $fp = fopen($filenameout, "x"); // Открываем файл в режиме записи
if ($fp) {
    $write = fwrite($fp, $S1."\r\n");
    $write = fwrite($fp, $S2."\r\n");
    for ($i = 0; $i < count($tran_array); $i++) {
        $str = implode("\r\n", $file_array[$i]);
        $write = fwrite($fp, $str); // Запись в файл заголовка объединенной пачки
    }
}

        }
    }
}
if ($flag_tattelekom == true) {
    $arr_TTC = array_slice($arr_TTC, 0);
    tattelekom2($dirnameout, $arr_TTC);
}

    $arr_GKH = array_slice($arr_GKH, 0);
    gkh2($dirnameout, $arr_GKH);

if ($flag_energo = true) {
    $arr_ENRGO = array_slice($arr_ENRGO, 0); //energo
    energo2($dirnameout, $arr_ENRGO); // параметр , count($tran_array)
}


fclose($fp);
closedir($handle);

if ($handle = opendir($dirnameout)) {
    while (false !== ($filename = readdir($handle))) {
        if ($filename != "." && $filename != "..") {
            $file = $filename;
            $GZ = substr($filename, 0, 2);
            $bez_rashir = substr($filename, 0, -4);
            if ($GZ == "GZ") {
                $archive = new PclZip($dirnameout . '/' . $bez_rashir . '.arj');
                $archive->add($dirnameout . '/' . $file, PCLZIP_OPT_REMOVE_PATH, $dirnameout . '/');
                unlink($dirnameout . '/' . $file);
            }
            $GKH = substr($filename, 0, 3);
            $File_GKH = substr($filename, 3);
            if ($GKH == "GKH") {
                $filenameout1 = $dirnameout . '/' . $filename;
                $filenameout2 = $dirnameout . '/' . $File_GKH;
                rename($filenameout1, $filenameout2);
            }
        }
    }
}
closedir($handle);
?>