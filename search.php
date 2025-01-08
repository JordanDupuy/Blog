<?php
// search.php
require 'config.php';
include 'header.php';

if (isset($_GET['query'])) {
    $query = '%' . $_GET['query'] . '%';
    $stmt = $pdo->prepare('SELECT * FROM posts WHERE title LIKE :query ORDER BY created_at DESC');
    $stmt->execute(['query' => $query]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $posts = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css" />
    <title>Recherche</title>
</head>
<body>
    <h1>Résultats de la recherche</h1>
    <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h2><a href="show.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h2>
                <p><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune publication trouvée.</p>
    <?php endif; ?>
    <a href="index.php">Retour à l'accueil</a>
</body>
</html>