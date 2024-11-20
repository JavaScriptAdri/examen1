<?php
// Inicia la sessió
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclou la connexió a la base de dades
include 'includes/db.php'; // Es pressuposa que $pdo està definit com a instància de PDO

// Processa el formulari només si es fa un POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obté les dades del formulari
    $nom = $_POST['nom'];
    $cognoms = $_POST['cognoms'];
    $nom_dusuari = $_POST['nom_dusuari'];
    $email = $_POST['email'];
    $contrasenya = password_hash($_POST['contrasenya'], PASSWORD_BCRYPT);

    // Comprova si els camps obligatoris estan complets
    if (empty($nom) || empty($cognoms) || empty($nom_dusuari) || empty($email) || empty($contrasenya)) {
        echo "Tots els camps són obligatoris.";
    } else {
        try {
            // Prepara la consulta d'inserció
            $stmt = $pdo->prepare("INSERT INTO usuaris (nom, cognoms, nom_dusuari, email, contrasenya) VALUES (?, ?, ?, ?, ?)");

            // Executa la consulta amb els paràmetres
            $stmt->execute([$nom, $cognoms, $nom_dusuari, $email, $contrasenya]);

            // Obté l'ID de l'últim usuari registrat
            $usuari_id = $pdo->lastInsertId();

            // Guarda l'ID de l'usuari a la sessió
            $_SESSION['usuari_id'] = $usuari_id;

            // Redirigeix a la pàgina de perfil
            header("Location: perfil.php");
            exit();
        } catch (PDOException $e) {
            // Mostra un missatge d'error si alguna cosa falla
            echo "Error al registrar-se: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registra't</title>
    <link rel="stylesheet" href="/public/css/register.css">
</head>
<body>

    <div class="register-container">
        <h2>Registra't</h2>
        <form action="/public/includes/controlRegister.php" method="POST" class="register-form">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="cognoms" placeholder="Cognoms" required>
            <input type="text" name="nom_dusuari" placeholder="Nom d'usuari" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="contrasenya" placeholder="Contrasenya" required>
            <button type="submit">Registrar-se</button>
        </form>
    </div>
</body>
</html>
