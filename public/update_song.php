<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $duration = $_POST['duration'];
    $file = $_POST['file'];

    // Si s'ha pujat una nova imatge de la portada
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $cover = 'uploads/' . basename($_FILES['cover']['name']);
        move_uploaded_file($_FILES['cover']['tmp_name'], $cover);
    } else {
        $cover = '';  // Si no s'ha pujat cap portada, deixar-ho buit
    }

    try {
        // Actualitzar la cançó a la base de dades
        $stmt = $pdo->prepare("UPDATE music SET title = ?, artist = ?, duration = ?, file = ?, cover = ? WHERE id = ?");
        $stmt->execute([$title, $artist, $duration, $file, $cover, $id]);

        echo 'Cançó actualitzada correctament!';
    } catch (PDOException $e) {
        echo 'Error en l\'actualització: ' . $e->getMessage();
    }
}
?>
