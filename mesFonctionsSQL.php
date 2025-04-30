<?php

// Fonction pour se connecter à la base de données

function getDatabaseConnection() { // Correction du nom de la fonction
    $host = 'localhost';
    $dbname = 'crud';
    $username = 'root';
    $password = '';

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        throw new Exception("Erreur de connexion : " . $e->getMessage());
    }
}

$connexion = getDatabaseConnection(); // Correction du nom de la fonction

try {
    $pdo = new PDO("mysql:host=localhost;dbname=crud;charset=utf8", "root", "");
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage(); 
}

// Fonction pour récupérer tous les utilisateurs
function getAllUsers() {
    try {
        $con = getDatabaseConnection();
        $requete = 'SELECT * FROM utilisateurs';
        $stmt = $con->query($requete);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
    }
}

// Fonction pour récupérer un utilisateur par son ID
function readUsers($id) {
    try {
        $con = getDatabaseConnection();
        $requete = 'SELECT * FROM utilisateurs WHERE id = :id';
        $stmt = $con->prepare($requete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
    }
}

// Fonction pour créer un nouvel utilisateur
function createUser($nom, $prenom, $age = null, $adresse = null, $email) {
    try {
        $con = getDatabaseConnection();

        // Vérifier si l'email existe déjà
        $verifRequete = 'SELECT COUNT(*) FROM utilisateurs WHERE email = :email';
        $stmt = $con->prepare($verifRequete);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("L'email existe déjà.");
        }

        // Insérer l'utilisateur
        $requete = 'INSERT INTO utilisateurs (nom, prenom, age, adresse, email) VALUES (:nom, :prenom, :age, :adresse, :email)';
        $stmt = $con->prepare($requete);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $con->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
    }
}

// Fonction pour mettre à jour un utilisateur
/**
 * Met à jour les informations d'un utilisateur dans la base de données.
 *
 * @param int $id L'identifiant de l'utilisateur à mettre à jour.
 * @param string $nom Le nouveau nom de l'utilisateur.
 * @param string $prenom Le nouveau prénom de l'utilisateur.
 * @param int|null $age Le nouvel âge de l'utilisateur (peut être null).
 * @param string|null $adresse La nouvelle adresse de l'utilisateur (peut être null).
 * 
 * @return int Le nombre de lignes affectées par la mise à jour (1 si l'utilisateur a été mis à jour, 0 sinon).
 * 
 * @throws Exception Si une erreur survient lors de la mise à jour de l'utilisateur.
 * 
 * Cette fonction utilise une requête SQL préparée pour éviter les injections SQL.
 * Elle établit une connexion à la base de données via la fonction `getDatabaseConnection()`.
 * Les paramètres sont liés à la requête SQL avec `bindParam` pour sécuriser les données.
 */
function updateUser($id, $nom, $prenom, $age = null, $adresse = null) {
    try {
        // Connexion à la base de données
        $con = getDatabaseConnection();

        // Requête SQL pour mettre à jour un utilisateur
        $requete = 'UPDATE utilisateurs SET nom = :nom, prenom = :prenom, age = :age, adresse = :adresse WHERE id = :id';

        // Préparation de la requête
        $stmt = $con->prepare($requete);

        // Liaison des paramètres à la requête SQL
        // `bindParam` associe une variable PHP à un paramètre nommé ou un point d'interrogation dans la requête SQL.
        // Cela permet de sécuriser les données en empêchant les injections SQL.

        // Liaison de l'identifiant de l'utilisateur
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // PDO::PARAM_INT indique que le paramètre est un entier.

        // Liaison du nom de l'utilisateur
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR); // PDO::PARAM_STR indique que le paramètre est une chaîne de caractères.

        // Liaison du prénom de l'utilisateur
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);

        // Liaison de l'âge de l'utilisateur (peut être null)
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);

        // Liaison de l'adresse de l'utilisateur (peut être null)
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);

        // Exécution de la requête
        $stmt->execute();

        // Retourne le nombre de lignes affectées par la mise à jour
        return $stmt->rowCount();
    } catch (PDOException $e) {
        // En cas d'erreur, une exception est levée avec un message détaillé
        throw new Exception("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
    }
}

// Fonction pour supprimer un utilisateur
/**
 * Supprime un utilisateur de la base de données en fonction de son identifiant.
 *
 * @param int $id L'identifiant de l'utilisateur à supprimer.
 * 
 * @return int Le nombre de lignes affectées par la suppression (1 si l'utilisateur a été supprimé, 0 sinon).
 * 
 * @throws Exception Si une erreur survient lors de la suppression de l'utilisateur.
 * 
 * Cette fonction utilise une requête SQL préparée pour éviter les injections SQL.
 * Elle établit une connexion à la base de données via la fonction `getDatabaseConnection()`.
 * En cas d'erreur, une exception est levée avec un message détaillé.
 */
function deleteUser($id) {
    try {
        $con = getDatabaseConnection();
        $requete = 'DELETE FROM utilisateurs WHERE id = :id';
        $stmt = $con->prepare($requete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
    }
}

    

    //SLQ POUR AJOUTER DES UTILISATEURS
//     INSERT INTO `utilisateurs` (`nom`, `prenom`, `email`, `mot_de_passe`, `date_creation`) VALUES
// ('Dupont', 'Jean', 'jean.dupont@example.com', 'motdepasse1', CURRENT_TIMESTAMP),
// ('Durand', 'Marie', 'marie.durand@example.com', 'motdepasse2', CURRENT_TIMESTAMP),
// ('Lefevre', 'Pierre', 'pierre.lefevre@example.com', 'motdepasse3', CURRENT_TIMESTAMP),
// ('Garcia', 'Sophie', 'sophie.garcia@example.com', 'motdepasse4', CURRENT_TIMESTAMP),
// ('Moreau', 'Thomas', 'thomas.moreau@example.com', 'motdepasse5', CURRENT_TIMESTAMP),
// ('Fournier', 'Isabelle', 'isabelle.fournier@example.com', 'motdepasse6', CURRENT_TIMESTAMP),
// ('Leroy', 'Antoine', 'antoine.leroy@example.com', 'motdepasse7', CURRENT_TIMESTAMP),
// ('Richard', 'Julie', 'julie.richard@example.com', 'motdepasse8', CURRENT_TIMESTAMP),
// ('Petit', 'Nicolas', 'nicolas.petit@example.com', 'motdepasse9', CURRENT_TIMESTAMP),
// ('Simon', 'Camille', 'camille.simon@example.com', 'motdepasse10', CURRENT_TIMESTAMP);

// ajouter age et adresse ALTER TABLE utilisateurs
// ADD age INT NULL,
// ADD adresse VARCHAR(255) NULL;


//---------------------mettre null dans la colonne age et adresse-------------

// Étape 1 : Créer une table avec des colonnes acceptant NULL
// Accédez à phpMyAdmin et sélectionnez votre base de données.
// Cliquez sur "Nouvelle table" pour créer une nouvelle table.
// Remplissez les informations de la table :
// Nom de la table : Par exemple, utilisateurs.
// Colonnes : Définissez le nombre de colonnes.
// Dans la section des colonnes :
// Nom : Entrez le nom de la colonne (par exemple, age ou adresse).
// Type : Sélectionnez le type de données (par exemple, INT pour age, VARCHAR pour adresse).
// Longueur/valeurs : Définissez la longueur si nécessaire (par exemple, 255 pour VARCHAR).
// NULL : Cochez la case "NULL" pour permettre à la colonne d'accepter des valeurs NULL.
// Cliquez sur "Enregistrer" pour créer la table.