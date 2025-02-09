<?php
session_start();
include '../include/header.php'; // Inclusion du header

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Connexion à la base de données
require '../db/config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les réservations de l'utilisateur
    $sql_reservations = "SELECT r.id, v.point_depart, v.destination, r.date_reservation, r.statut FROM reservations r JOIN voyages v ON r.voyage_id = v.id WHERE r.utilisateur_id = :user_id";
    $stmt_reservations = $pdo->prepare($sql_reservations);
    $stmt_reservations->bindParam(':user_id', $user_id);
    $stmt_reservations->execute();
    $reservations = $stmt_reservations->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les achats de l'utilisateur
    $sql_achats = "SELECT a.id, v.point_depart, v.destination, a.date_achat, a.mode_paiement, v.prix FROM achats a JOIN voyages v ON a.id_voyage = v.id WHERE a.user_id = :user_id";
    $stmt_achats = $pdo->prepare($sql_achats);
    $stmt_achats->bindParam(':user_id', $user_id);
    $stmt_achats->execute();
    $achats = $stmt_achats->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de connexion à la base de données: " . $e->getMessage();
    header("Location: login.php");
    exit();
}
?>
<head>
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/mes.css">
    <link rel="stylesheet" href="../assets/styless.css">
</head>
<div class="container mt-5">
    <h2 class="text-center">Mes Réservations et Achats</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success text-center">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <h3>Réservations</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Point de départ</th>
                <th scope="col">Destination</th>
                <th scope="col">Date de Réservation</th>
                <th scope="col">Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($reservations) > 0): ?>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['point_depart']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['destination']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['date_reservation']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['statut']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Aucune réservation trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Achats</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Point de départ</th>
                <th scope="col">Destination</th>
                <th scope="col">Date d'Achat</th>
                <th scope="col">Prix (Fcfa)</th>
                <th scope="col">Mode de Paiement</th>
            </tr>
 </thead>
        <tbody>
            <?php if (count($achats) > 0): ?>
                <?php foreach ($achats as $achat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($achat['point_depart']); ?></td>
                        <td><?php echo htmlspecialchars($achat['destination']); ?></td>
                        <td><?php echo htmlspecialchars($achat['date_achat']); ?></td>
                        <td><?php echo htmlspecialchars($achat['prix']); ?></td>
                        <td><?php echo htmlspecialchars($achat['mode_paiement']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun achat trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
        <div class="social-links">
            <img src="../img/facebook.png" alt="Facebook">
            <img src="../img/whatsp.png" alt="WhatsApp">
            <img src="../img/insta.webp" alt="Instagram">
        </div>
        <p>&copy; 2025 Noor Compagnie. Tous droits réservés.</p>
</footer>


<script src="../assets/script.js"></script>
</body>
</html>