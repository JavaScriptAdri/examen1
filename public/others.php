<?php 
include 'includes/header.php'; 
include 'includes/db.php'; 
?>
<main>
    <h1>Altres funcionalitats</h1>

    <!-- Formulari per editar dades -->
    <form id="editForm" method="POST" action="update.php">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Descripció:</label>
        <textarea id="description" name="description"></textarea>
        <button type="submit">Actualitzar</button>
    </form>

    <!-- Llista d'elements de la base de dades -->
    <h2>Llista d'elements</h2>
    <ul id="data-list">
        <?php
        try {
            // Consulta per obtenir els elements de la base de dades
            $stmt = $pdo->query("SELECT * FROM items");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>{$row['name']} - {$row['description']}</li>";
            }
        } catch (PDOException $e) {
            echo "Error al consultar les dades: " . $e->getMessage();
        }
        ?>
    </ul>
</main>

<script>
    // Enviament del formulari amb AJAX
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Evitar el comportament per defecte
        const formData = new FormData(this);
        
        fetch('update.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Actualitzat correctament!');
            // Opcional: Recarregar la llista d'elements
            location.reload();
        })
        .catch(error => {
            alert('Error en actualitzar: ' + error);
        });
    });
</script>
