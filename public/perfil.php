<?php
// Inicia la sessió només si no està activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprova si l'usuari està autenticat
if (!isset($_SESSION['usuari_id'])) {
    header("Location: /public/login.php"); // Redirigeix a login si no està autenticat
    exit();
}

// Assigna les variables de la sessió a les variables locals amb comprovacions
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : 'Usuari';
$cognoms = isset($_SESSION['cognoms']) ? $_SESSION['cognoms'] : 'Sense cognoms';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Sense email';
$imatge_perfil = isset($_SESSION['imatge_perfil']) ? $_SESSION['imatge_perfil'] : null;
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'usuari';
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil d'usuari</title>
    <link rel="stylesheet" href="/css/perfil.css">

</head>
<body>
    <div class="top_llegenda">
        <!-- Botons de navegació -->
    </div>

    <h1>Benvingut/da, <?php echo htmlspecialchars($nom); ?>!</h1>
    <p>Nom complet: <?php echo htmlspecialchars($nom . " " . $cognoms); ?></p>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>

    <?php if ($imatge_perfil): ?>
        <img src="/uploads/<?php echo htmlspecialchars($imatge_perfil); ?>" alt="Imatge de perfil" width="150">
    <?php else: ?>
        <p>No tens una imatge de perfil establerta.</p>
    <?php endif; ?>

    <br>
    <a href="editar_perfil.php">Edita el teu perfil</a>
    <br><br>
    <a href="/public/logout.php">Tancar sessió</a>

    <?php if ($rol === "administrador"): ?>
        <br><br>
        <a href="admin_panel.php"><button>Panell d'Administració</button></a>
    <?php endif; ?>
</body>
</html>
