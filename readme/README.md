# Documentation du projet CRUD

## 1. Introduction au projet
Le projet CRUD (Create, Read, Update, Delete) est une application web simple permettant de gérer des utilisateurs. Il a été conçu pour démontrer les concepts fondamentaux de la gestion des données dans une base de données relationnelle. Ce projet est idéal pour les débutants souhaitant apprendre les bases du développement web et de la manipulation des bases de données.

### Objectifs du projet
- Apprendre à manipuler une base de données avec PHP.
- Comprendre les opérations CRUD.
- Créer une interface utilisateur simple et intuitive.

---

## 2. Technologies utilisées

### Langages de programmation
- **PHP** : Utilisé pour la logique côté serveur et la manipulation de la base de données.
- **HTML** : Structure de la page web.
- **CSS** : Mise en forme de l'interface utilisateur (avec Tailwind CSS).
- **JavaScript** : Gestion des interactions dynamiques (ex. modales).

### Frameworks et bibliothèques
- **Tailwind CSS** : Framework CSS pour un design rapide et moderne.

### Outils
- **WAMP** : Serveur local pour exécuter le projet.
- **MySQL** : Base de données relationnelle pour stocker les informations des utilisateurs.

---

## 3. Fonctionnalités principales

### Opérations CRUD
1. **Créer** : Ajouter un nouvel utilisateur avec des informations comme le nom, le prénom, l'âge, l'adresse et l'email.
2. **Lire** : Afficher la liste des utilisateurs enregistrés dans la base de données.
3. **Mettre à jour** : Modifier les informations d'un utilisateur existant.
4. **Supprimer** : Supprimer un utilisateur de la base de données.

---

## 4. Structure du projet

### Organisation des fichiers
- **index.php** : Page principale gérant les actions CRUD.
- **mesFonctionsSQL.php** : Contient les fonctions PHP pour interagir avec la base de données.
- **testConnection.php** : Vérifie la connexion à la base de données.
- **updateUser.php** : Gère la mise à jour des utilisateurs.
- **info/** : Contient des fichiers auxiliaires comme les scripts SQL pour créer la base de données.

---

## 5. Guide d'installation et d'exécution

### Prérequis
- Installer WAMP (ou un équivalent comme XAMPP).
- Télécharger le projet et le placer dans le dossier `www` de WAMP.

### Étapes
1. Démarrer WAMP et accéder à `http://localhost/phpmyadmin`.
2. Importer le fichier `crud.sql` dans une nouvelle base de données.
3. Configurer les informations de connexion dans `mesFonctionsSQL.php`.
4. Accéder à `http://localhost/CRUD/index.php` pour utiliser l'application.

---

## 6. Explication du code

### Gestion des actions CRUD
Dans `index.php`, le paramètre `action` est utilisé pour déterminer quelle opération effectuer :
- `create` : Ajoute un utilisateur.
- `read` : Affiche les utilisateurs.
- `update` : Modifie un utilisateur.
- `delete` : Supprime un utilisateur.

### Exemple de fonction PHP
```php
function createUser($nom, $prenom, $age, $adresse, $email) {
    $sql = "INSERT INTO utilisateurs (nom, prenom, age, adresse, email) VALUES (?, ?, ?, ?, ?)";
    // Préparation et exécution de la requête...
}
```

---

## 7. Exemples d'utilisation

### Ajouter un utilisateur
1. Cliquez sur "Créer un utilisateur".
2. Remplissez le formulaire et validez.

### Modifier un utilisateur
1. Cliquez sur "Modifier" à côté d'un utilisateur.
2. Modifiez les informations et enregistrez.

### Supprimer un utilisateur
1. Cliquez sur "Supprimer" à côté d'un utilisateur.
2. Confirmez la suppression.

---

## 8. Améliorations possibles
- Ajouter une validation côté serveur pour les formulaires.
- Implémenter une pagination pour la liste des utilisateurs.
- Ajouter une fonctionnalité de recherche.
- Améliorer la sécurité (ex. protection contre les injections SQL).

---

Cette documentation est conçue pour guider les utilisateurs novices et les membres du jury dans la compréhension et l'utilisation du projet CRUD.