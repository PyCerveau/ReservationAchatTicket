<?php
session_start();
include '../include/header.php'; // Inclusion du header

if (!isset($_GET['code_recu'])) {
    exit('Aucun code de reçu spécifié!');
}

$code_recu = htmlspecialchars($_GET['code_recu']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/styless.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Votre Reçu</h2>

    <div class="card p-4 shadow-lg">
        <p class="text-center"><strong>Code de Reçu :</strong> <?php echo $code_recu; ?></p>
        <p class="text-center">Merci pour votre réservation!</p>
    </div>
</div>

</body>
</html>