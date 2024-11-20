<?php
$mysqli = new mysqli("172.18.0.2", "root", "admin", "projecttest");
// Generar un token únic i guardar-lo en una cookie
        $token = bin2hex(random_bytes(16));  // Token aleatori
        setcookie("last_music", $token, time() + (86400 * 30), "/");  // Cookie vàlida durant 30 dies

        // Guardar el token a la base de dades
        $update_stmt = $mysqli->prepare("UPDATE music SET token = ? WHERE id = ?");
        if ($update_stmt === false) {
            die("Error en preparar la consulta d'actualització: " . $mysqli->error);
        }

        $update_stmt->bind_param("si", $token, $id);
        $update_stmt->execute();
        $update_stmt->close();

   

?>