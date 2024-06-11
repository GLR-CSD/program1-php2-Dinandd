<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personenlijst</title>
    <link rel="stylesheet" href="public/css/simple.css">
</head>
<body>
<h1>Nummerlijst</h1>
<table>
    <tr>
        <th>ID</th>
        <th>AlbumID</th>
        <th>Titel</th>
        <th>Duur</th>
        <th>URL</th>
    </tr>
    <?php foreach ($nummers as $Nummer): ?>
        <tr>
            <td><?= $Nummer->getId() ?></td>
            <td><?= $Nummer->getVoornaam() ?></td>
            <td><?= $Nummer->getAchternaam() ?></td>
            <td><?= $Nummer->getTelefoonnummer() ?></td>
            <td><?= $Nummer->getEmail() ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="notice">
    <h2>Nummer Toevoegen:</h2>
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="nummer_verwerk.php" method="post">
        <label for="voornaam">AlbumID:</label>
        <input type="text" id="voornaam" name="AlbumID" value="<?= $formValues['AlbumId'] ?? '' ?>" required>
        <?php if (isset($errors['voornaam'])): ?>
            <span style="color: red;"><?= $errors['voornaam'] ?></span>
        <?php endif; ?><br>

        <label for="achternaam">Titel:</label>
        <input type="text" id="achternaam" name="Titel" value="<?= $formValues['Titel'] ?? '' ?>"  required>
        <?php if (isset($errors['achternaam'])): ?>
            <span style="color: red;"><?= $errors['achternaam'] ?></span>
        <?php endif; ?><br>

        <label for="telefoonnummer">Duur:</label>
        <input type="text" id="telefoonnummer" name="Duur" value="<?= $formValues['Duur'] ?? '' ?>">
        <?php if (isset($errors['telefoonnummer'])): ?>
            <span style="color: red;"><?= $errors['telefoonnummer'] ?></span>
        <?php endif; ?><br>

        <label for="email">URL:</label>
        <input type="text" id="email" name="URL" value="<?= $formValues['URL'] ?? '' ?>">
        <?php if (isset($errors['email'])): ?>
            <span style="color: red;"><?= $errors['email'] ?></span>
        <?php endif; ?><br>
        <input type="submit" value="Toevoegen">
    </form>
</div>

</body>
</html>
