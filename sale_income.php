<?php
require_once('../data/kreang_connection.php');

//if ( $conn = Connection::databaseConnect() ) {
if(true){
    $conn = Connection::databaseConnect();
    $sql1 = "SELECT
CPA.PAYMENT_DATE,
CPA.RECEIPT_NO,
C.CLIENT_NO,
CONCAT(C.PREFIX_NAME, C.FIRST_NAME_EN, ' ', C.LAST_NAME_EN ) AS CLIENT_NAME,
GN.`NAME` AS GROUP_NAME,
COT.NAME_EN AS COURSE_TYPE,
CO.`NAME` AS COURSE_NAME,
GN.START_DATE AS PERIOD_FROM,
GN.END_DATE AS PERIOD_TO,
COL.NAME_EN AS COURSE_LEVEL,
CP.TOTAL_LESSON AS LESSON,
CP.COURSE_PRICE_TOTAL AS COURSE_PRICE_TOTAL,
CPAD.DISCOUNT_PRICE AS EXTRA_DISCOUNT,
CONCAT(ECPAD.PREFIX_NAME, ECPAD.FIRST_NAME_EN, ' ', ECPAD.LAST_NAME_EN ) AS EXTRA_DISCOUNT_BY_NAME,
CONCAT(GROUP_CONCAT(DISTINCT s.NAME_EN SEPARATOR ', '),' x',SUM(CPS.STOCK_AMOUNT)) AS `TEST`,
GROUP_CONCAT(S.NAME_EN SEPARATOR ', ') AS STOCK_NAME,
Sum(CPS.STOCK_AMOUNT) AS STOCK_AMONT,
Sum(CPS.STOCK_PRICE_TOTAL) AS STOCK_PRICE_TOTAL,
CP.TOTAL_PRICE AS GRAND_TOTAL,
PT.NAME_EN AS TYPE_OF_PAYMENT,
CONCAT(E.PREFIX_NAME, E.FIRST_NAME_EN, ' ', E.LAST_NAME_EN ) AS CONSULT_NAME,
GROUP_CONCAT(PRO.NAME_EN SEPARATOR ', ') AS PROMOTION_NAME,
CC.NAME_EN AS CONTACT_CHANNEL,
C.CONTACT_CHANNEL_DETAIL,
MS.NAME_EN AS MARKETING_SOURCE,
C.MARKETING_SOURCE_DETAIL,
rct.NAME_EN AS Location
FROM CLIENT_PAYMENT_AMOUNT CPA
INNER JOIN CLIENT C ON C.ID = CPA.CLIENT_ID
INNER JOIN EMPLOYEE E ON C.SALES_ID = E.ID
INNER JOIN CLIENT_PAYMENT CP ON CP.ID = CPA.CLIENT_PAYMENT_ID
INNER JOIN REF_PAYMENT_TYPE PT ON CPA.PAYMENT_TYPE_ID = PT.ID
LEFT JOIN GROUP_NAME GN ON CP.GROUP_ID = GN.ID
LEFT JOIN REF_COURSE_TYPE COT ON COT.ID = CP.COURSE_TYPE_ID
LEFT JOIN COURSE CO ON CO.ID = CP.COURSE_ID
LEFT JOIN CLIENT_PAYMENT_STOCK CPS ON CPS.CLIENT_PAYMENT_ID = CP.ID
LEFT JOIN CLIENT_PAYMENT_PROMOTION CPP ON CPP.CLIENT_PAYMENT_ID = CP.ID
LEFT JOIN PROMOTION PRO ON CPP.PROMOTION_ID = PRO.ID
LEFT JOIN STOCK S ON CPS.STOCK_ID = S.ID
LEFT JOIN REF_COURSE_LEVEL COL ON CO.COURSE_LEVEL_ID = COL.ID
LEFT JOIN CLIENT_PAYMENT_ADDITION CPAD ON CP.ID = CPAD.CLIENT_PAYMENT_ID AND CPAD.ACTIVE = 1 AND CPAD.PAYMENT_ADDITION_TYPE_ID = 9999
LEFT JOIN EMPLOYEE ECPAD ON CPAD.MODIFY_BY = ECPAD.ID
LEFT JOIN REF_CONTACT_CHANNEL CC ON C.CONTACT_CHANNEL_ID = CC.ID
LEFT JOIN REF_MARKETING_SOURCE MS ON C.MARKETING_SOURCE_ID = MS.ID
LEFT JOIN ref_course_type AS rct ON GN.COURSE_TYPE_ID = rct.ID
GROUP BY CPA.ID";
    $sql2 = "SELECT
ccpa.PAYMENT_DATE AS `Date`,
ccpa.RECEIPT_NO AS `No.`,
cc.NAME_EN AS `Name`,
gn.`NAME` AS `Group Name`,
co.`NAME` AS `Course Name`,
rct.NAME_EN AS `Course Type`,
gn.START_DATE AS `Period From`,
gn.END_DATE AS `Period To`,
rcl.NAME_EN AS `Level`,
ccp.TOTAL_LESSON AS Lesson,
ccp.COURSE_PRICE_TOTAL AS Amount,
GROUP_CONCAT(stk.NAME_EN SEPARATOR ' ,') AS `Book Name`,
ccps.STOCK_AMOUNT,
ccps.STOCK_PRICE_TOTAL AS Amount,
ccps.STOCK_PRICE_PER_ITEM,
ccp.TOTAL_PRICE AS `Grand Total`,
ref_payment_type.NAME_EN AS TypeOfPayment,
CONCAT(E.PREFIX_NAME, E.FIRST_NAME_EN, ' ', E.LAST_NAME_EN ) AS `Consult Name`,
pro.NAME_EN AS Promotion,
rct.NAME_EN AS Location
FROM
corporate_client_payment_amount AS ccpa
LEFT JOIN corporate_client_payment AS ccp ON ccpa.CORPORATE_CLIENT_PAYMENT_ID = ccp.ID
LEFT JOIN corporate_client AS cc ON ccpa.CORPORATE_CLIENT_ID = cc.ID
LEFT JOIN group_name AS gn ON ccp.GROUP_ID = gn.ID
LEFT JOIN course AS co ON gn.COURSE_ID = co.ID
LEFT JOIN ref_course_type AS rct ON gn.COURSE_TYPE_ID = rct.ID
LEFT JOIN ref_course_level AS rcl ON co.COURSE_LEVEL_ID = rcl.ID
LEFT JOIN corporate_client_payment_stock AS ccps ON ccps.CORPORATE_CLIENT_PAYMENT_ID = ccp.ID
LEFT JOIN stock AS stk ON ccps.STOCK_ID = stk.ID
LEFT JOIN ref_payment_type ON ccpa.PAYMENT_TYPE_ID = ref_payment_type.ID
LEFT JOIN employee AS E ON gn.TRAINER_ID = E.ID
LEFT JOIN corporate_client_payment_promotion AS ccpp ON ccpp.CORPORATE_CLIENT_PAYMENT_ID = ccp.ID
LEFT JOIN promotion AS pro ON ccpp.PROMOTION_ID = pro.ID
GROUP BY ccpa.ID";
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
                $result2 = mysqli_query($conn, $sql2);
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
                //mergeColumn
                $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
                $objPHPExcel->getActiveSheet()->mergeCells('C1:N1');
                $objPHPExcel->getActiveSheet()->mergeCells('O1:P1');
                $objPHPExcel->getActiveSheet()->mergeCells('E2:I2');
                $objPHPExcel->getActiveSheet()->mergeCells('J2:K2');

                //mergeRow
                $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
                $objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
                $objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
                $objPHPExcel->getActiveSheet()->mergeCells('L2:L3');
                $objPHPExcel->getActiveSheet()->mergeCells('M2:M3');
                $objPHPExcel->getActiveSheet()->mergeCells('N2:N3');
                $objPHPExcel->getActiveSheet()->mergeCells('O2:O3');
                $objPHPExcel->getActiveSheet()->mergeCells('P2:P3');
                $objPHPExcel->getActiveSheet()->mergeCells('Q1:Q3');
                $objPHPExcel->getActiveSheet()->mergeCells('R1:R3');
                $objPHPExcel->getActiveSheet()->mergeCells('S1:S3');
                $objPHPExcel->getActiveSheet()->mergeCells('T1:T3');
                $objPHPExcel->getActiveSheet()->mergeCells('U1:U3');
                $objPHPExcel->getActiveSheet()->mergeCells('V1:V3');

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Recipet');
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Student');
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,'Book');
                $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,'Grand Total(THB)');
                $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount,'Type of payment');
                $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount,'Consultant Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,'Promotion');
                $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,'Contact Channel');
                $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount,'Marketing Source');
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Type');
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Location');
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'Database');
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,'Date');
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,'Level');
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,'Lesson');
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,'Amount (THB)');
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,'Book Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount,'Amount (THB)');
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Date');
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'Client Code');
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'Group Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'Course Type');
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,'Course Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,'Period from');
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,'Period to');
                $rowCount++;

                while ($row = $result->fetch_array(MYSQLI_NUM)) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$row['0']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row['1']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Client');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row['26']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$row['2']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$row['3']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$row['4']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$row['5']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$row['6']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,$row['7']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,$row['8']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,$row['9']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,$row['10']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,$row['11']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,$row['14']);
//                    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,$row['14'].' x '.$row['15']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount,$row['17']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,$row['18']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount,$row['19']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount,$row['20']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,$row['21']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,$row['22']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount,$row['24']);
                    $rowCount++;
                }

                while ($row2 = $result2->fetch_array(MYSQLI_NUM)) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$row2['0']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row2['1']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Corporate');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row2['19']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$row2['2']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$row2['3']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$row2['4']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$row2['5']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,$row2['6']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,$row2['7']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,$row2['8']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,$row2['9']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,$row2['10']);

                    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,$row2['11'].' x '.$row2['12']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount,$row2['14']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,$row2['15']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount,$row2['16']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount,$row2['17']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,$row2['18']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,'');
                    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount,'');
                    $rowCount++;
                }

                foreach(range('A','Z') as $columnID) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
                }

                // Redirect output to a client’s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="sale_income.xls"');
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