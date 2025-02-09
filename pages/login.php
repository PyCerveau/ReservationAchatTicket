<?php
session_start();
require '../db/config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';  
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $error = "Utilisateur non trouvé.";
        } else {
            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: ./index.php");
                exit();
            } else {
                $error = "Mot de passe incorrect.";
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

ob_end_flush(); // Vide le tampon de sortie et l'envoie au navigateur
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/styless.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" class="login-form">
            <h2>Connexion</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
            <p>Pas encore inscrit ? <a href="./register.php">S'inscrire</a></p>
        </form>
    </div>
</body>
</html>
