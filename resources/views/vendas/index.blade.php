@extends('layouts.principal')

@section('title', 'Lista de Produtos')


@section('content')
<div class="container">
<form method="GET" action="{{ route('venda.index') }} " id="vendas-tabela">
    <label for="usuario">Filtre por vendedor:</label>
    <select name="usuario" id="usuario" class="form-group">
        @foreach($usuarios as $usuario)
            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
        @endforeach
    </select>
    <button class="btn btn-primary" type="submit">Pesquisar</button>
</form>

<table class="table">
</div>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">vendedor</th>
      <th scope="col">total</th>
      <th scope="col">metodo de pagamento</th>
      <th scope="col">parcelas</th>
      
    </tr>
  </thead>
  <tbody>
    @foreach($vendas as $venda)
    <tr>
        <td>{{$venda->id}}</td>
        <td>{{$venda->vendedor->name}}</td>
        <td>{{$venda->total}}</td>
        <td>{{$venda->metodo_pagamento}}</td>
        <td><a href="{{route('parcela.show',['id'=>$venda->id])}}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg></a></td>
        
		<td></td>
		@endforeach
    
  </tbody>
  
</table>
{{$vendas->links()}}
</div>
			

</body>

</html>
@endsection


