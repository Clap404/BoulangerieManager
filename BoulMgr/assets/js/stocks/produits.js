function deleteProduct(removeLink)
{
    var functionYes = function(){this.document.location.href = removeLink;};
    popupConfirmation("pop_up", "Confirmer la suppression du produit ?", functionYes);
}
