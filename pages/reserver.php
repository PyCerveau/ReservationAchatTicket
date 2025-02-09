<?php
session_start();
include '../include/header.php'; // Inclusion du header

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

// Récupération des informations utilisateur
$user_name = $_SESSION['user_name'];

// Connexion à la base de données
require '../db/config.php';

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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/reserver.css">
    <link rel="stylesheet" href="../assets/styless.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Réserver un Ticket</h2>

    <div class="card p-4 shadow-lg">
       
        <form id="reservationForm" action="../db/traitement_reservation.php" method="POST">
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

            <button type="submit" class="btn btn-warning w-100" id="reserverBtn" disabled>
                <span id="buttonText">Réserver</span>
                <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
            </button>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("reservationForm");
        const reserverBtn = document.getElementById("reserverBtn");
        const voyageId = document.getElementById("voyage_id");
        const date = document.getElementById("date");

        function toggleButton() {
            if (voyageId.value !== "" && date.value !== "") {
                reserverBtn.removeAttribute("disabled");
            } else {
                reserverBtn.setAttribute("disabled", "true");
            }
        }

        voyageId.addEventListener("change", toggleButton);
        date.addEventListener("input", toggleButton);

        form.addEventListener("submit", function (e) {
            e.preventDefault();
            reserverBtn.setAttribute("disabled", "true");
            const buttonText = document.getElementById("buttonText");
            const spinner = document.getElementById("spinner");
            buttonText.classList.add("d-none");
            spinner.classList.remove("d-none");

            setTimeout(() => {
                form.submit();
            }, 2000);
        });
    });
</script>

</body>
</html>