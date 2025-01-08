<?php
// header.php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css" />
    <title>Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="create.php">Créer une publication</a></li>
            </ul>
        </nav>
        <div>
            <?php if (isset($_SESSION['username'])): ?>
                <p>Connecté en tant que <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="login.php">Connexion</a>
                <a href="register.php">Inscription</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="search-bar">
        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Rechercher...">
            <button type="submit">Rechercher</button>
        </form>
    </div>
</body>
</html>