<?php
// Inicia la sessió si no està iniciada
session_start();

// Inclou la connexió a la base de dades
include('db.php');

// Comprova si el formulari s'ha enviat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recull les dades del formulari
    $nom_dusuari = $_POST['nom_dusuari'];
    $contrasenya = $_POST['contrasenya'];

    // Consulta per comprovar les credencials de l'usuari
    $query = "SELECT id, nom, cognoms, contrasenya, email, imatge_perfil, rol FROM usuaris WHERE nom_dusuari = :nom_dusuari";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom_dusuari', $nom_dusuari, PDO::PARAM_STR);
    $stmt->execute();
    
    $usuari = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuari && password_verify($contrasenya, $usuari['contrasenya'])) {
        // Si les credencials són correctes, inicia la sessió
        $_SESSION['usuari_id'] = $usuari['id'];
        $_SESSION['nom'] = $usuari['nom'];
        $_SESSION['cognoms'] = $usuari['cognoms'];
        $_SESSION['email'] = $usuari['email'];  // Emmagatzema el correu
        $_SESSION['imatge_perfil'] = $usuari['imatge_perfil']; // Emmagatzema la imatge de perfil
        $_SESSION['rol'] = $usuari['rol']; // Emmagatzema el rol

        // Redirigeix a la pàgina de perfil
        header("Location: /public/perfil.php");
        exit();
    } else {
        // Si les credencials són incorrectes
        echo "Les credencials no són correctes.";
    }
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil d'usuari</title>
    <link rel="stylesheet" href="../../public/css/perfil.css">
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
