<?php
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$codigo = trim($_POST['codigo'] ?? '');
	$nome = trim($_POST['nome'] ?? '');
	$categoria = trim($_POST['categoria'] ?? '');
	$preco = trim($_POST['preco'] ?? '');
	$quantidade = trim($_POST['quantidade'] ?? '');

	$erros = [];
	if ($codigo === '') { $erros[] = 'Informe o código.'; }
	if ($nome === '') { $erros[] = 'Informe o nome.'; }
	if ($categoria === '') { $erros[] = 'Informe a categoria.'; }
	$precoNormalizado = str_replace(',', '.', $preco);
	if ($preco === '' || !is_numeric($precoNormalizado)) { $erros[] = 'Preço inválido.'; }
	if ($quantidade === '' || !ctype_digit($quantidade)) { $erros[] = 'Quantidade inválida.'; }

	if (empty($erros)) {
		$stmt = $conn->prepare('INSERT INTO remedios (codigo, nome, categoria, preco, quantidade) VALUES (?, ?, ?, ?, ?)');
		if (!$stmt) {
			$erros[] = 'Erro ao preparar inserção: ' . $conn->error;
		} else {
			$precoFloat = (float)$precoNormalizado;
			$quantInt = (int)$quantidade;
			$stmt->bind_param('sssdi', $codigo, $nome, $categoria, $precoFloat, $quantInt);
			if ($stmt->execute()) {
				$stmt->close();
				header('Location: Visualizar.php?msg=cadastrado');
				exit;
			} else {
				$erros[] = 'Erro ao salvar: ' . $stmt->error;
				$stmt->close();
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastrar Remédio</title>
	<style>
		:root {
			--teal: #006b78;
			--teal-hover: #005865;
			--border: #e6e6e6;
			--field-bg: #f1f1f1;
			--text: #1f1f1f;
		}

		body { font-family: Arial, Helvetica, sans-serif; margin: 0; color: var(--text); background: #fff; }
		.header { display: flex; align-items: center; justify-content: space-between; padding: 20px 28px; border-bottom: 1px solid var(--border); }
		.header .brand { display: flex; align-items: center; gap: 12px; }
		.header .brand img { height: 48px; }

		.container { max-width: 900px; margin: 32px auto; padding: 0 20px; }
		.card { padding: 24px; border: 1px solid var(--border); border-radius: 16px; background: #fff; }
		.grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
		.field { display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px; }
		.label { font-weight: 700; }
		.input, .select { height: 54px; padding: 0 16px; border: 1px solid var(--border); background: var(--field-bg); border-radius: 12px; font-size: 16px; outline: none; }
		.actions { margin-top: 16px; display: flex; gap: 12px; }
		.button { height: 54px; padding: 0 22px; color: black; border: none; border-radius: 999px; font-weight: 700; cursor: pointer; }
		.link { height: 54px; padding: 0 22px; border: 1px solid var(--border); background: #fff; border-radius: 999px; cursor: pointer; }
		.error { background: #fff2f2; border: 1px solid #ffd6d6; color: #b30000; padding: 12px 14px; border-radius: 10px; margin-bottom: 16px; }
	</style>
</head>
<body>
	<header class="header">
		<div class="brand">
			<h2>Cadastrar remédio</h2>
		</div>
		<div>
			<a href="Visualizar.php" style="text-decoration:none"><button class="link" type="button">Voltar</button></a>
		</div>
	</header>

	<div class="container">
		<div class="card">
			<?php if (!empty($erros)): ?>
				<div class="error">
					<?php foreach ($erros as $e) { echo '<div>'.htmlspecialchars($e).'</div>'; } ?>
				</div>
			<?php endif; ?>

			<form method="post" novalidate>
				<div class="grid">
					<div class="field">
						<label class="label" for="codigo">Código</label>
						<input class="input" type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($codigo ?? '', ENT_QUOTES); ?>" required>
					</div>
					<div class="field">
						<label class="label" for="nome">Nome</label>
						<input class="input" type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome ?? '', ENT_QUOTES); ?>" required>
					</div>
					<div class="field">
						<label class="label" for="categoria">Categoria</label>
						<select class="select" id="categoria" name="categoria" required>
							<?php $catAtual = $categoria ?? ''; ?>
							<option value="" disabled <?php echo $catAtual === '' ? 'selected' : ''; ?>>Selecione...</option>
							<option value="Analgésico" <?php echo $catAtual === 'Analgésico' ? 'selected' : ''; ?>>Analgésico</option>
							<option value="Anti-inflamatório" <?php echo $catAtual === 'Anti-inflamatório' ? 'selected' : ''; ?>>Anti-inflamatório</option>
							<option value="Gastroprotetor" <?php echo $catAtual === 'Gastroprotetor' ? 'selected' : ''; ?>>Gastroprotetor</option>
							<option value="Antibiótico" <?php echo $catAtual === 'Antibiótico' ? 'selected' : ''; ?>>Antibiótico</option>
						</select>
					</div>
					<div class="field">
						<label class="label" for="preco">Preço (R$)</label>
						<input class="input" type="text" id="preco" name="preco" placeholder="0,00" value="<?php echo htmlspecialchars($preco ?? '', ENT_QUOTES); ?>" required>
					</div>
					<div class="field">
						<label class="label" for="quantidade">Quantidade</label>
						<input class="input" type="number" id="quantidade" name="quantidade" min="0" step="1" value="<?php echo htmlspecialchars($quantidade ?? '', ENT_QUOTES); ?>" required>
					</div>
				</div>

				<div class="actions">
					<button class="button" type="submit">Salvar</button>
					<a href="Visualizar.php" style="text-decoration:none"><button class="link" type="button">Cancelar</button></a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>

