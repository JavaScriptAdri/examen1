<?php 
include 'includes/header.php'; 
include '../config/db.php'; 
?>

<main>
    <h1>Explora la música</h1>

    <!-- Llista de Música -->
    <div id="music-list">
        <h2>Llista de música:</h2>
        <!-- Mostrar les cançons des de la base de dades -->
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM music");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Mostrar cada cançó amb la seva imatge, títol, artista i botons d'editar i eliminar
                echo "<div class='music-item'>";
                
                // Mostrar la caràtula de la cançó
                echo "<img src='../uploads/covers/{$row['cover_image']}' alt='Caràtula de {$row['title']}' class='cover-img'>";
                
                // Mostrar títol i artista
                echo "<div><strong>{$row['title']}</strong> - {$row['artist']}</div>";
                
                // Reproductor d'àudio per a la cançó
                echo "<audio controls>";
                echo "<source src='../uploads/audio/{$row['file']}' type='audio/mp3'>";
                echo "El teu navegador no suporta l'etiqueta d'àudio.";
                echo "</audio>";
                
                // Botons d'editar i eliminar
                echo "<a href='edit_song.php?id={$row['id']}' class='edit-btn'>Editar</a>";
                echo "<a href='delete_song.php?id={$row['id']}' class='delete-btn' onclick='return confirm(\"Segur que vols eliminar aquesta cançó?\")'>Eliminar</a>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
        ?>
    </div>

    <!-- Formulario per a pujar noves cançons -->
    <div class="upload-form">
        <h2>Puig una nova cançó</h2>
        <form action="upload_song.php" method="POST" enctype="multipart/form-data">
            <label for="title">Títol:</label>
            <input type="text" name="title" id="title" required>
            
            <label for="artist">Artista:</label>
            <input type="text" name="artist" id="artist" required>
            
            <label for="file">Arxiu de la cançó (MP3):</label>
            <input type="file" name="file" id="file" accept="audio/mp3" required>
            
            <label for="cover">Caràtula (Imatge):</label>
            <input type="file" name="cover" id="cover" accept="image/*">
            
            <button type="submit" name="submit">Pujar Cançó</button>
        </form>
    </div>
</main>

<script src="js/script.js"></script>
