<?php
use chillerlan\QRCode\{QRCode, QROptions};
require 'vendor/autoload.php';

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require 'processos/db_connect.php'; // Inclui o arquivo de conexão com banco

// Busca informações do usuário no banco de dados
$sql = "SELECT username, email, codigo_unico FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['usuario_id']]);
$users = $stmt->fetch();

if (!$users) {
    die('Erro: Usuário não encontrado.');
}

// Configurações do QR Code
$options = new QROptions([
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel' => QRCode::ECC_L,
    'imageBase64' => true,
    'scale' => 128,
]);

// Gera o QR Code com o código único do usuário
$qrcode = (new QRCode($options))->render($users['codigo_unico']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="css/cracha.css" />
    <title>Cracha - <?php echo htmlspecialchars($users['username']); ?></title>
</head>

<body>
    <div class="container">
        <div class="card-content">
            <div class="card-fita">
                <img src="img/faixa.svg" alt="">
            </div>

            <header class="card-header">
                <span>Cracha</span>

                <div class="card-credential">
                    <span>Codigo: <?php echo htmlspecialchars($users['codigo_unico']); ?></span>
                </div>
            </header>

            <div class="card-data">
                <div class="card-image">
                    <div class="card-mask">
                        <img src="img/user.png" alt="Foto do perfil" class="card-img" />
                    </div>
                </div>

                <h2 class="card-name"><?php echo htmlspecialchars($users['username']); ?></h2>
                <h3 class="card-profession">Aluno</h3>

                <div class="card-qrcode">
                    <!-- Exibe o QR Code do RM do usuário -->
                    <img id="qrcode" src="<?php echo $qrcode; ?>" alt="QR Code do RM">
                </div>

                <a href="protected.php" class="card-button">
                    <img src="img/see.svg" alt="Ver histórico">
                    <span>Ver histórico</span>
                </a>
            </div>
        </div>
    </div>
</body>

</html>