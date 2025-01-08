<?php
// show.php
require 'config.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$post_id = $_GET['id'];
$stmt = $pdo->prepare('
    SELECT posts.*, users.username as author_name
    FROM posts
    JOIN users ON posts.author = users.id
    WHERE posts.id = :id
');
$stmt->execute(['id' => $post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
        $username = $_SESSION['username'];

        $stmt = $pdo->prepare('INSERT INTO comments (post_id, comment, author, created_at) VALUES (:post_id, :comment, :author, NOW())');
        $stmt->execute(['post_id' => $post_id, 'comment' => $comment, 'author' => $username]);

        header('Location: show.php?id=' . $post_id);
        exit();
    } elseif (isset($_POST['delete_comment_id'])) {
        $comment_id = $_POST['delete_comment_id'];
        $stmt = $pdo->prepare('DELETE FROM comments WHERE id = :id AND author = :author');
        $stmt->execute(['id' => $comment_id, 'author' => $_SESSION['username']]);

        header('Location: show.php?id=' . $post_id);
        exit();
    }
}

$stmt = $pdo->prepare('SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at DESC');
$stmt->execute(['post_id' => $post_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" />
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <p>Publié par <?php echo htmlspecialchars($post['author_name']); ?></p>
    <p><?php echo nl2br(htmlspecialchars($post['body'])); ?></p>
    <h2>Commentaires</h2>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
            <p>— <?php echo htmlspecialchars($comment['author']); ?> le <?php echo date('d/m/Y à H:i', strtotime($comment['created_at'])); ?></p>
            <?php if (isset($_SESSION['username']) && $comment['author'] == $_SESSION['username']): ?>
                <form action="show.php?id=<?php echo $post_id; ?>" method="POST">
                    <input type="hidden" name="delete_comment_id" value="<?php echo $comment['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <form action="show.php?id=<?php echo $post_id; ?>" method="POST">
        <textarea name="comment" required></textarea>
        <button type="submit">Commenter</button>
    </form>
</body>
</html>
