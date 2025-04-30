<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=crud;charset=utf8", "root", "");
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}