<?php

/**
 * Récupère tous les enregistrements de la table origins
 */
function getAllOrigins()
{
    // Construction du Data Source Name
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    $sql = 'SELECT *
            FROM origins
            ORDER BY origin_label'; // Correction ici

    $query = $pdo->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}

/**
 * Ajoute un abonné à la liste des emails
 */
function addSubscriber(string $email, string $firstname, string $lastname, int $originId)
{
    // Construction du Data Source Name
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    // Insertion de l'email dans la table subscribers
    $sql = 'INSERT INTO subscribers
    (email, first_name, last_name, origin_id, created_on) 
    VALUES (?,?,?,?, NOW())'; // Correction ici

    $query = $pdo->prepare($sql);
    $query->execute([$email, $firstname, $lastname, $originId]);
    
    }
