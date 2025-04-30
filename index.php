<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Sébastien Marchal</title>
<!-- Inclure Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <!-- Titre principal -->
        <h1 class="text-4xl font-bold text-center text-blue-600 mb-6">CRUD Sébastien Marchal</h1>
        <h2 class="text-2xl text-center mb-4">Bienvenue sur la page d'accueil</h2>
        <p class="text-center mb-6">Cette application vous permet de gérer vos utilisateurs.</p>

        <!-- Liens vers les actions CRUD -->
        <div class="flex justify-center space-x-4 mb-8">
            <a href="#" class="btn-create bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Créer un utilisateur</a>
            <a href="?action=read" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lire les utilisateurs</a>
            <a href="?action=update" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Mettre à jour un utilisateur</a>
            <a href="?action=delete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Supprimer un utilisateur</a>
        </div>

     <!-- Gestion des actions CRUD -->
        <?php
        require_once 'mesFonctionsSQL.php';
    require_once 'testConnection.php';

        // Gestion des actions via le paramètre "action"
        $action = isset($_GET['action']) ? $_GET['action'] : 'read';

        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $age = $_POST['age'] !== '' ? $_POST['age'] : null;
            $adresse = $_POST['adresse'] !== '' ? $_POST['adresse'] : null;
            $email = $_POST['email'];

            $resultat = createUser($nom, $prenom, $age, $adresse, $email);

            if ($resultat) {
                echo "<p class='text-green-500'>Utilisateur créé avec succès !</p>";
            } else {
                echo "<p class='text-red-500'>Erreur lors de la création de l'utilisateur.</p>";
            }

            // Redirection pour mettre à jour la page
            header("Location: index.php");
            exit();
        } elseif ($action === 'read') {
            // Lecture des utilisateurs
            $utilisateurs = getAllUsers();

            if (empty($utilisateurs)) {
                echo "<p class='text-center text-gray-500'>Aucun utilisateur n'est encore inscrit dans la base de données.</p>";
            } else {
                echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>";
                foreach ($utilisateurs as $utilisateur) {
                    ?>
                    <!-- Carte utilisateur -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h3 class="text-lg font-bold text-gray-700">ID : <?= $utilisateur['id'] ?></h3>
                        <p><strong>Nom :</strong> <?= $utilisateur['nom'] ?></p>
<p><strong>Prénom :</strong> <?= $utilisateur['prenom'] ?></p>
<p><strong>Âge :</strong> <?= isset($utilisateur['age']) ? $utilisateur['age'] : 'Non spécifié' ?></p>
                        <p><strong>Adresse :</strong> <?= isset($utilisateur['adresse']) ? $utilisateur['adresse'] : 'Non spécifiée' ?></p>
                        <!-- Boutons d'action -->
                        <div class="mt-4 flex space-x-2">
                            <a href="#" 
                               class="btn-update bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                               data-id="<?= $utilisateur['id'] ?>"
                               data-nom="<?= $utilisateur['nom'] ?>"
                               data-prenom="<?= $utilisateur['prenom'] ?>"
                               data-age="<?= isset($utilisateur['age']) ? $utilisateur['age'] : '' ?>"
                               data-adresse="<?= isset($utilisateur['adresse']) ? $utilisateur['adresse'] : '' ?>">
                               Modifier
                            </a>
                            <a href="?action=delete&id=<?= $utilisateur['id'] ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</a>
                        </div>
                    </div>
                    <?php
                }
                echo "</div>";
            }
        } elseif ($action === 'update' && isset($_GET['id'])) {
            // Exemple de mise à jour d'un utilisateur
            $id = $_GET['id'];
            $utilisateurMisAJour = [
                'nom' => 'Durand',
                'prenom' => 'Marie',
                'age' => 25,
                'adresse' => '456 Rue Exemple'
            ];

            // Passer les valeurs séparément à la fonction updateUser
            $resultat = updateUser(
                $id,
                $utilisateurMisAJour['nom'],
                $utilisateurMisAJour['prenom'],
                $utilisateurMisAJour['age'],
                $utilisateurMisAJour['adresse']
            );

            echo $resultat
                ? "<p class='text-green-500'>Utilisateur mis à jour avec succès !</p>"
                : "<p class='text-red-500'>Erreur lors de la mise à jour de l'utilisateur.</p>";
        } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $age = $_POST['age'] !== '' ? $_POST['age'] : null;
            $adresse = $_POST['adresse'] !== '' ? $_POST['adresse'] : null;

            $resultat = updateUser($id, $nom, $prenom, $age, $adresse);

            if ($resultat) {
                echo "<p class='text-green-500'>Utilisateur mis à jour avec succès !</p>";
            } else {
                echo "<p class='text-red-500'>Erreur lors de la mise à jour de l'utilisateur.</p>";
            }

            // Redirection pour mettre à jour la page
            header("Location: index.php");
            exit();
        } elseif ($action === 'delete' && isset($_GET['id'])) {
            // Suppression d'un utilisateur
            $id = $_GET['id'];
            $resultat = deleteUser($id);

            if ($resultat) {
                echo "<p class='text-green-500'>Utilisateur supprimé avec succès !</p>";
            } else {
                echo "<p class='text-red-500'>Erreur lors de la suppression de l'utilisateur.</p>";
            }

            // Redirection pour mettre à jour la page
            header("Location: index.php");
            exit(); // Assurez-vous de terminer le script après la redirection
        }
        ?>
    </div>

    <!-- Modal pour modifier un utilisateur -->
    <div id="modal-update" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4 text-center">Modifier l'utilisateur</h2>
            <form id="update-form" method="POST" action="index.php?action=update">
                <input type="hidden" name="id" id="update-id">
                <div class="mb-4">
                    <label for="update-nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="nom" id="update-nom" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="update-prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" name="prenom" id="update-prenom" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="update-age" class="block text-sm font-medium text-gray-700">Âge</label>
                    <input type="number" name="age" id="update-age" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="update-adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input type="text" name="adresse" id="update-adresse" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="close-modal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Annuler</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pour créer un utilisateur -->
    <div id="modal-create" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4 text-center">Créer un utilisateur</h2>
            <form id="create-form" method="POST" action="index.php?action=create">
                <div class="mb-4">
                    <label for="create-nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="nom" id="create-nom" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="create-prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" name="prenom" id="create-prenom" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="create-age" class="block text-sm font-medium text-gray-700">Âge</label>
                    <input type="number" name="age" id="create-age" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="create-adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input type="text" name="adresse" id="create-adresse" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="create-email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="create-email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="close-create-modal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Annuler</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Ouvrir la modal avec les informations de l'utilisateur
        document.querySelectorAll('.btn-update').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const userId = this.dataset.id;
                const userNom = this.dataset.nom;
                const userPrenom = this.dataset.prenom;
                const userAge = this.dataset.age || '';
                const userAdresse = this.dataset.adresse || '';

                // Remplir les champs de la modal
                document.getElementById('update-id').value = userId;
                document.getElementById('update-nom').value = userNom;
                document.getElementById('update-prenom').value = userPrenom;
                document.getElementById('update-age').value = userAge;
                document.getElementById('update-adresse').value = userAdresse;

                // Afficher la modal
                document.getElementById('modal-update').classList.remove('hidden');
            });
        });

        // Fermer la modal
        document.getElementById('close-modal').addEventListener('click', function () {
            document.getElementById('modal-update').classList.add('hidden');
        });

        // Ouvrir la modal de création
        document.querySelector('.btn-create').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('modal-create').classList.remove('hidden');
        });

        // Fermer la modal de création
        document.getElementById('close-create-modal').addEventListener('click', function () {
            document.getElementById('modal-create').classList.add('hidden');
        });
    </script>
</body>
</html>