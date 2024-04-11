<?php

$friendly_error_messages = [
    '/SQLSTATE\[23000\]: Integrity constraint violation: 1062 Duplicate entry/' => 'Cet email est déjà utilisé',
    '/SQLSTATE\[HY000\]: General error/' => 'Erreur lors de l\'enregistrement de l\'utilisateur',
    '/Error\[ID\]/' => 'Veuillez entrer un ID',
    '/Error\[NOM\]/' => 'Veuillez entrer un nom',
    '/Error\[PRENOM\]/' => 'Veuillez entrer un prénom',
    '/Error\[EMAIL\]/' => 'Veuillez entrer une adresse email valide',
    '/Error\[PASSWORD\]/' => 'Veuillez entrer un mot de passe',
    '/Error\[PASSWORD_CONFIRM\]/' => 'Veuillez confirmer votre mot de passe',
    '/Error\[ROLE\]/' => 'Veuillez entrer un rôle',
    '/Error\[HASH\]/' => 'Erreur lors du hachage du mot de passe',
    '/Error\[PASSWORD_COMPLEXITY\]/' => 'Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre',
    '/Error\[REGISTER\]/' => 'Erreur lors de l\'enregistrement de l\'utilisateur',
    '/Error\[CONNEXION\]/' => 'Email ou mot de passe incorrect',

    '/Error\[DESCRIPTION\]/' => 'Veuillez entrer une description',
    '/Error\[PRIX\]/' => 'Veuillez entrer un prix',
    '/Error\[CATEGORIE\]/' => 'Veuillez entrer une catégorie',
    '/Error\[IMAGE\]/' => 'Veuillez entrer une image',
    '/Error\[ADD_PRODUCT\]/' => 'Erreur lors de l\'ajout du produit',
    '/Error\[UPLOAD_IMAGE\]/' => 'Erreur lors de l\'upload de l\'image',
    '/Error\[INVALID_IMAGE_TYPE\]/' => 'Le type de fichier n\'est pas valide',

];
function translateErrorMessage($error_message) {
    global $friendly_error_messages;
    foreach ($friendly_error_messages as $technical_error_message => $friendly_error_message) {
        if (preg_match($technical_error_message, $error_message)) {
            return $friendly_error_message;
        }
    }
}
