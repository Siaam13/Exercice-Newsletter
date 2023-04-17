<?php

// Inclusion des dépendances
require 'config.php';
require 'functions.php';

// Nom du fichier CSV que vous souhaitez importer
$filename = $argv[1];

// Vérifier si le fichier existe
if (!file_exists($filename)) {
    echo "Erreur : fichier '$filename' introuvable";
    exit;
}

// Ouvrir le fichier en lecture
$file = fopen($filename, "r");

// Préparer la connexion à la base de données
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Préparer la requête d'insertion
$pdoStatement = $pdo->prepare('INSERT INTO subscribers (created_on, email, firstname, lastname, origin_id) VALUES (?,?,?,?,?)');

// Lire chaque ligne du fichier CSV
while ($row = fgetcsv($file)) {
    // Récupérer les données de chaque colonne
    $created_on = $row[0];
    $email = $row[1];
    $firstname = $row[2];
    $lastname = $row[3];
    $origine_id = $row[4];

    // Exécuter la requête préparée
    $pdoStatement->execute([$created_on, $email, $firstname, $lastname, $origine_id]);
}

echo 'Import terminé!';
