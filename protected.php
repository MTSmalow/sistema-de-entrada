<?php
session_start();
require 'vendor/autoload.php';
require 'processos/noticias.php';
require 'processos/db_connect.php';
require 'processos/pendencias.php';
require 'processos/mensagens.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT email,username, codigo_unico FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

if (!$usuario) {
    die('Erro: Usuário não encontrado.');
}

$data_inicio_semana = date('Y-m-d', strtotime('monday this week'));
$data_fim_semana = date('Y-m-d', strtotime('sunday this week'));

$sql = "SELECT data FROM presencas WHERE user_id = ? AND data BETWEEN ? AND ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['usuario_id'], $data_inicio_semana, $data_fim_semana]);
$presencas = $stmt->fetchAll(PDO::FETCH_COLUMN);

$dias_semana = [];
for ($i = 0; $i < 7; $i++) {
    $dias_semana[] = date('Y-m-d', strtotime("monday this week +$i days"));
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presenças</title>
    <link rel="stylesheet" href="css/protected.css">
</head>

<body>
    <div class="card principal">
        <div class="card-mask">
            <img src="img/user.png" alt="Foto do perfil" class="card-img" />
        </div>
        <h3>Bem-vindo, <?php echo htmlspecialchars($usuario['username']); ?>!</h3>
        <div class="card_text">
            <p>Seu código: <strong><?php echo htmlspecialchars($usuario['codigo_unico']); ?></strong></p>
            <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>
            <a href="cracha.php">cracha</a>
        </div>
    </div>

    <div class="contend">
        <div class="card presenca">
            <h3>Presença desta semana:</h3>
            <div class="checklist">
                <?php foreach ($dias_semana as $dia): ?>
                    <?php $presente = in_array($dia, $presencas); ?>
                    <div class="day">
                        <div class="circle <?php echo $presente ? 'present' : ''; ?>">
                            <?php echo $presente ? '✔️' : ''; ?>
                        </div>
                        <div class="day-name"><?php echo date('D', strtotime($dia)); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <div class="card mensagens">
                <h3>Mensagens:</h3>
                <div class="card-interno mensagen-interna">
                    <table class="tabela">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Mensagem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($mensagens) > 0): ?>
                                <?php foreach ($mensagens as $mensagem): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($mensagem['data_criacao']))); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($mensagem['mensagem']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">Nenhuma mensagem disponível.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="contend">
        <div class="card pendencias">
            <h3>Pendencias:</h3>
            <div class="card-interno">
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Clique para atender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($pendencias) > 0): ?>
                            <?php foreach ($pendencias as $pendencia): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pendencia['descricao']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="1">Nenhuma pendência disponível.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card pendencias">
            <h3>Notícias:</h3>
            <div class="card-interno noticias">
                <table class="tabela">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Assunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($noticias) > 0): ?>
                            <?php foreach ($noticias as $noticia): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($noticia['data']))); ?></td>
                                    <td><?php echo htmlspecialchars($noticia['assunto']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">Nenhuma notícia disponível.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                <?php if ($pagina > 1): ?>
                    <a href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                <?php endif; ?>

                <span>Página <?php echo $pagina; ?> de <?php echo $total_paginas; ?></span>

                <?php if ($pagina < $total_paginas): ?>
                    <a href="?pagina=<?php echo $pagina + 1; ?>">Próxima</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>