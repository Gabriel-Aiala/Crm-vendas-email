@extends('layouts.principal')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
    <a class="btn btn-success" href="{{ route('venda.create') }}">Adicionar Venda</a>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Valor da Parcela</th>
          <th scope="col">Status</th>      
          <th scope="col">Limite</th>      
        </tr>
      </thead>
      <tbody>
      @foreach($parcelas as $parcela)
  <tr>
    <td>{{ $parcela->id }}</td>
    <td>{{ $parcela->preco }}</td>
    <td>
      <select name="status" data-parcela-id="{{ $parcela->id }}" class="form-control">
        <option value="paga" {{ $parcela->status == 'paga' ? 'selected' : '' }}>Paga</option>
        <option value="aberta" {{ $parcela->status == 'aberta' ? 'selected' : '' }}>Aberta</option>
        <option value="atrasada" {{ $parcela->status == 'atrasada' ? 'selected' : '' }}>Atrasada</option>
      </select>
    </td>
    <td>{{ $parcela->data_limite }}</td>
    <td>
    <button class="open-form-btn btn btn-primary" data-parcela-id="{{ $parcela->id }}" data-email-form="#email-form-{{$parcela->id}}">Cobrar por Email</button>

    </td>
  </tr>
@endforeach
      </tbody>
    </table>
    <br>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Produto</th>
          <th scope="col">Quantidade</th>      
          <th scope="col">Preço por Unidade</th>      
          <th scope="col">Subtotal</th>      
        </tr>
      </thead>
      <tbody>
        @foreach($itensVenda as $item)
          <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->produto->nome }}</td>
            <td>{{ $item->quantidade }}</td>
            <td>{{ $item->preco_unidade }}</td>
            <td>{{ $item->subtotal }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="text-center">
      <div class="total"></div>
      <div><b>TOTAL</b></div>
      <div id="total">{{ $itensVenda->sum('subtotal') }}</div>
    </div>
    <div id="form-overlay" style="display:none;"></div>
    <div id="form-popup" style="display:none;">
      <form id="email-form">
      <input type="hidden" id="hidden-field-id" name="parcela-id">
        <label for="email">E-mail do Pagador:</label>
        <input type="email" id="email" name="email">
        <button type="submit" id="submit-btn">Enviar</button>
        <button class="close-form-btn">Fechar</button>
      </form>
    </div>
  </div>


<style>
#form-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  z-index: 9999;
  display: none;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  padding: 20px;
  max-width: 400px;
  width: 100%;
}

#form-popup label {
  display: block;
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 10px;
}

#form-popup input[type="email"] {
  display: block;
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border-radius: 5px;
  border: none;
  margin-bottom: 20px;
}

#submit-btn {
  display: block;
  background-color: #00a1e4;
  color: white;
  font-size: 16px;
  padding: 10px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

#submit-btn:hover {
  background-color: #0077a3;
}

.close-form-btn {
  display: block;
  background-color: #e02f2f;
  color: white;
  font-size: 16px;
  padding: 10px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s ease;
  margin-top: 20px;
}

.close-form-btn:hover {
  background-color: #b02323;
}

#form-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9998;
  display: none;
}
</style>

<script>
$('.open-form-btn').on('click', function(event) {
  var parcelaId = $(this).data('parcela-id');
  
  var emailFormId = $(this).data('email-form');
  $('#form-popup').show();
  $('#form-overlay').show();
  $(emailFormId).data('parcela-id', parcelaId); // set the parcela_id in the email form
  $('#hidden-field-id').val(parcelaId); // set the value of the hidden field to parcelaId
});


$('#email-form').submit(function(event) {
  event.preventDefault(); 
  
  let email = $('#email').val();
  
  let parcelaId = $('#hidden-field-id').val();
  
  
  
  $.ajax({
    url: "{{route('parcela.emailEnviar')}}",
    method: 'POST',
    data: {"_token":"{{ csrf_token() }}", email: email, parcela_id: parcelaId},
    success: function(response) {
      console.log(response);
      $('#form-popup').hide();
      $('#form-overlay').hide();        
    },
    error: function(xhr, status, error) {
      console.log(xhr);
      console.log(status);
      console.log(error);
    }
  });
});


$('select[name="status"]').change(function() {
  
  var status = $(this).val();
  var parcelaId = $(this).data('parcela-id');
   $.ajax({
       url: "{{route('parcela.update')}}",
       method: 'PUT',
       data: {"_token":"{{csrf_token()}}", status: status, parcela_id: parcelaId },
       success: function(response) {
           console.log(response)
       },
       error: function(xhr, status, error) {
        console.log(xhr)
        console.log(status)
        console.log(error)
       }
   });
});
</script>

</body>
</html>
@endsection


