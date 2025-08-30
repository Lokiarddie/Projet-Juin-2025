$(document).ready(function () {

    $('#deconnect').hide();

})

//suppression produit
document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.getElementById('delete-btn');
    const messageDiv = document.getElementById('delete-message');

    if (!deleteBtn) return;

    deleteBtn.addEventListener('click', function () {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) return;
        fetch('../admin/src/php/ajax/ajax_delete_produit.php', {

            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(produitId)
        })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === 'success') {
                    messageDiv.textContent = '✅ Produit supprimé avec succès.';
                    messageDiv.style.display = 'block';

                    // Animation fade out de la zone produit
                    const container = document.querySelector('.container');
                    if (container) {
                        container.style.transition = 'opacity 1s ease';
                        container.style.opacity = '0';
                        setTimeout(() => {
                            container.innerHTML = '';
                            // Redirection après 1 seconde
                            window.location.href = 'index_.php?page=produit.php';
                        }, 1000);
                    }
                } else {
                    alert('Erreur lors de la suppression : ' + data);
                }
            })
            .catch(err => {
                alert('Erreur AJAX : ' + err);
            });
    });
});



//modification produit
document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('edit-all-btn');
    if (!editBtn) return;

    let editing = false; // état toggle

    editBtn.addEventListener('click', () => {
        const spans = document.querySelectorAll('.editable');
        if (spans.length === 0) return;

        if (!editing) {
            spans.forEach(span => span.setAttribute('contenteditable', 'true'));
            spans[0].focus();
            editBtn.textContent = '💾 Confirmer';
            editing = true;
        } else {
            spans.forEach(span => span.setAttribute('contenteditable', 'false'));
            editBtn.textContent = '✏️ Modifier';
            editing = false;

            // envoyer tous les champs modifiés
            spans.forEach(span => {
                const id = span.dataset.id;
                const champ = span.dataset.champ;
                const valeur = span.innerText.trim();

                fetch('/TI2/projet_juin/admin/src/php/ajax/ajax_update_produit.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id, champ, valeur })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error(`Erreur serveur : ${data.error}`);
                            alert(`Erreur lors de la mise à jour de ${champ} : ${data.error}`);
                        }
                    })
                    .catch(err => console.error('Erreur fetch :', err));
            });
        }
    });

    document.addEventListener('focusout', function(e) {
        if (!e.target.classList.contains('editable')) return;

        const span = e.target;
        const id = span.dataset.id;
        const champ = span.dataset.champ;
        const valeur = span.innerText.trim();

        fetch('src/php/ajax/ajax_update_produit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, champ, valeur })
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error(`Erreur serveur : ${data.error}`);
                    alert(`Erreur lors de la mise à jour de ${champ} : ${data.error}`);
                }
            })
            .catch(err => console.error('Erreur fetch :', err));
    });
});






//Ajouter au panier un produit
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-to-cart-form');
    const messageDiv = document.getElementById('add-to-cart-message');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Stop reload

        const formData = new FormData(form);

        fetch('admin/src/php/ajax/ajax_add_to_cart.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    messageDiv.textContent = "Produit ajouté au panier !";

                } else {
                    messageDiv.textContent = "Erreur : " + data;
                    messageDiv.style.color = "red";
                }
            })
            .catch(error => {
                messageDiv.textContent = "Erreur AJAX : " + error;
                messageDiv.style.color = "red";
            });
    });
});

//supprimer un produit du panier + mettre à jours le total
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.delete-from-cart-btn');
    if (buttons.length === 0) return;

    function mettreAJourTotal() {
        let total = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const sousTotalTexte = row.cells[3].textContent.replace(/\s/g, '').replace(',', '.').replace('€', '');
            const sousTotal = parseFloat(sousTotalTexte);
            if (!isNaN(sousTotal)) {
                total += sousTotal;
            }
        });
        const totalElem = document.getElementById('total-panier');
        totalElem.textContent = 'Total : ' + total.toFixed(2).replace('.', ',') + ' €';
    }

    document.querySelectorAll('.delete-from-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const produitId = this.dataset.id;

            if (!confirm('Voulez-vous vraiment supprimer ce produit du panier ?')) return;

            fetch('admin/src/php/ajax/ajax_remove_from_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id_produit=' + encodeURIComponent(produitId)
            })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        const row = this.closest('tr');
                        if (row) row.remove();

                        const messageDiv = document.getElementById('message');
                        messageDiv.textContent = "Produit supprimé du panier.";
                        messageDiv.style.color = "green";

                        mettreAJourTotal();
                    } else {
                        alert('Erreur lors de la suppression : ' + data);
                    }
                })
                .catch(err => alert('Erreur AJAX : ' + err));
        });
    });
});



