<?php
// Inclou la connexió a la base de dades
include 'includes/db.php';

// Ruta de les carpetes
$audioDir = '../uploads/audio/';
$coverDir = '../uploads/covers/';



if (isset($_POST['submit'])) {
    // Obtenim les dades del formulari
    $title = $_POST['title'];
    $artist = $_POST['artist'];

    // Gestionem el fitxer d'àudio
    $audioFile = $_FILES['file']['name'];
    $audioTmpName = $_FILES['file']['tmp_name'];
    $audioPath = $audioDir . $audioFile;  // Ruta absoluta per al fitxer d'àudio

    // Gestionem la imatge de la caràtula
    $coverFile = $_FILES['cover']['name'];
    $coverTmpName = $_FILES['cover']['tmp_name'];
    $coverPath = $coverDir . $coverFile;  // Ruta absoluta per a la imatge de la caràtula

    // Comprovem que els fitxers siguin vàlids
    if (move_uploaded_file($audioTmpName, $audioPath) && move_uploaded_file($coverTmpName, $coverPath)) {
        // Inserim les dades a la base de dades
        $stmt = $pdo->prepare("INSERT INTO music (title, artist, file, cover_image) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$title, $artist, $audioFile, $coverFile])) {
            echo "Cançó pujades correctament!";
        } else {
            echo "Error en la càrrega de la cançó.";
        }
    } else {
        echo "Error en la càrrega dels fitxers.";
    }
}
?>
