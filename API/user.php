<?php
    header("Access-Control-Allow-Origin: http://localhost:3000/");
    // header("Access-Control-Allow-Origin: *");

    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case 'GET':
            if (!empty($_GET["login"]) && !empty($_GET["pss"])) {
                getUser(0, $_GET["login"], $_GET["pss"]);
            } 
            else if (!empty($_GET["id"])) {
                getUser($_GET["id"]);
            }
            else {
                getUser();
            }
            break;
        case 'POST':
            postUser();
            break;
        default:
            echo "Erreur de la requête";
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
    function getUser($id=0, $login=null, $pss=null){
        $conn = mysqli_connect("localhost", "root", "avvw9uMTzOlZ6Cbb", "cesi_projet2r");
        $query = "SELECT * FROM user";
        $response;
        if ($login != null && $pss != null) {
            $query .= " WHERE login='$login' AND psswrd='$pss' LIMIT 1";
            if (mysqli_query($conn, $query)) {
                $response=array(
                    'status' => 200,
                    'status_message' =>'Utilisateur connecté'
                );
            }
            else {
                $response=array(
                    'status' => 404,
                    'status_message' =>'ERREUR! '. mysqli_error($conn)
                );
            }
        } 
        else if ($id != 0) {
            $query .= " WHERE id=$id LIMIT 1";
            if (mysqli_query($conn, $query)) {
                $response=array(
                    'status' => 200,
                    'status_message' =>'Utilisateur existant'
                );
            }
            else {
                $response=array(
                    'status' => 404,
                    'status_message' =>'ERREUR! '. mysqli_error($conn)
                );
            }
        }
        header('Content-type: application/json');
        echo json_encode($response, JSON_INVALID_UTF8_SUBSTITUTE);
    }
    function postUser(){
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $dateNaiss = $_POST["dateNaiss"];
        $actif = 1;
        $login = $_POST["login"];
        $password = $_POST["password"];
        $niveauAcces = 1;
        $conn = mysqli_connect("localhost", "root", "avvw9uMTzOlZ6Cbb", "cesi_projet2r");
        $query = "INSERT INTO user (nom, prenom, date_naiss, actif, login, psswrd, niveau_acces) VALUES ('$nom', '$prenom', '$dateNaiss', $actif, '$login', '$password', $niveauAcces)";
        $response;
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 200,
                'status_message' =>'Utilisateur ajouté avec succes.'
            );
        }
        else{
            $response=array(
                'status' => 404,
                'status_message' =>'ERREUR!.'. mysqli_error($conn)
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>