<?php
include '../config/db.php';  // Incloure la connexió a la base de dades

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Eliminar la cançó de la base de dades
        $stmt = $pdo->prepare("DELETE FROM music WHERE id = ?");
        $stmt->execute([$id]);

        // Redirigir a la pàgina de música després d'eliminar la cançó
        header('Location: music.php'); 
        exit();  // Assegura't que no es continuï executant més codi després de redirigir
    } catch (PDOException $e) {
        // En cas d'error, redirigeix amb un missatge d'error
        header('Location: music.php?error=1');
        exit(); 
    }
}
?>

