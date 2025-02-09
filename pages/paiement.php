<?php
session_start();
include '../include/header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

// Récupération des données du formulaire de achat.php
$voyage_id = $_POST['voyage_id'] ?? null;
$date_voyage = $_POST['date'] ?? '';
$mode_paiement = $_POST['mode_paiement'] ?? '';

// Récupération des détails du voyage depuis la BDD
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_voyage = "SELECT point_depart, destination, prix FROM voyages WHERE id = :voyage_id";
    $stmt_voyage = $pdo->prepare($sql_voyage);
    $stmt_voyage->bindParam(':voyage_id', $voyage_id);
    $stmt_voyage->execute();
    $voyage = $stmt_voyage->fetch(PDO::FETCH_ASSOC);

    if (!$voyage) die("Voyage introuvable!");

    $point_depart = $voyage['point_depart'];
    $destination = $voyage['destination'];
    $prix = $voyage['prix'];

} catch (PDOException $e) {
    die("Erreur de connexion à la BDD: " . $e->getMessage());
}

// Traitement du formulaire de paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero_compte'])) {
    $user_id = $_SESSION['user_id'];
    $numero_compte = $_POST['numero_compte'];

    try {
        $sql = "INSERT INTO achats (user_id, id_voyage, date_achat, mode_paiement, numero_compte) 
                VALUES (:user_id, :id_voyage, :date_achat, :mode_paiement, :numero_compte)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':id_voyage' => $voyage_id,
            ':date_achat' => $date_voyage, // Utilisez $date_voyage pour la date du voyage
            ':mode_paiement' => $mode_paiement,
            ':numero_compte' => $numero_compte
        ]);

        $_SESSION['success'] = "Achat réussi!";
        header("Location: mes.php");
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de l'achat: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/paiement.css">
    <link rel="stylesheet" href="../assets/styless.css">
</head>
<body>
    <div class="container">
        <h1>Reçu d'Achat</h1>
        <div class="receipt">
            <table>
                <tr><th>Départ:</th><td><?= htmlspecialchars($point_depart) ?></td></tr>
                <tr><th>Destination:</th><td><?= htmlspecialchars($destination) ?></td></tr>
                <tr><th>Date:</th><td><?= htmlspecialchars($date_voyage) ?></td></tr>
                <tr><th>Prix:</th><td><?= htmlspecialchars($prix) ?> FCFA</td></tr>
                <tr><th>Mode de paiement:</th><td><?= htmlspecialchars($mode_paiement) ?></td></tr>
            </table>
        </div>
        <form method="POST">
            <input type="hidden" name="voyage_id" value="<?= $voyage_id ?>">
            <input type="hidden" name="date" value="<?= htmlspecialchars($date_voyage) ?>">
            <input type="hidden" name="mode_paiement" value="<?= htmlspecialchars($mode_paiement) ?>">
            
            <div class="mb-3">
                <label>Numéro de compte:</label>
                <input type="text" name="numero_compte" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Confirmer</button>
        </form>
    </div>

</body>
</html>