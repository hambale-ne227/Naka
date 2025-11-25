<?php
session_start();
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        header("Location: catalogue.php");
        exit();
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Connexion</h2>
    <?php if($message != '') echo "<p>$message</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Inscription</a></p>
</div>
</body>
</html>
