<?php

namespace App\Repositories;

use App\Models\ItemVenda;
use Illuminate\Pagination\LengthAwarePaginator;

class itemVendaRepository
{
    public function create(array $data): ItemVenda
    {
        return ItemVenda::create($data);
    }

    public function findById(int $id): ?ItemVenda
    {
        return ItemVenda::find($id);
    }

    public function findAll()
    {
        return ItemVenda::all();
    }
    public function getByVendaId($id)
    {
        return ItemVenda::where('venda_id',$id);
    }
}


?>