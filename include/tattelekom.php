<?php

function tattelekom($file_array1, $dirnameout) {
    for ($i = 0; $i < count($file_array1); $i++) {
        $file_array1[$i] = trim($file_array1[$i]);
        $file_array[$i] = array_filter(explode(" ", $file_array1[$i])); //����� ������ �� �������� ������� � ������� ������ ��������
        $file_array[$i] = array_slice($file_array[$i], 0); //�������������� ������� �������

        for ($j = 0; $j < count($file_array[$i]); $j++) {
            if (count($file_array[$i]) < 3) {
                array_splice($file_array[$i], count($file_array[$i]), 0, ''); // ��������� ������� � ������ �� 3�
            }
        }
        if ($file_array[$i][0] == "date") { //���� ������ 
            $date = $file_array[$i][2]; //��������
            $dateformat = substr($date, 6, 2) . '.' . substr($date, 4, 2) . '.' . substr($date, 0, 4); //����� ������ ���� �� ��.��.����
        } elseif ($file_array[$i][0] == "amount") { //����� ��������
            $summaoplaty = $file_array[$i][2]; //����� � ��������
        } elseif ($file_array[$i][0] == "lschet") { //����� ��������, �������� �����
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nls = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "tran") { //����� ���������
            $tran = $file_array[$i][2];
        }
    }

    echo $filenameout = $dirnameout . '/' . "619_00_001_" . $date . '_4999_100_' . "XXXX" . ".txt";

    $str_exp_out = array($dateformat, "", "", $summaoplaty, $nls, $tran); //������� ������ �� �����


    $str_out = implode("|", $str_exp_out) . "\r\n";
    //echo '<br>';

    $fp = fopen($filenameout, "a"); // ��������� ���� � ������ ������
    $test = fwrite($fp, $str_out); // ������ � ����

    fclose($fp);
    return array("$summaoplaty", "$date");
}

function tattelekom2($dirnameout, $arr) { //��� ������ �������� ����� � �������� �����  
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