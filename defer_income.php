<?php
require_once('../data/kreang_connection.php');

//if ( $conn = Connection::databaseConnect() ) {
if(true){
    $conn = Connection::databaseConnect();
    $sql1_1 = "SELECT DISTINCT
Count(cpa.RECEIPT_NO) AS `Refs No.`,
gn.`NAME` AS `Group Name`,
rct.NAME_EN AS `Course Type`,
cos.`NAME` AS `Course Name`,
CONCAT(gn.START_DATE,'-',gn.END_DATE) AS `start-finish`,
GROUP_CONCAT(DAY(gs.DATE) SEPARATOR ', '),
rcs.TIME,
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
LEFT JOIN ref_classroom_schedule AS rcs ON cosbook.CLASSROOM_SCHEDULE_ID = rcs.ID
LEFT JOIN group_schedule AS gs ON cosbook.GROUP_SCHEDULE_ID = gs.ID
GROUP BY
cpa.RECEIPT_NO
ORDER BY
cpa.RECEIPT_NO ASC";
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
CPA.RECEIPT_NO,
Count(CB.ID) AS CLASS_PER_MONTH,
YEAR(CB.DATE),
MONTH(CB.DATE),
CB.GROUP_ID
FROM
client_payment_amount AS CPA
LEFT JOIN client AS C ON CPA.CLIENT_ID = C.ID
LEFT JOIN group_register AS GR ON GR.CLIENT_ID = C.ID
LEFT JOIN group_name AS GN ON GR.GROUP_ID = GN.ID
LEFT JOIN classroom_book AS CB ON CB.GROUP_ID = GN.ID
GROUP BY
CPA.RECEIPT_NO,
CB.GROUP_ID,
YEAR(CB.DATE),
MONTH(CB.DATE)
ORDER BY
CPA.RECEIPT_NO ASC";
    $sql3 = "SELECT DISTINCT
CONCAT(MONTH(CB.DATE),'_',YEAR(CB.DATE)),
MONTH(CB.DATE),
YEAR(CB.DATE)
FROM
client_payment_amount AS CPA
LEFT JOIN client AS C ON CPA.CLIENT_ID = C.	ID
LEFT JOIN group_register AS GR ON GR.CLIENT_ID = C.ID
LEFT JOIN group_name AS GN ON GR.GROUP_ID = GN.ID
INNER JOIN classroom_book AS CB ON CB.GROUP_ID = GN.ID
GROUP BY
CPA.RECEIPT_NO,
CB.GROUP_ID,
YEAR(CB.DATE),
MONTH(CB.DATE)
ORDER BY
CB.DATE";
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
                $result3 = mysqli_query($conn,$sql3);

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
                $objPHPExcel->getActiveSheet()->mergeCells('N1:O1');

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
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,'Bought Forward');
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,'Lesson');
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,'Bath');

                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $styleArray = array(
                    'borders' => array(
                        'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $styleVer = array(
                    'borders' => array(
                        'vertical' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $boderBot= array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $BStyle = array(
                    'borders' => array(
                        'vertical' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );

                $objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A2:AM2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle("A1:AM1")->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle("A2:AM2")->applyFromArray($style);
                $objPHPExcel->getActiveSheet()->getStyle('N3:AM3')->applyFromArray($styleVer);


                $monthAry = ['N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM'];
                $colN = 15;
                $arrX = [];
//                print_r($result3->num_rows);
//                exit;
                while($row_data = $result3->fetch_array(MYSQLI_NUM)) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 1, $row_data[1]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN+1, 1, $row_data[2]);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 2, 'Lesson');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN+1, 2, 'Bath');
                    $arrX[$row_data[0]]=$monthAry[$colN-13];
                    $arrX[$row_data[0].'_2']=$monthAry[$colN-13+1];
                    $colN++;
                    $colN++;
                }

//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 1, $row_data[1]);
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN+1, 1, $row_data[2]);

                $str = $monthAry[$colN-13].'1:'.$monthAry[$colN-13+1].'1';
                $objPHPExcel->getActiveSheet()->mergeCells($str);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 1, 'Selected Month');
//                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 1, $row_data[1]);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 2, 'Lesson');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN+1, 2, 'Bath');
                $colN++;
                $colN++;
                $str = $monthAry[$colN-13].'1:'.$monthAry[$colN-13+1].'1';
                $objPHPExcel->getActiveSheet()->mergeCells($str);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 1, 'Remaining');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, 2, 'Lesson');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN+1, 2, 'Bath');
//                print_r($arrX);
//                exit;
                $dateX = date('n_Y');
                while($row = $result->fetch_array(MYSQLI_NUM)){
                    $rowCount++;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowNum)->getStyle('A'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row['1'])->getStyle('B'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$row['2'])->getStyle('C'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row['3'])->getStyle('D'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'')->getStyle('E'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'')->getStyle('F'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'')->getStyle('G'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$row['4'])->getStyle('H'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$row['5'])->getStyle('I'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,$row['6'])->getStyle('J'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,$row['7'])->getStyle('K'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,$row['8'])->getStyle('L'.$rowCount)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,$row['9'])->getStyle('M'.$rowCount)->applyFromArray($styleArray);
                    /*$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rowNum);
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
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,$row['9']);*/

                    $monthLoop = 0;
                    $flagRemain = false;
                    $sumLesson=0;$sumAmount=0;
                    $sumBoughtLesson=0;$sumBoughtAmount=0;
                    while($row2 = $result2->fetch_array(MYSQLI_NUM)) {
                        if($row2['0']==$row['6']&&$row2['4']==$row['10']){
                            $objPHPExcel->getActiveSheet()->SetCellValue($arrX[$row2['3'].'_'.$row2['2']].$rowCount,$row2['1']);
                            $objPHPExcel->getActiveSheet()->SetCellValue($arrX[$row2['3'].'_'.$row2['2'].'_2'].$rowCount,($row['9']*$row2['1']));
                            if($dateX==$row2['3'].'_'.$row2['2']){
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN-2, $rowCount, $row2['1']);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN+1-2, $rowCount, ($row['9']*$row2['1']));
//                                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount)->applyFromArray($styleArray);
                                $flagRemain = true;
                            }
                            if($flagRemain){
                                $sumLesson+=$row2['1'];
                                $sumAmount+=($row['9']*$row2['1']);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN, $rowCount, $sumLesson);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colN+1, $rowCount, $sumAmount);
                            }else{
                                $sumBoughtLesson+=$row2['1'];
                                $sumBoughtAmount+=($row['9']*$row2['1']);
                                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $sumBoughtLesson);
                                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $sumBoughtAmount);
                            }
                        }
                    }
                    $objPHPExcel->getActiveSheet()->getStyle('N'.$rowCount.':AM'.$rowCount)->applyFromArray($styleVer);
                    $objPHPExcel->getActiveSheet()->getStyle('N'.$rowCount.':AM'.$rowCount)->applyFromArray($styleArray);
                    mysqli_data_seek($result2, 0);
                    $rowNum++;
                }

                foreach(range('A','Z') as $columnID) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
                }
                foreach(range('AA','AZ') as $columnID) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
                }
                $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':AM'.$rowCount)->applyFromArray($boderBot);

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
?>===