<?php
include '../../config/db.php'; // Assegura't que $pdo és una instància de PDO

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
            $stmt = $pdo->prepare("
                INSERT INTO usuaris (nom, cognoms, nom_dusuari, email, contrasenya) 
                VALUES (:nom, :cognoms, :nom_dusuari, :email, :contrasenya)
            ");

            // Executa la consulta amb els paràmetres
            $stmt->execute([
                ':nom' => $nom,
                ':cognoms' => $cognoms,
                ':nom_dusuari' => $nom_dusuari,
                ':email' => $email,
                ':contrasenya' => $contrasenya
            ]);

            // Obté l'últim ID inserit
            $usuari_id = $pdo->lastInsertId();

            // Inicia la sessió i guarda l'ID de l'usuari
            session_start();
            $_SESSION['usuari_id'] = $usuari_id;

            // Redirigeix a perfil.php
            header("Location: ../perfil.php");
            exit();
        } catch (PDOException $e) {
            // Si hi ha un error, mostra el missatge
            echo "Error al registrar-se: " . $e->getMessage();
        }
    }
}
?>
