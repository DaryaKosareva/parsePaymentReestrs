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
                array("DOPL", "D", 8), // ���� ������� -> ��.��.����
                array("SUMOPL", "N", 8, 2), // ����� ������� -> ����.��
                array("NTA", "N", 10, 0), // ������� ����
                array("NKV", "N", 15, 0), // ����� ���������      
                array("VID_OP", "N", 6, 0), // ��� �������� -> 010 - �������, 016 - ��������       
                array("OS", "N", 10, 0), // ����� ������� -> 8610
                array("KASSA", "N", 5, 0) // ���. ��������� (�������) 
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
        if ($file_array[$i][0] == "date") {// ���� �������
            $dat_opl = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "amount") { // ����� �������
            $summaoplaty = $file_array[$i][2];  //����� � ��������
            if (strlen($summaoplaty) == 1) {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.0' . substr($summaoplaty, -2); //����� � ������
            } else {
                $summaoplatyrub = substr($summaoplaty, 0, -2) . '.' . substr($summaoplaty, -2); //����� � ������
            }
        } elseif ($file_array[$i][0] == "lschet") { //������� ����
            $file_array[$i][2] = substr($file_array[$i][2], 1);
            $file_array[$i][2] = substr($file_array[$i][2], 0, -1);
            $nta = $file_array[$i][2];
        } elseif ($file_array[$i][0] == "tran") { //����� ���������
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
        } elseif ($file_array[$i][0] == "termnum") { //���. ��������� (�������) 
            $termnum = ""; //$file_array[$i][2];
        }
    }

    $str_exp_out = array($dat_opl, $summaoplatyrub, $nta, $nkv, $vid_op, "8610", $termnum); //������� ������ �� �����

    $db = dbase_open($filenameout, 2);

    if (!$db)
        $db = dbase_create($filenameout, $def);

    $ret = dbase_add_record($db, $str_exp_out);

    if ($ret == false)
        print "<strong>Error _ add!</strong>";

    dbase_close($db);
}

?>