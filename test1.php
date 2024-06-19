<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact-Form</title>
</head>
<body>
<?php  

$contactsfile = "MyContacts.txt";
$contacts = [];
$edit_mode=false;
$id='';

// function pour cree une fichier 
function chargerContact($file){
    return file($file);
}

// function pour sauvegarder les contact
function sauvegarderContact($file,$contacts){
    file_put_contents($file,$contacts);
}
 // gérer la soumission du formulaire
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $_POST['action'] ? $_POST['action'] :'';
    $contacts = chargerContact($contactsfile);

 }




?>







</body>
</html>