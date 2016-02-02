<?php 
    

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
    echo "<a href=$fileName2>Download</a>";
?>