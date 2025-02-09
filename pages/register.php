<?php
session_start();
require '../db/config.php';

$error = ""; // Initialisation du message d'erreur

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';  
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';  
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($nom) && !empty($email) && !empty($password)) {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Hacher le mot de passe avant de l'enregistrer
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur avec le nom, email et mot de passe haché
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$nom, $email, $password_hashed])) {
                header("Location: ./login.php");
                exit();
            } else {
                $error = "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/styless.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" class="login-form">
            <h2>Inscription</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <div class="input-group">
                <input type="text" name="nom" placeholder="Nom complet" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn">S'inscrire</button>
            <p>Déjà inscrit ? <a href="./login.php">Se connecter</a></p>
        </form>
    </div>
</body>
</html>
