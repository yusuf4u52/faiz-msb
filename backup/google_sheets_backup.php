<?php
    require '_credentials.php';
    $url = "http://faizstudentsbackup.pythonanywhere.com/backup";
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    function getOutputForTable($tablename) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM $tablename"); 
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //make the headers
        //assume query will have atleast 1 record
        $output = array('tableName'=>$tablename);
        $titles = array();
        foreach($records[0] as $key => $value) {
            array_push($titles, $key);
        }
        $output['titles'] = $titles;
        //now go for the records!
        $data = array();
        foreach($records as $record) {
            $values = array();
            foreach($record as $key => $value) {
                $value = preg_replace('#\R+#', ' ', $value);
                // this is done to remove \n in fields like addresses
                array_push($values, $value);
            }
            array_push($data, $values);
        }
        $output['records'] = $data;
        return $output;
    }
    function getTableNames() {
        global $conn, $dbname;
        $stmt = $conn->prepare("show tables FROM $dbname"); 
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tableNames = array();
        foreach($records as $record) {
            foreach($record as $key => $value) {
                array_push($tableNames, $value);
            }
        }
        return $tableNames;
    }
    function getWholeDatabase() {
        $tables = array();
        $tableNames = getTableNames();
        foreach($tableNames as $tableName) {
            array_push($tables, getOutputForTable($tableName));
        }
        $wholeDatabase = array('tables' => $tables, 'tableNames' => $tableNames);
        return $wholeDatabase;
    }
    $wholeDatabase = getWholeDatabase();
    $conn = null;
    // echo "<pre>\n";
    // echo json_encode($wholeDatabase);
    // echo "\n</pre>";
    $options = array(
        'http' => array(
        'method'  => 'POST',
        'content' => json_encode( $wholeDatabase ),
        'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
        )
    );

    $context  = stream_context_create( $options );
    $result = file_get_contents( $url, false, $context );
    // $response = json_decode( $result );
    echo $result;
?>