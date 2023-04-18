<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\VendaRepository;
use App\Repositories\parcelaRepository;
use App\Repositories\itemVendaRepository;
use App\Repositories\ProdutoRepository;

class vendaController extends Controller
{
    private $vendaRepository;
    private $parcelaRepository;
    private $itemVendaRepository;
    private $produtoRepository;

    public function __construct(VendaRepository $vendaRepository ,parcelaRepository $parcelaRepository ,itemVendaRepository $itemVendaRepository,ProdutoRepository $produtoRepository )
    {
        $this->vendaRepository = $vendaRepository;
        $this->parcelaRepository = $parcelaRepository;
        $this->itemVendaRepository = $itemVendaRepository;
        $this->produtoRepository = $produtoRepository;
    }
    public function index(Request $request)
{
    
    $user = User::find($request->usuario);
    $usuarios = User::all();
    $vendas = $this->vendaRepository->getVendasByUser($user);

    return view('vendas.index', compact('vendas','usuarios'));
}
    public function create()
    {
        $produtos =  $this->produtoRepository->getAll();
       

        return view('vendas.create', compact('produtos'));
    }

    public function buscarProduto(Request $request)
    {
       $produto =  $this->produtoRepository->findOrFail($request->produto_id);
       $preco =$produto->preco;
        return $preco;
    }
    public function store(Request $request)
    {
        try {
            $vendedorId = auth()->user()->id;
            $produtosArray = $request->produtos;
            $parcelasArray = $request->parcelas;
            $metodoPagamentoSelecionado = $request->metodoPagamentoSelecionado;
            $total = 0;
            foreach ($produtosArray as $produto) 
            {
               $item =  $this->produtoRepository->findOrFail($produto['id']);
               $valor = $item->preco * $produto['quantidade'];
               $total = $valor +$total;
            }
            
            $venda = $this->vendaRepository->create
            ([
                'vendedor_id' => $vendedorId,
                'total' => $total,
                'metodo_pagamento_selecionado' => $metodoPagamentoSelecionado,
            ]);
            
            foreach ($produtosArray as $produto)
            {
                
                $item =  $this->produto($produto['id']);
                $subTotal = $item->preco * $produto['quantidade'];
                $precoUndade = $item->preco;
                $itemVenda=$this->itemVendaRepository->create
                ([
                    'venda_id'=>$venda->id,
                    'produto_id'=>$produto['id'],
                    'quantidade'=>$produto['quantidade'],
                    'preco_unidade'=>$precoUndade,
                    'subtotal'=>$subTotal
                ]);
                
                foreach ($parcelasArray as $subArray)
                {
                    
                    $data = $subArray[0];
                    $preco = $subArray[1];
                    $parcela=$this->parcelaRepository->create
                    ([
                        'venda_id'=>$venda->id,
                        'data_limite'=>$data,
                        'preco'=>$preco,
                        'status' =>'aberta'
                    ]);
                }
            }
        }
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
        return response()->json(['success' => 'True']);
           
            
        }   
    }

