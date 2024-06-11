<?php
// Set strict types
declare(strict_types=1);

class Nummer {
    /** @var int|null Het ID van de persoon */
    private ?int $ID;

    /** @var string De voornaam van de persoon */
    private string $AlbumID;

    /** @var string De achternaam van de persoon */
    private string $Titel;

    /** @var string|null Het telefoonnummer van de persoon */
    private ?string $Duur;

    /** @var string|null Het e-mailadres van de persoon */
    private ?string $URL;

    /**
     * Constructor voor het maken van een Persoon object.
     *
     * @param int|null $ID Het ID van de persoon.
     * @param string $AlbumID De voornaam van de persoon.
     * @param string $Titel De achternaam van de persoon.
     * @param string|null $Duur Het telefoonnummer van de persoon (optioneel).
     * @param string|null $URL Het e-mailadres van de persoon (optioneel).
     */
    public function __construct(?int $ID, string $AlbumID, string $Titel, ?string $Duur,
                                ?string $URL)

    {
        $this->ID = $ID;
        $this->AlbumID = $AlbumID;
        $this->Titel = $Titel;
        $this->Duur = $Duur;
        $this->URL = $URL;
    }

    /**
     * Haalt alle personen op uit de database.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @return Nummer[] Een array van Persoon-objecten.
     */
    public static function getAll(PDO $db): array
    {
        // Voorbereiden van de query
        $stmt = $db->query("SELECT * FROM Nummer");

        // Array om personen op te slaan
        $Nummer = [];

        // Itereren over de resultaten en personen toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nummers = new Nummer(
                $row['ID'],
                $row['AlbumID'],
                $row['Titel'],
                $row['Duur'],
                $row['URL'],
            );
            $Nummer[] = $nummers;
        }

        // Retourneer array met personen
        return $Nummer;
    }

    /**
     * Zoek personen op basis van id.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @param int $id Het unieke ID van een persoon waarnaar we zoeken.
     * @return Persoon|null Het gevonden Persoon-object of null als er geen overeenkomstige persoon werd gevonden.
     * */
    public static function findById(PDO $db, int $id): ?Nummer
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM persoon WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Retourneer een persoon als gevonden, anders null
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Nummer(
                $row['id'],
                $row['voornaam'],
                $row['achternaam'],
                $row['telefoonnummer'],
                $row['email'],
                $row['opmerkingen']
            );
        } else {
            return null;
        }
    }

    /**
     * Zoek personen op basis van achternaam.
     *
     * @param PDO $db De PDO-databaseverbinding.
     * @param string $achternaam De achternaam om op te zoeken.
     * @return array Een array van Persoon objecten die aan de zoekcriteria voldoen.
     */
    public static function findByAchternaam(PDO $db, string $achternaam): array
    {
        //Zet de achternaam eerst om naar lowercase letters
        $achternaam = strtolower($achternaam);

        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM persoon WHERE LOWER(achternaam) LIKE :achternaam");

        // Voeg wildcard toe aan de achternaam
        $achternaam = "%$achternaam%";

        // Bind de achternaam aan de query en voer deze uit
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->execute();

        // Array om personen op te slaan
        $personen = [];

        // Itereren over de resultaten en personen toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $personen[] = new Nummer(
                $row['id'],
                $row['voornaam'],
                $row['achternaam'],
                $row['telefoonnummer'],
                $row['email'],
                $row['opmerkingen']
            );
        }

        // Retourneer array met personen
        return $personen;
    }

    // Methode om een nieuwe persoon toe te voegen aan de database
    public function save(PDO $db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("INSERT INTO Nummer (AlbumID, Titel, Duur, URL) VALUES (:AlbumID, :Titel, :Duur, :URl)");
        $stmt->bindParam(':AlbumID', $this->AlbumID);
        $stmt->bindParam(':Titel', $this->Titel);
        $stmt->bindParam(':Duur', $this->Duur);
        $stmt->bindParam(':URL', $this->URL);
        $stmt->execute();
    }

    // Methode om een bestaande persoon bij te werken op basis van ID
    public function update(PDO $db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("UPDATE Nummer SET AlbumID = :AlbumID, Titel = :Titel, Duur = :Duur, URL = :URL WHERE id = :id");
        $stmt->bindParam(':ID', $this->ID);
        $stmt->bindParam(':AlbumID', $this->AlbumID);
        $stmt->bindParam(':Titel', $this->Titel);
        $stmt->bindParam(':Duur', $this->Duur);
        $stmt->bindParam(':URL', $this->URL);
        $stmt->execute();
    }

    // Getters
    public function getId(): ?int
    {
        return $this->ID;
    }

    public function getVoornaam(): string
    {
        return $this->AlbumID;
    }

    public function getAchternaam(): string
    {
        return $this->Titel;
    }

    public function getTelefoonnummer(): ?string
    {
        return $this->Duur;
    }

    public function getEmail(): ?string
    {
        return $this->URL;
    }


    // Setters
    public function setVoornaam(string $voornaam): void
    {
        $this->voornaam = $voornaam;
    }

    public function setAchternaam(string $achternaam): void
    {
        $this->achternaam = $achternaam;
    }

    public function setTelefoonnummer(string $telefoonnummer): void
    {
        $this->telefoonnummer = $telefoonnummer;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setOpmerkingen(string $opmerkingen): void
    {
        $this->opmerkingen = $opmerkingen;
    }
}
