<?php
require '../src/Carro.php';

$carro = new Carro();

$chassi = '';
$modelo = '';
$marca = '';
$cor = '';
$idCarro = ''; 
$acao = 'cadastrar';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['acao'])) {
        $chassi = $_POST['chassi'] ?? '';
        $modelo = $_POST['modelo'] ?? '';
        $marca = $_POST['marca'] ?? '';
        $cor = $_POST['cor'] ?? '';

        if ($_POST['acao'] === 'cadastrar') {
            $carro->inserir($chassi, $modelo, $marca, $cor);
        } elseif ($_POST['acao'] === 'atualizar') {
            $carro->atualizar($chassi, $modelo, $marca, $cor);
        } elseif ($_POST['acao'] === 'deletar') {
            $idCarro = $_POST['idcarro'] ?? ''; 
            $carro->deletar($idCarro);
        }
    }
}

$carros = $carro->listar();

if (isset($_POST['acao']) && $_POST['acao'] === 'editar') {
    $chassi = $_POST['chassi'] ?? '';
    $carroData = $carro->buscarPorChassi($chassi);
    if ($carroData) {
        $modelo = $carroData['modelo'] ?? '';
        $marca = $carroData['marca'] ?? '';
        $cor = $carroData['cor'] ?? '';
        $idCarro = $carroData['idcarro'] ?? '';
        $acao = 'atualizar';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/cadCarro.css">
    <title>Cadastro de Carro</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Cadastro de Carro</h2>
            <form method="post" action="">
                <label for="chassi">Chassi:</label>
                <input type="text" name="chassi" value="<?php echo htmlspecialchars($chassi); ?>" required><br>

                <label for="modelo">Modelo:</label>
                <input type="text" name="modelo" value="<?php echo htmlspecialchars($modelo); ?>" required><br>

                <label for="marca">Marca:</label>
                <input type="text" name="marca" value="<?php echo htmlspecialchars($marca); ?>" required><br>

                <label for="cor">Cor:</label>
                <input type="text" name="cor" value="<?php echo htmlspecialchars($cor); ?>" required><br>

                <input type="hidden" name="acao" value="<?php echo htmlspecialchars($acao); ?>">
                <input type="hidden" name="idcarro" value="<?php echo htmlspecialchars($idCarro); ?>"> 
                <input type="submit" value="<?php echo ($acao === 'atualizar') ? 'Atualizar Carro' : 'Cadastrar Carro'; ?>">
            </form>
        </div>

        <div class="table-container">
            <h2>Lista de Carros</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Chassi</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Cor</th>
                    <th>Opções</th>
                </tr>
                <?php foreach ($carros as $c): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c['idcarro']); ?></td> 
                        <td><?php echo htmlspecialchars($c['chassi']); ?></td>
                        <td><?php echo htmlspecialchars($c['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($c['marca']); ?></td>
                        <td><?php echo htmlspecialchars($c['cor']); ?></td>
                        <td>
                            <form method="post" action="" style="display: inline-block;">
                                <input type="hidden" name="chassi" value="<?php echo htmlspecialchars($c['chassi']); ?>">
                                <input type="hidden" name="acao" value="editar">
                                <input type="submit" value="Editar">
                            </form>
                            <form method="post" action="" style="display: inline-block;">
                                <input type="hidden" name="idcarro" value="<?php echo htmlspecialchars($c['idcarro']); ?>">
                                <input type="hidden" name="acao" value="deletar">
                                <input type="submit" value="Deletar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
