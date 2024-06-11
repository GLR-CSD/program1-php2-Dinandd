<?php
// Start de sessie
// Deze gaan we gebruiken om de form values en de errors op te slaan
session_start();

// Controleer of het verzoek via POST is gedaan
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Valideer de ingediende gegevens
    $errors = [];
    $formValues = [
        'AlbumID' => $_POST['AlbumID'] ?? '',
        'Titel' => $_POST['Titel'] ?? '',
        'Duur' => $_POST['Duur'] ?? '',
        'URL' => $_POST['URL'] ?? '',
    ];

    // Als er geen validatiefouten zijn, voeg de persoon toe aan de database
    if (empty($errors)) {
        require_once 'db.php';
        require_once 'classes/Nummer.php';

        // Maak een nieuw Persoon object met de ingediende gegevens
        $nummer = new Nummer(
            null,
            $_POST['AlbumID'],
            $_POST['Titel'],
            $_POST['Duur'],
            $_POST['URL']
        );

        // Voeg de persoon toe aan de database
        $nummer->save($db);

    } else {
        // Sla de fouten en formulier waarden op in sessievariabelen
        $_SESSION['errors'] = $errors;
        $_SESSION['formValues'] = $formValues;
    }

    // Stuur de gebruiker terug naar de index.php
    header("Location: nummer.php");
    exit;

} else {
    header("Location: nummer.php");
}