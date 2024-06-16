<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h2>Ajeuter un Contact</h2>
    <form method="post" action="">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prenom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="telephone">Telephone:</label>
        <input type="text" id="telephone" name="telephone" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Ajeuter un Contact">
    </form>

    <h2>List de Contact</h2>
    <pre>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    
    $filename = "contacts.txt";

    
    if (!file_exists($filename)) {
       
        $file = fopen($filename, "w");
    } else {
        
        $file = fopen($filename, "a");
    }

    if ($file) {
     
        $contactString = "$nom,$prenom,$telephone,$email\n";
        for ($i = 0; $i < strlen($contactString); $i++) {
            fwrite($file, $contactString[$i]);
        }
        fclose($file);
    } else {
        echo "Error: Unable to open the file for writing.";
    }
}


$filename = "contacts.txt";
if (file_exists($filename)) {
    $file = fopen($filename, "r");
    if ($file) {
      
        $contactData = '';
        while (!feof($file)) {
            $contactData .= fgetc($file);
        }
        fclose($file);

        
        $lines = explode("\n", $contactData);
        foreach ($lines as $line) {
            $contactFields = explode(",", $line);
            if (count($contactFields) == 4) {
                echo "Nom: " . $contactFields[0] . "\n";
                echo "Prenom: " . $contactFields[1] . "\n";
                echo "Telephone: " . $contactFields[2] . "\n";
                echo "Email: " . $contactFields[3] . "\n";
                echo "<button>Modifier</button> <button>effacer</button>";
                echo "-------------------\n";
            }
        }
    } else {
        echo "Error: Unable to open the file for reading.";
    }
} else {
    echo "No contacts found.\n";
}
?>
    </pre>
</body>
</html>
