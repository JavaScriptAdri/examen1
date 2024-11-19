<?php
// Configuració de la connexió a la base de dades amb PDO
$host = 'db';  // Nom del servei de la base de dades en docker-compose
$dbname = 'projecttest';  // Nom de la base de dades
$user = 'admin';  // Nom d'usuari de la base de dades
$password = 'admin';  // Contrasenya de la base de dades

try {
    // Afegim el joc de caràcters UTF-8 per a evitar problemes d'encoding
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Mostrem un missatge d'error més clar
    echo "Error de connexió a la base de dades: " . $e->getMessage();
    exit();
}

?>
