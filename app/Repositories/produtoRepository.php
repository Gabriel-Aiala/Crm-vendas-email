<?php

namespace App\Repositories;

use App\Models\Produto;
use Illuminate\Pagination\LengthAwarePaginator;

class ProdutoRepository implements produtoRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Produto::paginate(10);
    }

    public function create(array $data)
    {
        return Produto::create($data);
    }

    public function findOrFail($id)
    {
        return Produto::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $produto = $this->findOrFail($id);
        $produto->update($data);
        return $produto;
    }

    public function delete($id)
    {
        $produto = $this->findOrFail($id);
        return $produto->delete();
    }
}

?>