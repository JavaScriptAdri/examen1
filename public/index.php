<?php
include 'includes/kookiesong.php';
include 'includes/header.php';
include 'includes/db.php';


try {
    // Consulta per obtenir les cançons de la taula 'music'
    $stmt = $pdo->query("SELECT * FROM music");

    // Mostrar les cançons
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='song'>";
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p>Artista: " . htmlspecialchars($row['artist']) . "</p>";

        // Comprovar si el fitxer d'àudio existeix abans de mostrar-lo
        $audioPath = '../uploads/audio/' . htmlspecialchars($row['file']);
        if (file_exists($audioPath)) {
            echo "<audio controls>";
            echo "<source src='" . $audioPath . "' type='audio/mpeg'>";
            echo "El teu navegador no suporta l'àudio HTML.";
            echo "</audio>";
        } else {
            echo "<p>No s'ha trobat el fitxer d'àudio per aquesta cançó.</p>";
        }

        // Comprovar si la caràtula existeix abans de mostrar-la
        $coverPath = '../uploads/covers/' . htmlspecialchars($row['cover_image']);
        if (file_exists($coverPath)) {
            echo "<p>Caràtula:</p>";
            echo "<img src='" . $coverPath . "' alt='Caràtula de la cançó' style='width: 200px; height: auto;'>";
        } else {
            echo "<p>No s'ha trobat la caràtula per aquesta cançó.</p>";
        }

        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessió</title>
   
</head>
<body>
<a href="../public/includes/esborrarllista.php">Esborrar llista </a>
</body>
</html>

