<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
include 'php/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Catalogue des documents</title>
<link rel="stylesheet" href="style.css">
<style>
/* Styles spécifiques pour les cartes de documents */
.catalogue-container {
    width: 90%;
    max-width: 1100px;
    margin: 50px auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
.doc-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease;
}
.doc-card:hover {
    transform: translateY(-5px);
}
.doc-card h3 { color: #1a73e8; margin-bottom: 10px; }
.doc-card p { font-size: 14px; color: #555; margin-bottom: 10px; }
.price { font-weight: bold; color: #333; margin-bottom: 10px; }
.btn-buy {
    display: inline-block;
    background: #1a73e8;
    color: #fff;
    padding: 8px 15px;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s ease;
}
.btn-buy:hover { background: #0056b3; }
</style>
</head>
<body>
<header>
    <div class="container">
        <h1 class="logo">DocÉtudiant</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="catalogue.php" class="active">Catalogue</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            </ul>
        </nav>
    </div>
</header>

<h2 style="text-align:center; margin-top:30px;">📚 Catalogue des documents</h2>
<div class="catalogue-container">
<?php
$sql = "SELECT * FROM documents";
$stmt = $pdo->query($sql);
while ($doc = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class='doc-card'>";
    echo "<h3>".$doc['titre']."</h3>";
    echo "<p>".$doc['description']."</p>";
    echo "<p class='price'>Prix : ".$doc['prix']." FCFA</p>";
    echo "<a class='btn-buy' href='download.php?file=".$doc['fichier']."'>Télécharger</a>";
    echo "</div>";
}
?>
</div>

<footer>
    <p>&copy; 2025 DocÉtudiant - Tous droits réservés</p>
</footer>
</body>
</html>
