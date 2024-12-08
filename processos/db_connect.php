<?php
$host = 'localhost';
$db = 'sistema_entrada';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;charset=$charset";
$options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Conexão inicial sem banco de dados para criar o banco, caso não exista
     $pdo = new PDO($dsn, $user, $pass, $options);

    // Cria o banco de dados se não existir
     $queryCreateDB = "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci";
     $pdo->exec($queryCreateDB);

    // Conecta ao banco recém-criado
     $pdo->exec("USE $db");

    // Criação da tabela 'users'
     $queryUsers = "
          CREATE TABLE IF NOT EXISTS users (
               id INT NOT NULL AUTO_INCREMENT,
               username VARCHAR(50) NOT NULL,
               email VARCHAR(100) NOT NULL,
               hash_username_password VARCHAR(64) NOT NULL,
               hash_email_password VARCHAR(64) NOT NULL,
               codigo_unico INT NOT NULL,
               PRIMARY KEY (id),
               UNIQUE KEY codigo_unico (codigo_unico)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
     ";
     $pdo->exec($queryUsers);

    // Criação da tabela 'presencas'
     $queryPresencas = "
          CREATE TABLE IF NOT EXISTS presencas (
               id INT NOT NULL AUTO_INCREMENT,
               user_id INT NOT NULL,
               data DATE NOT NULL,
               PRIMARY KEY (id),
               UNIQUE KEY user_id (user_id, data),
               FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
     ";
     $pdo->exec($queryPresencas);

} catch (PDOException $e) {
     die("Erro ao conectar ou configurar o banco de dados: " . $e->getMessage());
}
?>
