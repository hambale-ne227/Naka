<?php
include 'php/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérifier si email existe
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0){
        $message = "Cet email est déjà utilisé !";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$nom, $prenom, $email, $password])){
            $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inscription</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Inscription</h2>
    <?php if($message != '') echo "<p>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="login.php">Connexion</a></p>
</div>
</body>
</html>
