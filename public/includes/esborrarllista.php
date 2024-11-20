<?php

if (isset($_COOKIE['auth_token'])) {
    setcookie('auth_token', '', time() - 3600, '/'); // Elimina la cookie (expira immediatament)
}
// Redirigeix a la pàgina d'inici o login després de desconnectar
header("Location: ../index.php");
exit();
?>
