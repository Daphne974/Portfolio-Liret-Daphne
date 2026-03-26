<?php
//header("Content-Type: application/json");
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$codePays = isset($_GET['Code']) ? (int) $_GET['Code'] : null;

function reponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

if ($method === 'GET') {
    if ($codePays) {
        $stmt = $pdo->prepare("SELECT * FROM Pays WHERE Code = :Code");
        $stmt->execute(['Code' => $codePays]);
        $pays = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pays) {
            reponse($pays);
        } else {
            reponse(['message' => 'Pays non trouvé'], 404);
        }
    } else {
        $stmt = $pdo->query("SELECT * FROM Pays");
        $pays = $stmt->fetchAll(PDO::FETCH_ASSOC);
        reponse($pays);
    }
}

elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nom'])) {
        $stmt = $pdo->prepare("INSERT INTO Pays (nom) VALUES (:nom)");
        $stmt->execute([
            'nom' => $data['nom'],
        ]);
        $newCode = $pdo->lastInsertId();

        reponse(['message' => 'Pays ajouté', 'Code' => $newCode], 201);
    } else {
        reponse(['message' => 'Données invalides'], 400);
    }
}

elseif ($method === 'PUT') {
    if (!$codePays) {
        reponse(['message' => 'Code du pays manquant'], 400);
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $fields = [];
    $params = ['Code' => $codePays];

    if (isset($data['nom'])) {
        $fields[] = "nom = :nom";
        $params['nom'] = $data['nom'];
    }

    if (!empty($fields)) {
        $sql = "UPDATE Pays SET " . implode(", ", $fields) . " WHERE Code = :Code";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        reponse(['message' => 'Pays mis à jour']);
    } else {
        reponse(['message' => 'Données invalides'], 400);
    }
}

elseif ($method === 'DELETE') {
    if (!$codePays) {
        reponse(['message' => 'Code du pays manquant'], 400);
    }

    $stmt = $pdo->prepare("DELETE FROM Pays WHERE Code = :Code");
    $stmt->execute(['Code' => $codePays]);

    reponse(['message' => 'Pays supprimé']);
}

else {
    reponse(['message' => 'Méthode non supportée'], 405);
}
