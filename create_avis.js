document.getElementById('avisForm').addEventListener('submit', async (e) => {
    e.preventDefault();  // Empêche le comportement par défaut du formulaire

    const form = e.target;
    const userId = form.user_id.value.trim();  // Récupère la valeur de l'ID utilisateur
    const message = form.message.value.trim();  // Récupère la valeur du message
    const note = form.note.value.trim();  // Récupère la valeur de la note

    // Vérification des champs vides
    if (!userId || !message || !note) {
        document.getElementById('messageResult').textContent = '❌ Tous les champs doivent être remplis.';
        document.getElementById('messageResult').style.color = 'red';
        return;  // Arrête l'exécution du code si les champs sont vides
    }

    // Vérification que la note est entre 1 et 5
    if (note < 1 || note > 5) {
        document.getElementById('messageResult').textContent = '❌ La note doit être entre 1 et 5.';
        document.getElementById('messageResult').style.color = 'red';
        return;
    }

    // Préparer les données à envoyer
    const data = {
        user_id: userId,
        message: message,
        note: note
    };

    try {
        const res = await fetch('http://localhost/projetcovoiturage/back-end/create_avis.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        if (res.ok) {
            document.getElementById('messageResult').textContent = '✅ Avis envoyé avec succès !';
            document.getElementById('messageResult').style.color = 'green';
            form.reset();  // Réinitialiser le formulaire après l'envoi
        } else {
            document.getElementById('messageResult').textContent = '❌ Erreur : ' + result.error;
            document.getElementById('messageResult').style.color = 'red';
        }
    } catch (err) {
        document.getElementById('messageResult').textContent = '❌ Erreur de connexion';
        document.getElementById('messageResult').style.color = 'red';
    }
});
