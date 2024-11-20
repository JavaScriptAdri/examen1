<?php
// Comprova si la sessió ja està activa, si no, la inicia
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprova si l'usuari ja està autenticat
if (isset($_SESSION['usuari_id'])) {
    // Si l'usuari ja està loguejat, redirigeix-lo al perfil
    header("Location: /public/perfil.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessió</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sessió</h2>
        <form action="includes/controlLogin.php" method="POST" class="login-form">
            <input type="text" name="nom_dusuari" placeholder="Nom d'usuari" required>
            <input type="password" name="contrasenya" placeholder="Contrasenya" required>
            <button type="submit">Iniciar Sessió</button>
        </form>
    </div>
</body>
</html>
