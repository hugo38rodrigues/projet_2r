<?php
    header("Access-Control-Allow-Origin: http://localhost:3000");
    // header("Access-Control-Allow-Origin: *");
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case 'GET':
            if (!empty($_GET["id"])) {
                getRessource($_GET["id"]);
            }
            else {
                getRessource();
            }
            break;
        case 'POST':
            postRessource();
            break;
        case 'OPTIONS':
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  
            }
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }
            break;
        default:
            echo "Erreur de la requête";
            header("HTTP/1.0 405 Method Not Allowed " . $request_method);
            break;
    }
    function getRessource($id=0){
        $conn = mysqli_connect("localhost", "root", "avvw9uMTzOlZ6Cbb", "cesi_projet2r");
        $query = "SELECT titre, date_crea, texte, media, label AS categorie, concat(nom, ' ', prenom) AS createur, acces FROM ressource, categorie, user, contenu WHERE ressource.categorie = categorie.id AND ressource.contenu = contenu.id AND ressource.createur = user.id";
        if ($id != 0) {
            $query .= " AND ressource.id=$id";
        }
        $query .= " ORDER BY ressource.id DESC";
        $response = array();
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = $row;
        }
        header('Content-type: application/json');
        echo json_encode($response, JSON_INVALID_UTF8_SUBSTITUTE);
    }
    function postRessource(){
        $data = json_decode(file_get_contents('php://input'), true);
        print_r ($data);
        $conn = mysqli_connect("localhost", "root", "avvw9uMTzOlZ6Cbb", "cesi_projet2r");
        $titre = $data["titre"];
        $date_crea = $data["date_crea"];
        $texte = $data["texte"];
        // $media = $data["media"];
        $categorie = $data["categorie"];
        $createur = $data["createur"];
        $acces = $data["acces"];
        echo $query1 = "INSERT INTO contenu (texte) VALUES ('$texte')";
        if (mysqli_query($conn, $query1)) {
            $query2 = "SELECT id FROM contenu WHERE texte='$texte'";
            $result = mysqli_query($conn, $query2);
            $r = mysqli_fetch_assoc($result);
            $contenu = $r['id'];
            echo $query3 = "INSERT INTO ressource (titre, date_crea, contenu, categorie, createur, acces) VALUES ('$titre', '$date_crea', $contenu, $categorie, $createur, $acces)";
            if (mysqli_query($conn, $query3)) {
                $response = array(
                    'insert_type' => "ressource",
                    'status' => 200,
                    'status_message' => "Ressource ajoutée avec succès."
                );
            }
            else {
                $response = null;
                $response = array(
                    'insert_type' => "ressource",
                    'status' => 404,
                    'status_message' => "Ressource ajoutée sans succès. ".mysqli_error($conn)
                );
            }
        }
        else {
            $response = null;
            $response = array(
                'insert_type' => "ressource",
                'status' => 404,
                'status_message' => "Ressource ajoutée sans succès - erreur ajout contenu ".mysqli_error($conn)
            );
        }
        print_r($contenu);
        header('Content-type: application/json');
        echo json_encode($response, JSON_INVALID_UTF8_SUBSTITUTE);
    }
    function getContenu($texte){
        
    }
?>