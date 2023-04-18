@extends('layouts.principal')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
    <h1>Atualizar Produto</h1>
    <form action="{{ route('produto.update', $produto->id) }}" method ="POST">
    @csrf
    @method('PUT')
  <div class="mb-3">
    <label>Nome do produto</label>
    <input type="text" class="form-control" id="nome" name = "nome" aria-describedby="nome"value ="{{$produto->nome}}">
    
  </div>

  <div class="mb-3">
    <label>preco</label>
    <input type="text" class="form-control" id="preco" name = "preco" value ="{{$produto->preco}}">
    
  </div>
  
  <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
			

</body>
</html>
@endsection



