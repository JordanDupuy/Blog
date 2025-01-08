<?php
// login.php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css" />
    <title>Connexion</title>
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
    <h1>Connexion</h1>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">S'inscrire ici</a></p>
</body>
</html>