<?php
    header("Access-Control-Allow-Origin: http://localhost:3000");
    
    // header("Access-Control-Allow-Origin: *");
    
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case 'GET':
            if (!empty($_GET["id"])) {
                $id = intval($_GET["id"]);
                getAcces($_GET["id"]);
            }
            else {
                getAcces();
            }
            break;
        
        default:
            echo "Erreur de la requête";
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
    function getAcces($id=0){
        $conn = mysqli_connect("localhost", "root", "", "cesi_projet2r");
        $query = "SELECT * FROM acces";
        if ($id != 0) {
            $query .= " WHERE id=$id LIMIT 1";
        }
        $response = array();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
        header('Content-type: application/json');
        echo json_encode($response, JSON_INVALID_UTF8_SUBSTITUTE);
    }
?>