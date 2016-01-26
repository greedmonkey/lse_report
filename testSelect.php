<?php 
    require_once('../data/kreang_connection.php');
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