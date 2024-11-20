<?php
// Inicia la sessió si no està iniciada
session_start();

// Inclou la connexió a la base de dades
include('includes/db.php');

// Comprova si l'usuari està autenticat
if (!isset($_SESSION['usuari_id'])) {
    // Si no està loguejat, redirigeix a la pàgina d'inici de sessió
    header("Location: /public/login.php");
    exit();
}

// Obté la informació de l'usuari de la base de dades
$usuari_id = $_SESSION['usuari_id'];
$query = "SELECT nom, cognoms, imatge_perfil FROM usuaris WHERE id = :usuari_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':usuari_id', $usuari_id, PDO::PARAM_INT);
$stmt->execute();
$usuari = $stmt->fetch(PDO::FETCH_ASSOC);

// Comprova si s'ha enviat el formulari per editar el perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $cognoms = $_POST['cognoms'];

    // Si es carrega una nova imatge, gestionem la pujada de fitxers
    $imatge_perfil = $usuari['imatge_perfil']; // Manté la imatge actual per defecte

    if (isset($_FILES['imatge_perfil']) && $_FILES['imatge_perfil']['error'] == 0) {
        $imatge_nom = $_FILES['imatge_perfil']['name'];
        $imatge_temp = $_FILES['imatge_perfil']['tmp_name'];
        $imatge_nom_nou = uniqid('profile_') . '_' . $imatge_nom;
        $imatge_destinacio = '../uploads/' . $imatge_nom_nou;

        // Moure la imatge al directori d'uploads
        if (move_uploaded_file($imatge_temp, $imatge_destinacio)) {
            $imatge_perfil = $imatge_nom_nou; // Actualitza el nom de la imatge
        } else {
            echo "Error en pujar la imatge.";
        }
    }

    // Actualitza les dades a la base de dades
    $query = "UPDATE usuaris SET nom = :nom, cognoms = :cognoms, imatge_perfil = :imatge_perfil WHERE id = :usuari_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':cognoms', $cognoms);
    $stmt->bindParam(':imatge_perfil', $imatge_perfil);
    $stmt->bindParam(':usuari_id', $usuari_id, PDO::PARAM_INT);
    $stmt->execute();

    // Actualitza les dades de sessió
    $_SESSION['nom'] = $nom;
    $_SESSION['cognoms'] = $cognoms;
    $_SESSION['imatge_perfil'] = $imatge_perfil;

    // Redirigeix a la pàgina de perfil després de l'actualització
    header("Location: /public/perfil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/editar_perfil.css">
</head>
<body>
    <div class="top_llegenda">
        <!-- Botons de navegació -->
    </div>

    <h1>Editar el teu perfil</h1>

    <form action="editar_perfil.php" method="POST" enctype="multipart/form-data">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($usuari['nom']); ?>" required>
        
        <label for="cognoms">Cognoms:</label>
        <input type="text" name="cognoms" value="<?php echo htmlspecialchars($usuari['cognoms']); ?>" required>
        
        <label for="imatge_perfil">Imatge de perfil:</label>
        <input type="file" name="imatge_perfil" accept="image/*">

        <br><br>
        <button type="submit">Desar els canvis</button>
    </form>

    <br>
    <a href="perfil.php">Tornar al perfil</a>
</body>
</html>
