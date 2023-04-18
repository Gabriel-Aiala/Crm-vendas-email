@extends('layouts.principal')

@section('title', 'Lista de Produtos')

@section('content')
<div class="container">
<form>
    @csrf
    <div id="produtos">
        <div class="produto">
            <div class="form-group">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="produto1">Produto:</label>
                        <select class="form-control selectProduto" id="produto1" name="produto[]">
                            <option>Escolha</option>
                            @foreach($produtos as $produto)
                                <option value="{{$produto->nome}}" data-product-id="{{$produto->id}}">{{$produto->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="quantidade1">Quantidade:</label>
                        <select class="form-control input-sm" id="quantidade1" name="quantidade[]">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div name="total"id="total"></div>
    <br>
    <hr>
    <select class="form-control" id="pagamento" name="pagamento">
        <option value="vista">A vista</option>
        <option value="parcela">Parcelas</option>
    </select>
    <label for="metodoPagamento">metodo de Pagamento:</label>
    <select class="form-control" id="metodoPagamento" name="metodoPagamento">
        <option value="debito">debito</option>
        <option value="credito">credito</option>
        <option value="dinheiro">dinheiro</option>
    </select>
    <label for="parcelas">Numero de parcelas</label>
    <input type="number" class="form-control" id="parcelas" name="parcelas">
    <button type="button" id="adicionar-produto" class="btn btn-secondary">Adicionar produto</button>
    <button type="button" id="remover-produto" class="btn btn-secondary">Remover último produto</button>
    <button type="submit" class="btn btn-primary">Enviar</button>
    <div id="parcelamento" >
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody id="tabelaParcelas">
            </tbody>
        </table>
    </div>
</form>
</div>
<script src="create.js"></script>
<script>
  function ImpedirSubmitSelecionar() {
    $(document).ready(function() {
      $('.produto').on('change', function() {
        var valorSelecionado = $(this).val();
        if (valorSelecionado === 'Escolha') {
          $('<div>').text('Escolha o produto').insertAfter($(this));
        } else {
          $(this).nextAll().remove();
        }
      });
    });
  }
  let contador = 1;
  document.getElementById("adicionar-produto").addEventListener("click", function() {
    contador++;
    let novoProduto = document.createElement("div");
    novoProduto.classList.add("produto");
    novoProduto.innerHTML = `
    <div class="form-group">
                    <div class="form-row">
					<div class="form-group col-md-6">
    <label for="produto1">Produto:</label>
    <select class="form-control selectProduto" id="produto1" name="produto[]">
        <option>Escolha</option>
        @foreach($produtos as $produto)
            <option value="{{$produto->nome}}" data-product-id="{{$produto->id}}">{{$produto->nome}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-2">
    <label for="quantidade1">Quantidade:</label>
    <select class="form-control input-sm" id="quantidade1" name="quantidade[]">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
    </select>
</div>


					</div>
    `;
    document.getElementById("produtos").appendChild(novoProduto);
  });

  document.getElementById("remover-produto").addEventListener("click", function() {
    if (contador > 1) {
      let ultimoProduto = document.querySelector("#produtos .produto:last-child");
      ultimoProduto.remove();
      contador--;
    }
  });

  
  document.getElementById("parcelas").addEventListener("change", function() {
  const tabelaParcelas = document.getElementById("tabelaParcelas");
  tabelaParcelas.innerHTML = ""; 

  let parcelas = parseInt(document.getElementById("parcelas").value);

  for (let i = 0; i < parcelas; i++) {
    let novoProduto = document.createElement("tr");

    let campoData = document.createElement("input");
    campoData.type = "date";
    campoData.setAttribute("name", "parcelamentoData");
    let thData = document.createElement("th");
    thData.appendChild(campoData);
    novoProduto.appendChild(thData);

    let campoValor = document.createElement("input");
    campoValor.type = "text";
    campoValor.setAttribute("name", "parcelamentoValor");
    campoValor.placeholder = "valor";
    let thValor = document.createElement("th");
    thValor.appendChild(campoValor);
    novoProduto.appendChild(campoValor);

    let campoObservacao = document.createElement("input");
    campoObservacao.type = "text";
    campoObservacao.setAttribute("name", "parcelamentoObservacao");
    campoObservacao.placeholder = "Campo 2";
    let thObservacao = document.createElement("th");
    thObservacao.appendChild(campoObservacao);
    novoProduto.appendChild(thObservacao);

    tabelaParcelas.appendChild(novoProduto);
  }
});


let produtosSelecionados = [];

$('#produtos').on('change', 'select[name="produto[]"]', function() {
  var select = $(this);  
  var produto_id = select.find(':selected').data('product-id'); 
  var index = select.closest('.produto').index();
  var quantidade = parseInt(select.closest('.produto').find('select[name="quantidade[]"]').val());

  $.ajax({
    url: "{{route('venda.buscarProduto')}}",
    type: 'POST',
    data: { 
      "_token":"{{csrf_token()}}",
      produto_id: produto_id 
    },
    success: function(response) {
      var produto = JSON.parse(response);
      select.closest('.produto').find('input[name="preco[]"]').val(produto);
      var produtoSelecionado = {
        id: produto_id,
        produto: produto,
        posicao: index,
        quantidade: quantidade 
      };
      var indexArray = produtosSelecionados.findIndex(p => p.posicao === index);
      if (indexArray !== -1) {
        produtosSelecionados[indexArray] = produtoSelecionado;
      } else {
        produtosSelecionados.push(produtoSelecionado);
      }
      var total = 0; 
     
      for (let index = 0; index < produtosSelecionados.length; index++) {
        arrayProdutos = produtosSelecionados[index];
        
        quantidade = arrayProdutos.quantidade;
        preco = arrayProdutos.produto
        var valorTotal = preco * quantidade;
        total += valorTotal;
        $('#total').text("VALOR TOTAL:"+total.toFixed(2)); 
      }
    },
    error: function() {
      alert('Erro ao buscar produto');
    }
  });
});

$('#produtos').on('change', 'select[name="quantidade[]"]', function() {
  var select = $(this);

  
  var index = select.closest('.produto').index();

 
  var produtoSelecionado = produtosSelecionados.find(p => p.posicao === index);
  if (produtoSelecionado) {
    produtoSelecionado.quantidade = parseInt(select.val());
  }
  var total = 0;
  for (let i = 0; i < produtosSelecionados.length; i++) {
    var produto = produtosSelecionados[i].produto;
    var quantidade = produtosSelecionados[i].quantidade;
    var valorTotal = produto * quantidade;
    total += valorTotal;
  }
  
  
  $('#total').text("VALOR TOTAL:"+total.toFixed(2)); 
});


$('#remover-produto').on('click', function() {
  produtosSelecionados.pop();
  var total = 0;
  for (let i = 0; i < produtosSelecionados.length; i++) {
    var produto = produtosSelecionados[i].produto;
    var quantidade = produtosSelecionados[i].quantidade;
    var valorTotal = produto * quantidade;
    total += valorTotal;
  }

  
  $('#total').text("VALOR TOTAL:" + total.toFixed(2)); 
});




function configurarPagamento() {
  const pagamento = document.getElementById("pagamento");
  const parcelasLabel = document.getElementById("parcelas").previousElementSibling; // Pega o label anterior ao input
  const parcelasInput = document.getElementById("parcelas");

  if (pagamento.value === "vista") {
    parcelasLabel.style.display = "none";
    parcelasInput.style.display = "none";
    parcelasInput.value = 0
    var tabela = document.getElementById('tabelaParcelas'); // Substitua 'tabelaParcelas' pelo ID da sua tabela
      while (tabela.firstChild) {
    tabela.firstChild.remove();
      }
  } else {
    parcelasLabel.style.display = "block";
    parcelasInput.style.display = "block";
    
  }

  pagamento.addEventListener("change", () => {
    if (pagamento.value === "vista") {
      parcelasLabel.style.display = "none";
      parcelasInput.style.display = "none";
      parcelasInput.value = 0
      var tabela = document.getElementById('tabelaParcelas'); // Substitua 'tabelaParcelas' pelo ID da sua tabela
      while (tabela.firstChild) {
    tabela.firstChild.remove();
      }
    } else {
      parcelasLabel.style.display = "block";
      parcelasInput.style.display = "block";
      
    }
  });
}
document.getElementById("parcelas").dispatchEvent(new Event("change"));

document.addEventListener("DOMContentLoaded", configurarPagamento);


// criando um request 

//juntando as informações necessarias
//1° todos os produtos
 const form = document.querySelector('form');
 form.addEventListener('submit', function(event) {
  ImpedirSubmitSelecionar() 



   event.preventDefault(); // previne que a página recarregue após a submissão
   const divProdutos = document.querySelector('#produtos');
   const formGroups = divProdutos.querySelectorAll('.produto');
   const produtos = [];
   formGroups.forEach((formGroup, index) => {
     const select = formGroup.querySelector('select[name="produto[]"]');
     const productId = select.options[select.selectedIndex].dataset.productId;
     const quantidadeSelect = formGroup.querySelector('select[name="quantidade[]"]');
     const quantidade = quantidadeSelect.options[quantidadeSelect.selectedIndex].value;
  
    const produto = {
      id: productId,
    quantidade: quantidade
    };
   produtos.push(produto);
  
   });
   
   // Obter todos os campos de entrada de dados com os atributos de nome correspondentes
 const camposData = document.querySelectorAll('input[name="parcelamentoData"]');
 const camposValor = document.querySelectorAll('input[name="parcelamentoValor"]');
 const camposObservacao = document.querySelectorAll('input[name="parcelamentoObservacao"]');
 // Armazenar os valores dos campos de entrada de dados em uma matriz
 const valores = [];
 camposData.forEach((campoData, i) => {
   const valorData = campoData.value;
   const valorValor = camposValor[i].value;
   const valorObservacao = camposObservacao[i].value;
   valores.push([valorData, valorValor, valorObservacao]);
 });
   // selecionar o pagamento
   const selectPagamento = document.querySelector('#pagamento').value;

   //const pagamentoSelecionado = selectPagamento.value;
   // selecionar o metodo de pagamento
   const selectMetodoPagamento = document.querySelector('#metodoPagamento');
   const metodoPagamentoSelecionado = selectMetodoPagamento.value;
  console.log(produtos)
  console.log(valores)
  
   $.ajax({
     url: "{{route('venda.store')}}",
     type: 'POST',
     data: { 
       "_token":"{{csrf_token()}}",
       produtos: produtos ,
       parcelas: valores ,
       Pagamento: selectPagamento ,
       metodoPagamentoSelecionado: metodoPagamentoSelecionado ,
     },
     success: function(response) {
       alert('sucesso')
     },
     error: function(error) {
       alert('Erro ao salvar produto');
       
     }

 });
});
 //valores para enviar no ajax
//matriz de produtos - produtos
//matriz de parcelas - valores
//pagamento - selectPagamento
//metodo de pagamento -metodoPagamentoSelecionado

 </script>

			

</body>
</html>

@endsection

