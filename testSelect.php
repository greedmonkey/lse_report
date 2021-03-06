<?php 
    require_once('../data/kreang_connection.php');
    if ( $conn = Connection::databaseConnect() ) {
        $select_sql = "SELECT cpa.PAYMENT_DATE, cpa.RECEIPT_NO, c.CLIENT_NO, c.FIRST_NAME_EN, c.MIDDLE_NAME_EN, c.LAST_NAME_EN, gn.NAME as `group_name`, rct.NAME_EN as `course type`, cos.NAME as `course name`, gn.START_DATE as `Period from`, gn.END_DATE as `Period to`, rcoslv.NAME_EN as `level`, cos.LESSON_TOTAL as `lesson`, cpa.PAYMENT_PRICE as `amount`, stk.NAME_EN as `Name Book`, stk.PRICE as `amount` FROM client_payment_amount as cpa  INNER JOIN client AS c ON  cpa.CLIENT_ID = c.ID  INNER JOIN client_payment as cp ON cpa.CLIENT_PAYMENT_ID = cp.ID  INNER JOIN group_name as gn ON cp.GROUP_ID = gn.ID  INNER JOIN ref_course_type as rct ON rct.ID = gn.COURSE_TYPE_ID  INNER JOIN course as cos ON cos.ID = gn.COURSE_ID  INNER JOIN ref_course_level as rcoslv ON rcoslv.ID = cos.COURSE_LEVEL_ID INNER JOIN client_payment_stock as cps ON cp.id = cps.CLIENT_PAYMENT_ID INNER JOIN stock as stk on cps.STOCK_ID = stk.ID";
        if ($stmt = $conn -> prepare($select_sql)) {
             $first_name_en = 'Achiraya';
//            if($stmt->bind_param('s', $first_name_en)){
            if(true){
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_array(MYSQLI_NUM)) {
                        print_r($row);
                        echo '<br>';
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