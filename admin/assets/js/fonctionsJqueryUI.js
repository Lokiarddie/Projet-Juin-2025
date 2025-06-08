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
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('modifier-produit-form');
    const messageDiv = document.getElementById('update-message');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('src/php/ajax/ajax_update_produit.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(data => {
                if (data.trim() === 'success') {
                    messageDiv.textContent = '✅ Produit mis à jour avec succès.';
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
                    alert('❌ Erreur : ' + data);
                }
            })
            .catch(err => {
                alert('Erreur AJAX : ' + err);
            });
    });
});


//Ajouter au panier un produit
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-to-cart-form');
    const messageDiv = document.getElementById('add-to-cart-message');

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



