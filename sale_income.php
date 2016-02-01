<?php 
    require_once('../data/kreang_connection.php');
    ob_start();
    header("content-type:application/csv;charset=UTF-8");
    header("Content-Disposition:attachment;filename=contacts.csv");

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


    $filName = "customer2.csv";
    $objWrite = fopen("customer2.csv", "w");
    fwrite($objWrite, "\"C001\",เกรียงไกร ลิ้นกับฟัน\",\"win.weerachai@thaicreate.com\",\"TH\",\"1000000\",\"600000\" \n");
    fwrite($objWrite, "\"C002\",\"John  Smith\",\"john.smith@thaicreate.com\",\"EN\",\"2000000\",\"800000\" \n");
    fwrite($objWrite, "\"C003\",\"Jame Born\",\"jame.born@thaicreate.com\",\"US\",\"3000000\",\"600000\" \n");
    fwrite($objWrite, "\"C004\",\"Chalee Angel\",\"chalee.angel@thaicreate.com\",\"US\",\"4000000\",\"100000\" \n");
    fclose($objWrite);
    echo "<br>Generate CSV Done.<br><a href=$filName>Download</a>";
    ob_end_flush();










    if ( $conn = Connection::databaseConnect() ) {
        $select_sql = "SELECT cl.ID, CL.FIRST_NAME_EN FROM client AS cl WHERE FIRST_NAME_EN  LIKE ?";
        if ($stmt = $conn -> prepare($select_sql)) {
             $first_name_en = 'Achiraya';
            if($stmt->bind_param('s', $first_name_en)){
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_array(MYSQLI_NUM)) {
                        echo 'ID = '.$row[0];
                        echo '<br>';
                        echo 'first_name_en = '.$row[1];
                    }
                }else {
                    echo $error_database_statement_execute . ' (errcode: ' . $stmt->errno . ', detail: ' . $stmt->error . ')';
                }
            }else {
                echo $error_database_statement_bind . ' (errcode: ' . $stmt->errno . ', detail: ' . $stmt->error . ')';
            }
            $stmt -> close();
        }else {
            echo $error_database_statement_prepare . ' (errcode: ' . $conn->errno . ', detail: ' . $conn->error . ')';
        }
        $conn->close();
    }else {
        echo $error_database_connection;
    }
?>