<?php
include 'includes/db.php';

// Comprova si el mètode és GET i s'ha passat l'ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM music WHERE id = ?");
        $stmt->execute([$id]);
        $song = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$song) {
            echo "Cançó no trobada.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al carregar la cançó: " . $e->getMessage();
        exit();
    }
}

// Comprova si el mètode és POST per actualitzar la cançó
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'] ?? null;
    $genre = $_POST['genre'] ?? null;
    $year = $_POST['year'] ?? null;

    $audioFile = $song['file']; // Nom actual del fitxer d'àudio
    $coverImage = $song['cover_image']; // Nom actual de la caràtula

    // Processar la pujada del nou fitxer d'àudio
    if (isset($_FILES['audio']['name']) && $_FILES['audio']['name'] !== '') {
        $audioFile = uniqid() . "_" . $_FILES['audio']['name'];
        move_uploaded_file($_FILES['audio']['tmp_name'], "../uploads/audio/" . $audioFile);
    }

    // Processar la pujada de la nova caràtula
    if (isset($_FILES['cover']['name']) && $_FILES['cover']['name'] !== '') {
        $coverImage = uniqid() . "_" . $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "../uploads/covers/" . $coverImage);
    }

    try {
        // Actualitza les dades de la cançó
        $stmt = $pdo->prepare("UPDATE music SET title = ?, artist = ?, album = ?, genre = ?, year = ?, file = ?, cover_image = ? WHERE id = ?");
        $stmt->execute([$title, $artist, $album, $genre, $year, $audioFile, $coverImage, $id]);

        // Redirigeix a music.php després d'actualitzar
        header("Location: music.php");
        exit();
    } catch (PDOException $e) {
        echo "Error en actualitzar la cançó: " . $e->getMessage();
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Cançó</title>
    <link rel="stylesheet" href="../public/css/editar_canco.css">
</head>
<body>
    <div class="container">
        <h1>Edita la Cançó</h1>
        <form method="POST" action="edit.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($song['id']) ?>">
            
            <label for="title">Títol:</label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($song['title']) ?>" required>
            
            <label for="artist">Artista:</label>
            <input type="text" name="artist" id="artist" value="<?= htmlspecialchars($song['artist']) ?>" required>

            <label for="audio">Nou Fitxer d'Àudio:</label>
            <input type="file" name="audio" id="audio" accept="audio/*">
            
            <label for="cover">Nova Caràtula:</label>
            <input type="file" name="cover" id="cover" accept="image/*">

            <button type="submit">Actualitzar</button>
        </form>
    </div>
</body>
</html>
