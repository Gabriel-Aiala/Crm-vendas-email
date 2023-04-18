<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarProdutoRequest;
use App\Repositories\ProdutoRepository;


class ProdutoController extends Controller
{
    protected $produtoRepository;

    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function index()
    {
        $produtos = $this->produtoRepository->getAll();
        return view('produtos.index')->with(['produtos' => $produtos]);
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(CriarProdutoRequest $request)
    {
        $data = $request->validated();
        $produto = $this->produtoRepository->create($data);
        return redirect('/');
    }

    public function destroy($id)
    {
        $this->produtoRepository->delete($id);
        return redirect('/');
    }

    public function update(CriarProdutoRequest $request, $id)
    {
        $data = $request->validated();
        $produto = $this->produtoRepository->update($id, $data);
        return redirect('/');
    }

    public function show($id)
    {
        $produto = $this->produtoRepository->findOrFail($id);
        return view('produtos.show')->with(['produto' => $produto]);
    }
}
