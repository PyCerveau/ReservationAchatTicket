<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../db/config.php'; // Assurez-vous que ce fichier contient la connexion à la base de données

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $point_depart = $_POST['point'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $prix = $_POST['prix'];
    $mode_paiement = $_POST['mode_paiement'];
    $numero_compte = $_POST['numero_compte'];

    // Valider les données
    if (empty($point_depart) || empty($destination) || empty($date) || empty($prix) || empty($mode_paiement) || empty($numero_compte)) {
        $_SESSION['error'] = "Tous les champs sont requis!";
        header("Location: achat.php");
        exit();
    }

    // Insérer l'achat dans la base de données
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insérer l'achat
        $sql = "INSERT INTO achats (user_id, point_depart, destination, date, prix, mode_paiement, numero_compte) VALUES (:user_id, :point_depart, :destination, :date, :prix, :mode_paiement, :numero_compte)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':point_depart', $point_depart);
        $stmt->bindParam(':destination', $destination);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':mode_paiement', $mode_paiement);
        $stmt->bindParam(':numero_compte', $numero_compte);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Achat de ticket pour le voyage $point_depart - $destination effectué avec succès!";
            header("Location: ../pages/mes.php");
            exit();
        } else {
            $_SESSION['error'] = "Erreur lors de l'insertion dans la base de données.";
            header("Location: ../pages/achat.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de connexion à la base de données: " . $e->getMessage();
        header("Location: ../pages/achat.php");
        exit();
    }
}
?>