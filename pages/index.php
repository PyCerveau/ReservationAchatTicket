<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noor Compagnie - Réservation| Achat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <div class="logo">Noor Compagnie</div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="./achat.php">Acheter</a></li>
                <li><a href="./reserver.php">Réserver</a></li>
                <li><a href="./int.php">Itinéraire</a></li>
                <li><a href="./mes.php">Mes réservations</a></li>
                <li><a href="./propos.php">À propos</a></li>
                <li><a href="./logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="main-content">
        <div class="background-image">
            <div class="overlay">
                <h1>Réservation facile et instantanée</h1>
                <div id="overlay-buttons">
                    <?php if ($isLoggedIn): ?>
                        <button class="btn orange" onclick="window.location.href='../pages/achat.php'">Acheter</button>
                        <button class="btn orange" onclick="window.location.href='../pages/reserver.php'">Réserver</button>
                    <?php else: ?>
                        <button class="btn orange" onclick="window.location.href='./login.php'">Se Connecter</button>
                        <button class="btn orange" onclick="window.location.href='./register.php'">S'Inscrire</button>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>
    
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
