<?php 
    /*header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename=contacts.csv');

    $list = array
    (
    "เกรียงไกร,ลิ้นกับฟัน,,Norway",
    "Glenn,Quagmire,Oslo,Norway",
    );

    $fileName2 = 'contacts.csv';
    $file = fopen("contacts.csv","w");

    foreach ($list as $line)
      {
      fputcsv($file,explode(',',$line));
      }

    fclose($file);

    echo file_get_contents("contacts.csv");*/

    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename=Customers_Export.csv');

    $csv = "record1".",record2,record3\n" .
        "ทดสอบ,record2,record3\n" .
        "record1,ภาษาไทย,record3\n" .
        "record1,record2,วันละคำ\n";

    echo chr(255) . chr(254);
    echo mb_convert_encoding($csv, 'UTF-16LE', 'UTF-8');
    exit;
?>