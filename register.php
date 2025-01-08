<?php
// register.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $stmt->execute(['username' => $username, 'password' => $password]);

    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css" />
    <title>Inscription</title>
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
    <h1>Inscription</h1>
    <form action="register.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>