<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>CaetanoBarberShop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$horas_possiveis = ['10:00', '11:00', '12:00', '13:00', '16:00', '17:00', '18:00', '19:00'];
$horas_ocupadas = [];
$data_escolhida = isset($_GET['data']) ? $_GET['data'] : "";

if (!empty($data_escolhida)) {
    $db = new PDO("sqlite:base_dados.sqlite");
    $stmt = $db->prepare("SELECT hora FROM marcacoes WHERE data = :data");
    $stmt->bindParam(':data', $data_escolhida);
    $stmt->execute();
    $horas_ocupadas = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>
    <div class="container">
        <h1>CaetanoBarberShop</h1>
        <h2>Agendar Corte</h2>
        <form action="guardar.php" method="post">
            
            <label>Nome:<br>
                <input type="text" name="nome" required>
            </label>
            <br><br>

            <label>Serviço:<br>
                <select name="servico" required>
                    <option value="Corte Masculino">Corte Masculino</option>
                    <option value="Barba com toalha quente">Barba com toalha quente</option>
                    <option value="Barba">Barba</option>
                    <option value="lavagem de cabelo">Lavagem de cabelo</option>
                </select>
            </label>
            <br><br>

            <label>Data:<br>
                <input type="date" name="data" required onchange="this.form.submit()" value="<?= htmlspecialchars($data_escolhida) ?>">
                <input type="hidden" name="reload" value="1">
            </label>
            <br><br>

            <label>Hora:<br>
                <select name="hora" required>
                <?php foreach ($horas_possiveis as $hora): ?>
                    <?php if (in_array($hora, $horas_ocupadas)): ?>
                        <option value="<?= $hora ?>" disabled style="text-decoration: line-through; color: #888;">
                            <?= $hora ?> (Ocupado)
                        </option>
                    <?php else: ?>
                        <option value="<?= $hora ?>"><?= $hora ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
                </select>
            </label>
            <br><br>

            <label>Contacto:<br>
                <input type="text" name="contacto" required>
            </label>
            <br><br>

            <button type="submit">Agendar</button>
        </form>
    </div>
</body>
</html>
