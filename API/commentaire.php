<?php
    header("Access-Control-Allow-Origin: http://localhost:3000");
    // header("Access-Control-Allow-Origin: *");
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case 'GET':
            if (!empty($_GET["id"])) {
                $id = intval($_GET["id"]);
                getCommentaire($_GET["id"]);
            }
            else {
                getCommentaire();
            }
            break;
        case 'POST':
            postCommentaire();
            break;
        default:
            echo "Erreur de la requête";
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
    function getCommentaire($id=0){
        $conn = mysqli_connect("localhost", "root", "", "cesi_projet2r");
        $query = "SELECT * FROM commentaire";
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
    function postCommentaire(){ 
        $texteComm = $_POST["texteComm"];
        $user = $_POST["user"];
        $query;
        $ref;
        if (isset($_POST["ressource"])) {
            $ref = $_POST["ressource"];
            $query = "INSERT INTO commentaire (texte_commentaire, ressource, user) VALUES ('$texteComm', $ref, $user)";
        } 
        elseif (isset($_POST["commentaire"])) {
            $ref = $_POST["commentaire"];
            $query = "INSERT INTO commentaire (texte_commentaire, commentaire, user) VALUES ('$texteComm', $ref, $user)";
        }
        $conn = mysqli_connect("localhost", "root", "", "cesi_projet2r");
        $response;
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 200,
                'status_message' =>'Commentaire ajoute avec succes.'
            );
        }
        else{
            $response=array(
                'status' => 404,
                'status_message' =>'ERREUR! '. mysqli_error($conn)
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>