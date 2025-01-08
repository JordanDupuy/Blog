<?php
// create.php
require 'config.php';
include 'header.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('INSERT INTO posts (title, body, author) VALUES (:title, :body, :author)');
    $stmt->execute(['title' => $title, 'body' => $body, 'author' => $user_id]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css" />
    <title>Créer une publication</title>
</head>
<body>
    <h1>Créer une publication</h1>
    <form action="create.php" method="POST">
        <label for="title">Titre :</label>
        <input type="text" name="title" required>
        <label for="body">Contenu :</label>
        <textarea name="body" required></textarea>
        <button type="submit">Publier</button>
    </form>
</body>
</html>