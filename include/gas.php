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
        "�������������� ����(�����)", "�������������� ����(����)", "����������� ����", "����������� ����", "������������ ����",
        "������������ ����", "������������ ����", "������ ����", "����������", "������������� ����(�����)", "������������� ����(����)",
        "������������ ����", "����������� ����", "���������� ����", "����������� ����", "���������� ����", "����������� ����",
        "��������� ����(�����)", "������������� ����", "��������� ����", "��������� ����", "��������� ����", "���������� ����",
        "����������� ����", "������������� ����", "������������ ����", "��������������� ����", "��������������� ����(�����)",
        "������-���������� ����", "���������� ����", "����������� ����", "���������� ����", "���� '�����'", "���� '��������'", "�������� ����",
        "������������� ����(�����)", "������������� ����(����)", "������������ ����", "������������ ����", "�������� ����",
        "������������� ����(�����)", "������������� ����(����)", "�������������� ����", "���������� ����", "���������� ����",
        "������������� ����", "����������� ����", "�-���������� ����", "��������� ����", "����������� ����", "������������ ��",
        "����������� ����", "��������� ����", "�-������� ����", "���������� ����", "���������� ����(�����)", "���������� ����(����)",
        "������������ ����", "���������� ����", "������������ ����", "����������� ����", "�������� ����", "������������� ����",
        "��������� ����(����)", "��������� ��", "������� ������", "���������� ������", "���������������� ��", "�������������� ��",
        "�������������� ��"
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
                array("Dat_opl", "D", 8), // ���� ������
                array("shki", "C", 28), // �����-��� ��������� � ���������
                array("Nls", "N", 10, 0), // ����� �������� ����� �������� � �������
                array("Adr", "C", 40), // ����� ��������
                array("Sgaz", "N", 8, 2), // ����� ������ �� ��� ��� �����-����
                array("Stob", "N", 8, 2), // ����� ������ �� ��������������� ��� �����-����
                array("Pok_zn", "N", 12, 3), // ������� ��������� ��������, ����������� ��������� ��� ������ ���������
                array("Pok_dat", "D", 8) // ���� ��������� ��������, ����������� ��������� ��� ������ ���������
    );

    for ($i = 0; $i < count($file_array1); $i++) {
        $file_array1[$i] = trim($file_array1[$i]);
        $file_array[$i] = array_filter(explode(" ", $file_array1[$i])); //����� ������ �� �������� ������� � ������� ������ ��������
        $file_array[$i] = array_slice($file_array[$i], 0); //�������������� ������� �������

        for ($j = 0; $j < count($file_array[$i]); $j++) {
            if (count($file_array[$i]) < 3) {
                array_splice($file_array[$i], count($file_array[$i]), 0, ''); // ��������� ������� � ������
            }
        }

        if ($file_array[$i][0] == "date") { //���� ������
            $date = $file_array[$i][2];
        }elseif ($file_array[$i][0] == "lschet") { //�����-��� ��������� � ���������
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $shki = $file_array[$i][2];
                $nls = substr($shki, 4, 9);// ������� ����
                $koduslugi = substr($shki, 2, 2);// ��� ������
                //�������� ����������� �����
                $shki_bezsumm = substr($shki, 0, -1);
                $shki_controlsumm = substr($shki, -1);
                $contrl_summ = get_control_digit($shki_bezsumm);
                if ($contrl_summ == $shki_controlsumm && strlen($shki) == 28) {
                    //echo "��������";
                } else {
                    $fp = fopen($dirnameout . "/������! #$tran# ����������� ����� �������.txt", "w+"); // ��������� ���� � ������ ������
                    $test = fwrite($fp, "������ � ����������: $tran \r\n"); // ������ � ����
                    return 1;
                }
        }elseif ($file_array[$i][0] == "amount") { //�����
            $summaoplaty = $file_array[$i][2];
            if (strlen($summaoplaty) == 1) {
                $summaoplatyrub = '0.0' . substr($summaoplaty, -2); //����� ������ � ������
            } else {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.' . substr($summaoplaty, -2); //����� ������ � ������
            }
        }elseif ($file_array[$i][0] == "tran") { //����� ����������
            $file_array1[$i] = substr($file_array1[$i], 11);
            $file_array1[$i] = substr($file_array1[$i], 0, -1);
            $tran = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "nazn") {
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nazn = explode(";", $file_array[$i][2]);

            /*for ($j = 0; $j < count($nazn); $j++) {
                if (count($nazn) < 3) {
                    array_splice($file_array[$i], count($file_array[$i]), 0, ''); // ��������� ������� � ������
                }
            }*/
                $keks_num = $nazn[3];
            $pok_zn = $nazn[2]; //��������� ��������
            $pok_dat = $nazn[4]; //���� ������ ��������� �������
            if ($pok_dat != "00000000") {
                $pok_dat = "20" . substr($pok_dat, -2, 2) . substr($pok_dat, 3, 2) . substr($pok_dat, 0, 2);
            }
            $pok_znformat = substr($pok_zn, 0, -3) . '.' . substr($pok_zn, -3); //����� ������ ��������� ��������
        }
    }

    if ($koduslugi == "33") {
        $sgaz = $summaoplaty;
        if (strlen($summaoplaty) == 1) {
            $sgazrub = '0.0' . substr($sgaz, -2); //����� ������ � ������
        } else {
            $sgazrub = substr($sgaz, 0, -2) . '.' . substr($sgaz, -2); //����� ������ � ������
        }
    } elseif ($koduslugi == "35") {
        $stob = $summaoplaty;
        if (strlen($summaoplaty) == 1) {
            $stobrub = '0.0' . substr($stob, -2); //����� ������ � ������
        } else {
            $stobrub = substr($stob, 0, -2) . '.' . substr($stob, -2); //����� ������ � ������
        }
    }


    $str_out = array($date, $shki, $nls, "", $sgazrub, $stobrub, $pok_zn, $pok_dat); //������ � �������� ����

    if (strlen($keks_num) == 1) {
        $keks_num_0 = "0" . $keks_num;
    } else {
        $keks_num_0 = $keks_num;
    }
    $fl=$namefile . $keks2[$keks_num-1] . $keks_num_0 . "E" . substr($date, -2);
    $filenameout = $dirnameout . '/' . $fl; //��� ��������� �����

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

    $fp = fopen($filenameout . ".txt", "w+"); // ��������� ���� � ������ ������
    $test = fwrite($fp, "      ���������������� ��������\r\n"); // ������ � ����
    $test = fwrite($fp, "������� NN:\r\n"); // ������ � ����
    $test = fwrite($fp, "�� ����: ��������� '���� ���������' �8610 ����\r\n"); // ������ � ����
    $test = fwrite($fp, "\r\n"); // ������ � ����
    $test = fwrite($fp, "����:         " . substr($date, -2) . "." . substr($date, 4, 2) . "." . substr($date, 0, 4) . "\r\n"); // ������ � ����
    $test = fwrite($fp, "\r\n"); // ������ � ����
    $test = fwrite($fp, "��� �����:   " . $fl . ".dbf\r\n"); // ������ � ����     
    $test = fwrite($fp, "���������� �������: " . dbase_numrecords($db) . "\r\n"); // ������ � ����
    $test = fwrite($fp, "�����:            $summa\r\n"); // ������ � ����
    $test = fwrite($fp, "�������:  ��������  ________________\r\n"); // ������ � ����
    $test = fwrite($fp, "          ��������� ________________ \r\n"); // ������ � ����
    $test = fwrite($fp, "\r\n"); // ������ � ����
    $test = fwrite($fp, "������:   ��������  ________________ \r\n"); // ������ � ����
    $test = fwrite($fp, "          ��������� ________________ \r\n"); // ������ � ����
    fclose($fp);

    dbase_close($db);
}

//} else
/* if ($summaoplaty != substr($shki, 13, 8)) {
  $fp = fopen($dirnameout . "/������! ����� �� ���������.txt", "w+"); // ��������� ���� � ������ ������
  $test = fwrite($fp, "������! ���!\r\n"); // ������ � ����
  $test = fwrite($fp, "�����, ��������� ������������ �� ��������� � ������ �� �����-����.\r\n"); // ������ � ����
  $test = fwrite($fp, "���� ������: " . substr($date, -2) . "." . substr($date, 4, 2) . "." . substr($date, 0, 4) . "\r\n"); // ������ � ����
  $test = fwrite($fp, "����� ����������: " . $tran . "\r\n"); // ������ � ����
  $test = fwrite($fp, "=============================================\r\n"); // ������ � ����
  dbase_close($db);
  } */
?>