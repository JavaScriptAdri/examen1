<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia la sessió si no està activa
}

// Destruïm totes les variables de sessió
session_unset();

// Destruïm la sessió
session_destroy();

// Elimina la cookie del token d'autenticació (si existeix)
if (isset($_COOKIE['auth_token'])) {
    setcookie('auth_token', '', time() - 3600, '/'); // Elimina la cookie (expira immediatament)
}

// Redirigeix a la pàgina d'inici o login després de desconnectar
header("Location: index.php");
exit();
?>
