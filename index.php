<?php
// index.php
require 'config.php';
include 'header.php';

$stmt = $pdo->query('
    SELECT posts.*, users.username as author_name
    FROM posts
    JOIN users ON posts.author = users.id
    ORDER BY posts.created_at DESC
');
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" />
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue sur le blog</h1>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h2>
                <a href="show.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                <span class="author">par <?php echo htmlspecialchars($post['author_name']); ?></span>
            </h2>
            <p><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
            <?php if (isset($_SESSION['user_id']) && $post['author'] == $_SESSION['user_id']): ?>
                <form action="delete_post.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
