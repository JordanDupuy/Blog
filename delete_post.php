<?php
// delete_post.php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Vérifier si l'utilisateur est l'auteur de la publication
$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = :id AND author = :author');
$stmt->execute(['id' => $post_id, 'author' => $user_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if ($post) {
    // Supprimer la publication
    $stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
    $stmt->execute(['id' => $post_id]);
}

header('Location: index.php');
exit();
?>
