<?php
    header("Access-Control-Allow-Origin: http://localhost:3000"); // Permet la connexion entre les serveurs (ici, Apache et NodeJS)
    // header("Access-Control-Allow-Origin: *");
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case 'GET': // Requête GET
            if (!empty($_GET["id"])) { // Si une seule catégorie est demandée
                $id = intval($_GET["id"]); // intval() = passage d'un string en int
                getCategories($_GET["id"]); 
            }
            else {
                getCategories();
            }
            break;
        case 'POST': // Requête POST
            postCategorie();
            break;
        default: // Si erreur dans l'envoi de la requête
            echo "Erreur de la requête";
            header("HTTP/1.0 405 Method Not Allowed"); // Redirection
            break;
    }
    function getCategories($id=0){
        $conn = mysqli_connect("localhost", "root", "", "cesi_projet2r"); // Connexion à la base de données (en dur temporairement)
        $query = "SELECT * FROM categorie";
        if ($id != 0) {
            $query .= " WHERE id=$id LIMIT 1"; // Si une seule catégorie est demandée, on recherche par id
        }
        $response = array();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
        header('Content-type: application/json'); // Préparation de la page au format JSON
        echo json_encode($response, JSON_INVALID_UTF8_SUBSTITUTE); // Affichage du JSON
    }
    function postCategorie(){
        $categorie = $_POST["categorie"]; // Récupération de l'envoi du formulaire
        $conn = mysqli_connect("localhost", "root", "", "cesi_projet2r");
        $query = "INSERT INTO categorie (label) VALUES ('$categorie')";
        $response;
        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 200, // Statut 200 = OK
                'status_message' =>'Commentaire ajouté avec succes.'
            );
        }
        else{
            $response=array(
                'status' => 404, // Statut 404 = NOK
                'status_message' =>'ERREUR!.'. mysqli_error($conn) // Récupération de la dernière erreur SQL
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>