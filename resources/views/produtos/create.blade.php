@extends('layouts.principal')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
    <h1>Adicionar Produto</h1>
    <form action="{{route('produto.store')}}" method ="POST">
        @csrf
  <div class="mb-3">
    <label>Nome do produto</label>
    <input type="text" class="form-control" id="nome" name = "nome" aria-describedby="nome"value ="">
    
  </div>

  <div class="mb-3">
    <label>preco</label>
    <input type="number" class="form-control" id="preco" name = "preco" aria-describedby="preco"value ="">
    
  </div>
  
  <button type="submit" class="btn btn-primary">Criar</button>
</form>
			

</body>
</html>
@endsection


