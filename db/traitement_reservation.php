<?php
session_start();
require '../db/config.php'; // Inclure la configuration de la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'], $_POST['voyage_id'], $_POST['date'])) {
        $user_id = $_POST['user_id'];
        $voyage_id = $_POST['voyage_id'];
        $date = $_POST['date'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insérer la réservation dans la table reservations
            $sql_reservation = "INSERT INTO reservations (utilisateur_id, voyage_id, date_reservation, statut) VALUES (:user_id, :voyage_id, :date, 'En attente')";
            $stmt_reservation = $pdo->prepare($sql_reservation);
            $stmt_reservation->execute([
                ':user_id' => $user_id,
                ':voyage_id' => $voyage_id,
                ':date' => $date
            ]);

            // Rediriger vers une page de confirmation ou vers mes.php
            $_SESSION['success'] = "Réservation effectuée avec succès!";
            header("Location: ../pages/mes.php");
            exit();
        } catch (PDOException $e) {
            echo "Erreur lors de la réservation: " . $e->getMessage();
            exit();
        }
    }
}
?>