<?php

namespace App\Repositories;

use App\Models\Parcela;
use Illuminate\Pagination\LengthAwarePaginator;

class parcelaRepository
{
    public function create(array $data): Parcela
    {
        return Parcela::create($data);
    }

    public function findById(int $id): ?Parcela
    {
        return Parcela::find($id);
    }

    public function findAll()
    {
        return Parcela::all();
    }
    public function getByVendaId($id)
    {
        return Parcela::where('venda_id',$id);
    }
}


?>