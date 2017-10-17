<?php

function teleset($file_array1, $dirnameout, $date) {
    $kvitan = "";
    $nom_op = "";
    $ttt = 0;
    $def =
            array(
                array("DATA", "D", 8), // ���� ������� -> ��.��.����
                array("OC", "N", 6, 0), // ����� ��������� ����� -> 8610
                array("N_KAS", "C", 5), // ����� ������������� ����� -> ����� ���������
                array("NOM_OP", "N", 6, 0), // ���������� ����� �������� � ������������� �����
                array("KATEG", "C", 2), // ��������� ���������� ("�����")
                array("SUMMA", "N", 19, 2), // ����� ������� -> ����.��
                array("TELEFON", "C", 15), // ����� ��������, ����� �������� 
                array("KR_TEL", "C", 1), // 0 ��� 1
                array("KVITAN", "C", 15), // ����� ���������
                array("SROK_OP", "D", 8), // ���� ������ � ��������� ("�����")
                array("TIR_ZAR", "C", 1), // �������� (�� �����, �������� � �.�.)
                array("DAT_OBR", "D", 8), // ���� ��������� -> ������� ����
                array("NAME", "C", 25) // ��� ����������� (����������� ���� ��� �����-����)
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
        if ($file_array[$i][0] == "date") { //���� �������� 
            $dat_opl = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "termnum") { //����� ���������
            $termnum = ""; //$file_array[$i][2];
        } elseif ($file_array[$i][0] == "amount") { //����� ��������
            $summaoplaty = $file_array[$i][2]; //����� � ��������
            if (strlen($summaoplaty) == 1) {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.0' . substr($summaoplaty, -2); //����� � ������
            } else {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.' . substr($summaoplaty, -2); //����� � ������
            }
        } elseif ($file_array[$i][0] == "ident") { //����� ��������, �������� �����
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
                //������� ���� ������� ������ �� ����.
            }
        } elseif ($file_array[$i][0] == "tran") { //����� ���������
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
    $str_exp_out = array($dat_opl, "8610", $termnum, $nom_op, "", $summaoplatyrub, $nls, "0", $tran, "", "", date('Ymd'), ""); //������� ������ �� �����

    $db = dbase_open($filenameout, 2);

    if (!$db)
        $db = dbase_create($filenameout, $def);

    $ret = dbase_add_record($db, $str_exp_out);

    if ($ret == false)
        print "<strong>Error _ add!</strong>";

    dbase_close($db);


    if ($ttt == 1) {
        $fp = fopen($dirnameout . "/������ - �������.txt", "a"); // ��������� ���� � ������ ������
        $test = fwrite($fp, '#� ������� ����� ������# ����: ' . $filenameout . "\r\n"); // ������ � ����
        fclose($fp);
    }
}

?>