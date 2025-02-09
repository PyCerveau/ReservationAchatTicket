<?php
session_start();
include '../include/header.php'; // Inclusion du header

// Connexion à la base de données
require '../db/config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les voyages disponibles
    $sql_voyages = "SELECT DISTINCT point_depart, destination FROM voyages";
    $stmt_voyages = $pdo->prepare($sql_voyages);
    $stmt_voyages->execute();
    $voyages = $stmt_voyages->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit();
}
?>

<link rel="stylesheet" href="../assets/styles.css">
<link rel="stylesheet" href="../assets/int.css">
<link rel="stylesheet" href="../assets/styless.css">

<div class="container mt-5">
    <h2 class="text-center">Itinéraire</h2>

    <div class="card p-4 shadow-lg">
        <form id="itineraireForm" action="./afficher_itineraire.php" method="POST">
            <div class="mb-3">
                <label for="point_depart" class="form-label">Point de départ :</label>
                <select class="form-control" name="point_depart" id="point_depart" required>
                    <option value="">Sélectionnez un point de départ</option>
                    <?php foreach ($voyages as $voyage): ?>
                        <option value="<?php echo htmlspecialchars($voyage['point_depart']); ?>">
                            <?php echo htmlspecialchars($voyage['point_depart']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="destination" class="form-label">Destination :</label>
                <select class="form-control" name="destination" id="destination" required>
                    <option value="">Sélectionnez une destination</option>
                    <?php foreach ($voyages as $voyage): ?>
                        <option value="<?php echo htmlspecialchars($voyage['destination']); ?>">
                            <?php echo htmlspecialchars($voyage['destination']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Afficher l'itinéraire</button>
        </form>
    </div>
</div>

