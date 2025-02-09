<?php
session_start();
include '../include/header.php'; // Remonter d'un dossier pour trouver header.php
if (!isset($_SESSION['user_id'])) {
    header("Location:  ./login.php"); // Correction du chemin vers login.php
    exit();
}

// Connexion à la base de données
require '../db/config.php'; // Chemin correct vers config.php

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les voyages disponibles
    $sql_voyages = "SELECT id, point_depart, destination, prix FROM voyages";
    $stmt_voyages = $pdo->prepare($sql_voyages);
    $stmt_voyages->execute();
    $voyages = $stmt_voyages->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit();
}
?>

<head>
    <title>Réservation</title>
    <link rel="stylesheet" href="../assets/achat.css"> <!-- Chemin corrigé -->
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/styless.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>

<form id="achatForm" action="./paiement.php" method="POST"> <!-- Correction du chemin -->
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

    <div class="mb-3">
        <label for="voyage_id" class="form-label">Sélectionnez un Voyage :</label>
        <select class="form-control" name="voyage_id" id="voyage_id" required>
            <option value="">Sélectionnez un voyage</option>
            <?php foreach ($voyages as $voyage): ?>
                <option value="<?php echo htmlspecialchars($voyage['id']); ?>">
                    <?php echo htmlspecialchars($voyage['point_depart']) . " - " . htmlspecialchars($voyage['destination']) . " (Prix: " . htmlspecialchars($voyage['prix']) . " FCFA)"; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Date du voyage :</label>
        <input type="date" class="form-control" name="date" id="date" required>
    </div>

    <div class="mb-3">
        <label for="mode_paiement" class="form-label">Mode de paiement :</label>
        <select class="form-control" name="mode_paiement" id="mode_paiement" required>
            <option value="">Sélectionner...</option>
            <option value="Visa">Visa</option>
            <option value="MasterCard">MasterCard</option>
            <option value="Mobile Money">Mobile Money</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100" id="acheterBtn">Continuer vers paiement</button>
</form>
<script>
    document.getElementById('voyage_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const prixInput = document.getElementById('prix');
        const prix = selectedOption.text.match(/\(([^)]+)\)/)[1]; // Extraire le prix de la chaîne
        prixInput.value = prix.split(': ')[1]; // Mettre à jour le champ prix
    });
</script>
