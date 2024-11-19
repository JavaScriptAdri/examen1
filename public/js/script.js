const audio = document.getElementById('audioPlayer');
document.getElementById('play').addEventListener('click', () => audio.play());
document.getElementById('pause').addEventListener('click', () => audio.pause());
document.getElementById('mute').addEventListener('click', () => audio.muted = !audio.muted);
document.addEventListener('DOMContentLoaded', () => {
    const uploadButton = document.getElementById('upload-button');
    const uploadForm = document.getElementById('upload-form');
    const cancelUpload = document.getElementById('cancel-upload');

    // Mostrar el formulari de pujada
    uploadButton.addEventListener('click', () => {
        uploadForm.classList.remove('hidden');
    });

    // Cancel·lar el formulari de pujada
    cancelUpload.addEventListener('click', () => {
        uploadForm.classList.add('hidden');
    });

    // Gestionar l'enviament del formulari de pujada
    const songUploadForm = document.getElementById('song-upload-form');
    songUploadForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(songUploadForm);
        fetch('upload_song.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Cançó pujada correctament!');
            location.reload();
        })
        .catch(error => {
            console.error('Error en la pujada de la cançó:', error);
        });
    });

    // Edició de cançons amb AJAX
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const title = prompt('Edita el títol:', button.dataset.title);
            const artist = prompt('Edita l\'artista:', button.dataset.artist);

            if (title && artist) {
                fetch('edit_song.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id, title, artist })
                })
                .then(response => response.text())
                .then(data => {
                    alert('Cançó actualitzada correctament!');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error en l\'edició de la cançó:', error);
                });
            }
        });
    });
});
