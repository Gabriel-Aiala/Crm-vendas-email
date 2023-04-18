<!DOCTYPE html>
<html lang="pt-br">
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<!-- Adicione aqui os links para os arquivos CSS do Bootstrap -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<a class="navbar-brand" href="#">Minha Loja</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{route('produto.index')}}">Produtos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{route('venda.index')}}">Vendas</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	@yield('content')
</div>

<!-- Adicione aqui os scripts do Bootstrap -->

</body>
</html>
