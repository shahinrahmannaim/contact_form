<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
</head>
<body>
    <h2>Formulaire de contact</h2>

    <?php
    // Define the contacts file
    $contactsFile = 'contacts.txt';

    // Initialize variables
    $contacts = [];
    $edit_mode = false;
    $id = '';

    // Function to load contacts from file
    function loadContacts($file) {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    // Function to save contacts to file
    function saveContacts($file, $contacts) {
        file_put_contents($file, implode(PHP_EOL, $contacts) . PHP_EOL);
    }

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Load contacts from file
        $contacts = loadContacts($contactsFile);

        if ($action == 'add') {
            // Adding a new contact
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $telephone = $_POST['telephone'];
            $email = $_POST['email'];

            // Create new contact entry
            $newContact = "$nom|$prenom|$telephone|$email";
            $contacts[] = $newContact;

            // Save contacts back to file
            saveContacts($contactsFile, $contacts);

            // Redirect to avoid form resubmission
            header("Location: index.php");
            exit();
        } elseif ($action == 'edit') {
            // Editing an existing contact
            $id = $_POST['id'];
            if (isset($contacts[$id])) {
                list($nom, $prenom, $telephone, $email) = explode('|', $contacts[$id]);
                // Set variables for edit mode
                $edit_mode = true;
            }
        } elseif ($action == 'update') {
            // Updating an existing contact
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $telephone = $_POST['telephone'];
            $email = $_POST['email'];

            // Update the contact in the array
            if (isset($contacts[$id])) {
                $contacts[$id] = "$nom|$prenom|$telephone|$email";
                // Save contacts back to file
                saveContacts($contactsFile, $contacts);
                // Clear edit mode
                $edit_mode = false;
            }

            // Redirect to avoid form resubmission
            header("Location: index.php");
            exit();
        } elseif ($action == 'cancel') {
            // Cancel editing mode
            $edit_mode = false;
        } elseif ($action == 'delete') {
            // Deleting a contact
            $id = $_POST['id'];
            if (isset($contacts[$id])) {
                unset($contacts[$id]);
                // Save contacts back to file
                saveContacts($contactsFile, $contacts);
            }

            // Redirect to avoid form resubmission
            header("Location: index.php");
            exit();
        }
    }

    // Reload contacts after actions
    $contacts = loadContacts($contactsFile);
    ?>

    <!-- Contact Form -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" value="<?php echo isset($nom) ? htmlspecialchars($nom) : ''; ?>" required><br><br>
        <label for="prenom">Prénom:</label><br>
        <input type="text" id="prenom" name="prenom" value="<?php echo isset($prenom) ? htmlspecialchars($prenom) : ''; ?>" required><br><br>
        <label for="telephone">Téléphone:</label><br>
        <input type="text" id="telephone" name="telephone" value="<?php echo isset($telephone) ? htmlspecialchars($telephone) : ''; ?>" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required><br><br>

        <?php if($edit_mode): ?>
            <button type="submit" name="action" value="update">Modifier</button>
            <button type="submit" name="action" value="cancel">Annuler</button>
        <?php else: ?>
            <button type="submit" name="action" value="add">Ajouter</button>
        <?php endif; ?>
    </form>

    <hr>

    <!-- List of Contacts -->
    <h2>Liste des Contacts</h2>
    <ul>
        <?php foreach ($contacts as $index => $contact): ?>
            <?php list($nom, $prenom, $telephone, $email) = explode('|', $contact); ?>
            <li>
                <strong><?php echo htmlspecialchars($nom) . ' ' . htmlspecialchars($prenom); ?></strong><br>
                Téléphone: <?php echo htmlspecialchars($telephone); ?><br>
                Email: <?php echo htmlspecialchars($email); ?><br>
                <form action="" method="post" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?php echo $index; ?>">
                    <button type="submit" name="action" value="edit">Modifier</button>
                </form>
                <form action="" method="post" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?php echo $index; ?>">
                    <button type="submit" name="action" value="delete" >Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
