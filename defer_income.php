<?php
require_once('../data/kreang_connection.php');

//if ( $conn = Connection::databaseConnect() ) {
if(true){
    $conn = Connection::databaseConnect();
    $sql1 = "SELECT DISTINCT
Count(cpa.RECEIPT_NO) AS `Refs No.`,
gn.`NAME` AS `Group Name`,
rct.NAME_EN AS `Course Type`,
cos.`NAME` AS `Course Name`,
CONCAT(cli.PREFIX_NAME,cli.FIRST_NAME_EN,' ',cli.LAST_NAME_EN) AS `Student Name`,
cpa.PAYMENT_DATE AS Date,
cpa.RECEIPT_NO AS `Ref No.`,
cpa.PAYMENT_PRICE AS Amount,
gn.LESSON_TOTAL AS `Total Lesson`,
(cpa.PAYMENT_PRICE/gn.LESSON_TOTAL) AS `Bath/Lesson`,
gn.ID AS Group_ID
FROM
client_payment_amount AS cpa
LEFT JOIN client AS cli ON cpa.CLIENT_ID = cli.ID
LEFT JOIN group_register AS gr ON gr.CLIENT_ID = cli.ID
LEFT JOIN group_name AS gn ON gr.GROUP_ID = gn.ID
LEFT JOIN course AS cos ON gr.COURSE_ID = cos.ID
INNER JOIN ref_course_type AS rct ON gr.COURSE_TYPE_ID = rct.ID
LEFT JOIN classroom_book AS cosbook ON cosbook.GROUP_ID = gn.ID
GROUP BY
cpa.RECEIPT_NO
ORDER BY
cpa.RECEIPT_NO ASC ";
    $sql2 = "SELECT
client_payment_amount.RECEIPT_NO,
Count(classroom_book.ID) AS CLASS_PER_MONTH,
classroom_book.GROUP_ID,
YEAR(classroom_book.DATE),
MONTH(classroom_book.DATE)
FROM
client_payment_amount
INNER JOIN client ON client_payment_amount.CLIENT_ID = client.ID
INNER JOIN group_register ON group_register.CLIENT_ID = client.ID
INNER JOIN classroom_book ON classroom_book.GROUP_ID = group_register.GROUP_ID
GROUP BY
classroom_book.GROUP_ID,
YEAR(classroom_book.DATE),
MONTH(classroom_book.DATE)
ORDER BY
client_payment_amount.RECEIPT_NO,
classroom_book.DATE";
//    if ($stmt = $conn -> query($select_sql)) {
    if(true){
        $first_name_en = 'Achiraya';
//            if($stmt->bind_param('s', $first_name_en)){
        if(true){
//            if($stmt->execute()){
            if(true){
//                $stmt2 = $conn -> prepare($sql2);
//                $result = $conn->query($sql2);

                $result = mysqli_query($conn, $sql1);
                $result2 = mysqli_query($conn,$sql2);
//                print_r($result);
//                print_r($result2);
//                exit;
                require_once('../assets/plugins/PHPExcel/Classes/PHPExcel.php');
                /*$result = $stmt->get_result();
                while ($row = $result->fetch_array(MYSQLI_NUM)) {
                    print_r($row);
                    echo '<br>';
                }*/
                // Instantiate a new PHPExcel object
                $objPHPExcel = new PHPExcel();
                // Set the active Excel worksheet to sheet 0
                $objPHPExcel->setActiveSheetIndex(0);
                // Initialise the Excel row number
                $rowCount = 1;
                $rowNum = 1;



//                $result = $stmt->get_result();
                //mergeRow
                $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
                $objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
                $objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
                $objPHPExcel->getActiveSheet()->mergeCells('D1:D2');
                $objPHPExcel->getActiveSheet()->mergeCells('H1:H2');
                $objPHPExcel->getActiveSheet()->mergeCells('K1:K2');
                $objPHPExcel->getActiveSheet()->mergeCells('L1:L2');
                $objPHPExcel->getActiveSheet()->mergeCells('M1:M2');
                //mergeColumn
                $objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
                $objPHPExcel->getActiveSheet()->mergeCells('I1:J1');

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'Group Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Course Type');
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Course Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'Students Attendance');
                $objPHPExcel->getActiveSheet()->SetCellValue('E2','Starts-Finish');
                $objPHPExcel->getActiveSheet()->SetCellValue('F2','Day');
                $objPHPExcel->getActiveSheet()->SetCellValue('G2','Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'Student Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,'Receipt');
                $objPHPExcel->getActiveSheet()->SetCellValue('I2','Date');
                $objPHPExcel->getActiveSheet()->SetCellValue('J2','Ref. No');
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,'Amount');
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,'Lesson');
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,'Bath/Lesson');
                $rowCount++;
                while($row = $result->fetch_array(MYSQLI_NUM)){
                    $rowCount++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowNum);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row['1']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$row['2']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row['3']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'');
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'');
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$row['4']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$row['5']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,$row['6']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,$row['7']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,$row['8']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,$row['9']);
                    $monthAry = ['N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM'];
                    $monthLoop = 0;
                    while($row2 = $result2->fetch_array(MYSQLI_NUM)) {

                        if($row2['0']==$row['6']&&$row2['2']==$row['10']){
                            $objPHPExcel->getActiveSheet()->SetCellValue($monthAry[$monthLoop].$rowCount,$row2['1']);
                            $objPHPExcel->getActiveSheet()->SetCellValue($monthAry[$monthLoop+1].$rowCount,($row['9']*$row2['1']));
                            $monthLoop++;
                            $monthLoop++;
                        }

                    }
                    mysqli_data_seek($result2, 0);
                    $rowNum++;
                }

                foreach(range('A','M') as $columnID) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
                }

                // Redirect output to a client’s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="defer_income.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');



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