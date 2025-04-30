<!-- filepath: c:\wamp64\www\CRUD\updateUser.php -->
<?php
require_once 'mesFonctionsSQL.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = !empty($_POST['age']) ? intval($_POST['age']) : null;
    $adresse = !empty($_POST['adresse']) ? $_POST['adresse'] : null;

    try {
        $rowsAffected = updateUser($id, $nom, $prenom, $age, $adresse);
        if ($rowsAffected > 0) {
            echo "Utilisateur mis à jour avec succès.";
        } else {
            echo "Aucune modification effectuée.";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>