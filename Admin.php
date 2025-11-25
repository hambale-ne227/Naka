<?php
session_start();
include 'php/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// Ajouter un document
if(isset($_POST['add_doc'])){
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $prix = $_POST['prix'];
    $fileName = $_FILES['fichier']['name'];
    $fileTmp = $_FILES['fichier']['tmp_name'];
    $uploadDir = 'uploads/documents/';

    if(move_uploaded_file($fileTmp, $uploadDir.$fileName)){
        $stmt = $pdo->prepare("INSERT INTO documents (titre, description, prix, fichier) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titre, $description, $prix, $fileName]);
        $message = "Document ajouté avec succès !";
    } else {
        $message = "Erreur lors de l'upload du fichier.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Gestion des documents</title>
<link rel="stylesheet" href="style.css">
<style>
.form-container { max-width:600px; margin:30px auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.2);}
.form-container input, .form-container textarea, .form-container button { width:100%; margin:10px 0; padding:10px; border-radius:5px; border:1px solid #ccc;}
.form-container button { background:#1a73e8; color:#fff; border:none; cursor:pointer;}
.form-container button:hover { background:#0056b3;}
table { width:90%; margin:30px auto; border-collapse:collapse;}
table, th, td { border:1px solid #ccc; padding:10px; text-align:center;}
</style>
</head>
<body>
<div class="form-container">
    <h2>Ajouter un document</h2>
    <?php if(isset($message)) echo "<p>$message</p>"; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="Titre du document" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="prix" placeholder="Prix (FCFA)" required>
        <input type="file" name="fichier" required>
        <button type="submit" name="add_doc">Ajouter</button>
    </form>
</div>

<h2 style="text-align:center;">Documents existants</h2>
<table>
<tr><th>ID</th><th>Titre</th><th>Prix</th><th>Actions</th></tr>
<?php
$stmt = $pdo->query("SELECT * FROM documents");
while($doc = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    echo "<td>".$doc['id']."</td>";
    echo "<td>".$doc['titre']."</td>";
    echo "<td>".$doc['prix']."</td>";
    echo "<td>
            <a href='edit_doc.php?id=".$doc['id']."'>Modifier</a> | 
            <a href='delete_doc.php?id=".$doc['id']."'>Supprimer</a>
          </td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>
