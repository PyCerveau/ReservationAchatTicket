<?php
session_start();
include '../include/header.php'; // Inclusion du header

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

// Vérification des données POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['point_depart'], $_POST['destination'])) {
    $point_depart = $_POST['point_depart'];
    $destination = $_POST['destination'];

    // Connexion à la base de données
    require '../db/config.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les voyages correspondant à l'itinéraire
        $sql_itineraire = "SELECT * FROM voyages WHERE point_depart = :point_depart AND destination = :destination";
        $stmt_itineraire = $pdo->prepare($sql_itineraire);
        $stmt_itineraire->bindParam(':point_depart', $point_depart);
        $stmt_itineraire->bindParam(':destination', $destination);
        $stmt_itineraire->execute();
        $itineraire = $stmt_itineraire->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données: " . $e->getMessage();
        exit();
    }
} else {
    // Rediriger si les données ne sont pas disponibles
    header("Location: ./int.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher Itinéraire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/styless.css">
    <link rel="stylesheet" href="../assets/int.css">
</head>
<body>
    <header>
        <div class="logo">Noor Compagnie</div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="achat.php">Acheter</a></li>
                <li><a href="reserver.php">Réserver</a></li>
                <li><a href="int.php">Itinéraire</a></li>
                <li><a href="mes.php">Mes Réservations</a></li>
            </ul>
        </nav>
    </header>

    <div class="container mt-5">
        <h2 class="text-center">Itinéraire de <?php echo htmlspecialchars($point_depart); ?> à <?php echo htmlspecialchars($destination); ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Point de départ</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Prix (FCFA)</th>
                    <th scope="col">Date de départ</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($itineraire) > 0): ?>
                    <?php foreach ($itineraire as $voyage): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($voyage['id']); ?></td>
                            <td><?php echo htmlspecialchars($voyage['point_depart']); ?></td>
                            <td><?php echo htmlspecialchars($voyage['destination']); ?></td>
                            <td><?php echo htmlspecialchars($voyage['prix']); ?></td>
                            <td><?php echo htmlspecialchars($voyage['date_depart']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Aucun itinéraire trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>