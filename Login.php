<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		:root {
			--teal: #006b78;
			--teal-hover: #005865;
			--field-bg: #e9e9e9;
			--text: #1f1f1f;
			--muted: #6a6a6a;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
			color: var(--text);
			background: #fff;
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}

		/* Top bar */
		.header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 20px 28px;
			border-bottom: 1px solid #e6e6e6;
		}

		.header .brand {
			display: flex;
			align-items: center;
			gap: 15px;
		}

		.header .brand img {
			height: 120px;
            width: 250px;
		}

		.header .meta {
			display: flex;
			align-items: center;
			gap: 34px;
			color: var(--text);
			font-size: 14px;
		}

		.header .meta span {
			display: inline-flex;
			align-items: center;
			gap: 8px;
		}

		/* Main area */
		.main {
			flex: 1;
			width: 100%;
			display: flex;
			justify-content: center;
			padding: 64px 20px 40px;
		}

		.form-wrapper {
			width: 100%;
			max-width: 980px;
		}

		.field {
			margin: 26px 0;
		}

		.field label {
			display: block;
			font-size: 18px;
			margin-bottom: 10px;
		}

		.input {
			width: 100%;
			height: 64px;
			padding: 0 22px;
			border: none;
			background: var(--field-bg);
			border-radius: 16px;
			font-size: 18px;
			outline: none;
		}

		.input:focus {
			box-shadow: 0 0 0 3px rgba(0, 107, 120, 0.15);
		}

		.password-holder {
			position: relative;
		}

		.toggle-visibility {
			position: absolute;
			top: 50%;
			right: 18px;
			transform: translateY(-50%);
			border: none;
			background: transparent;
			cursor: pointer;
			font-size: 20px;
			color: #4b4b4b;
		}

		.toggle-visibility img {
			width: 24px;
			height: 24px;
			display: block;
			pointer-events: none;
		}

		.submit {
			margin-top: 24px;
			width: 100%;
			height: 72px;
			background: var(--teal);
			color: #fff;
			border: none;
			border-radius: 999px;
			font-size: 20px;
			font-weight: 700;
			cursor: pointer;
		}

		.submit:hover {
			background: var(--teal-hover);
		}

		.help {
			text-align: center;
			margin-top: 18px;
		}

		.help a {
			color: var(--text);
			text-decoration: underline;
			font-size: 16px;
		}

		.error-message {
			color: #d10000;
			font-size: 13px;
			margin-top: 6px;
			display: none;
		}
	</style>
</head>
<body>
	<header class="header">
		<div class="brand">
			<img src="img/logo.png" alt="Drogaria">
		</div>
		
	</header>

	<main class="main">
		<form id="loginForm" class="form-wrapper" method="POST">
			<div class="field">
				<label for="usuario">E-mail ou CPF</label>
				<input class="input" type="text" id="usuario" name="usuario" autocomplete="username" required>
				<span class="error-message" id="errorMessage"></span>
			</div>

			<div class="field">
				<label for="senha">Senha</label>
				<div class="password-holder">
					<input class="input" type="password" id="senha" name="senha" autocomplete="current-password" required>
					<button class="toggle-visibility" type="button" aria-label="Mostrar ou ocultar senha" onclick="togglePassword()"><img src="img/olho (1).png" alt="mostrar senha"></button>
				</div>
			</div>

			<button type="submit" class="submit">Entrar</button>
		</form>
	</main>

	<script>
		//Função para mostrar ou ocultar a senha
		function togglePassword() {
			const field = document.getElementById('senha');
			const btn = document.querySelector('.toggle-visibility');
			const icon = btn.querySelector('img');
			if (field.type === 'password') {
				field.type = 'text';
				icon.src = 'img/olho.png';
				icon.alt = 'ocultar senha';
			} else {
				field.type = 'password';
				icon.src = 'img/olho (1).png';
				icon.alt = 'mostrar senha';
			}
		}

		document.getElementById('loginForm').addEventListener('submit', function(e) {
			e.preventDefault();
			const usuario = document.getElementById('usuario').value.trim();
			const senha = document.getElementById('senha').value.trim();
			const error = document.getElementById('errorMessage');

			if (!usuario || !senha) {
				error.textContent = 'Por favor, preencha todos os campos.';
				error.style.display = 'block';
				return;
			}

			//Autenticação simples (logar seguindo o email e senha abaixo)
			if (usuario === 'senai@aluno.senai.br' && senha === 'senai151') {
				window.location.href = 'Visualizar.php';
			} else {
				error.textContent = 'Usuário ou senha incorretos!';
				error.style.display = 'block';
			}
		});
	</script>
</body>
</html>
