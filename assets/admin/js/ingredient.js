

$('#add-ingredient').click(function(){
    // Je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    // Je récupère le prototype des entrées
    const tmpl = $('#recipe_ingredient').data('prototype').replace(/__name__/g, index);

    // J'injecte ce code au sein de la div
    $('#recipe_ingredient').append(tmpl);

    $('#widgets-counter').val(index + 1);

    // Je gère le bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const $select = document.querySelector('.composant-path');
        $select.value = null;
        const target = this.dataset.target;
        $(target).addClass('d-none');
    });
}

function updateCounter() {
    const count = +$('#recipe_ingredient div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();