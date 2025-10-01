<?php
require_once __DIR__ . '/conexao.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = 'SELECT codigo, nome, categoria, preco, quantidade FROM remedios';
$params = [];
$types = '';
if ($q !== '') {
	$sql .= ' WHERE codigo LIKE ? OR nome LIKE ?';
	$like = '%' . $q . '%';
	$params = [ $like, $like ];
	$types = 'ss';
}
$sql .= ' ORDER BY nome ASC';

if ($types !== '') {
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($types, ...$params);
	$stmt->execute();
	$result = $stmt->get_result();
} else {
	$result = $conn->query($sql);
}

$itens = [];
if ($result) {
	while ($row = $result->fetch_assoc()) {
		$itens[] = $row;
	}
	if (isset($stmt)) { $stmt->close(); }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Visualizar</title>
	<style>
		:root {
			--teal: #006b78;
			--teal-hover: #005865;
			--border: #e6e6e6;
			--text: #1f1f1f;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
			margin: 0;
			color: var(--text);
			background: #fff;
		}

		.header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 20px 28px;
			border-bottom: 1px solid var(--border);
		}

		.header .brand { display: flex; align-items: center; gap: 12px; }
		.header .brand img { height: 48px; }

		.container { max-width: 1100px; margin: 32px auto; padding: 0 20px; }
		.actions { display: flex; gap: 12px; align-items: center; margin-bottom: 16px; }
		.input { height: 44px; padding: 0 14px; border-radius: 10px; font-size: 16px; }
		.button { height: 44px; padding: 0 18px; color: black; border: none; border-radius: 999px; font-weight: 700; cursor: pointer; }
	

		table { width: 100%; border-collapse: collapse; }
		th, td { padding: 12px 14px; border-bottom: 1px solid var(--border); text-align: left; }
		th { background: #fafafa; font-weight: 700; }
		.badge {padding: 10px 8px; border-radius: 999px; font-size: 16px; }

		.empty { text-align: center; padding: 32px 0; color: #666; }
	</style>
</head>
<body>
	<header class="header">
		<div class="brand">
			<h2>Visualizar itens</h2>
		</div>
		<div>
			<a href="Login.php" style="text-decoration:none"><button class="button" type="button">Sair</button></a>
		</div>
	</header>

	<div class="container">
		<form method="get" class="actions">
			<input class="input" type="text" name="q" placeholder="Buscar por código ou nome" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>">
			<button class="button" type="submit">Buscar</button>
			<a href="CadastrarRemedio.php" style="text-decoration:none"><button class="button" type="button">Cadastrar</button></a>
		</form>

		<?php if (count($itens) === 0): ?>
			<div class="empty">Nenhum item encontrado.</div>
		<?php else: ?>
			<table>
				<thead>
					<tr>
						<th>Código</th>
						<th>Nome</th>
						<th>Categoria</th>
						<th>Preço</th>
						<th>Quantidade</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					//função para buscar o produto
					foreach ($itens as $item): 
					?>
						<tr>
							<td><?php echo htmlspecialchars($item['codigo']); ?></td>
							<td><?php echo htmlspecialchars($item['nome']); ?></td>
							<td><span class="badge"><?php echo htmlspecialchars($item['categoria']); ?></span></td>
							<td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
							<td><?php echo (int)$item['quantidade']; ?></td>
							
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</body>
</html>