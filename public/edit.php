<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM music WHERE id = ?");
    $stmt->execute([$id]);
    $song = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'] ?? null;
    $genre = $_POST['genre'] ?? null;
    $year = $_POST['year'] ?? null;

    try {
        $stmt = $pdo->prepare("UPDATE music SET title = ?, artist = ?, album = ?, genre = ?, year = ? WHERE id = ?");
        $stmt->execute([$title, $artist, $album, $genre, $year, $id]);
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error en actualitzar la cançó: " . $e->getMessage();
    }
}
?>
<form method="POST" action="edit.php">
    <input type="hidden" name="id" value="<?= $song['id'] ?>">
    <label for="title">Títol:</label>
    <input type="text" name="title" value="<?= $song['title'] ?>" required>
    <label for="artist">Artista:</label>
    <input type="text" name="artist" value="<?= $song['artist'] ?>" required>
    <label for="album">Àlbum:</label>
    <input type="text" name="album" value="<?= $song['album'] ?>">
    <label for="genre">Gènere:</label>
    <input type="text" name="genre" value="<?= $song['genre'] ?>">
    <label for="year">Any:</label>
    <input type="number" name="year" value="<?= $song['year'] ?>" min="1900" max="2100">
    <button type="submit">Actualitzar</button>
</form>
