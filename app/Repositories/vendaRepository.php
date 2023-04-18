<?php

namespace App\Repositories;

use App\Models\Venda;
use Illuminate\Pagination\LengthAwarePaginator;

class VendaRepository
{
    public function create(array $data): Venda
    {
        return Venda::create($data);
    }

    public function findById(int $id): ?Venda
    {
        return Venda::find($id);
    }

    public function findAll()
    {
        return Venda::all();
    }
    public function getVendasByUser($user, $perPage = 10)
{
    return Venda::where(function ($query) use ($user) {
        if($user !== null) {
            $query->where('vendedor_id', $user->id);
        }
    })->orderBy('created_at', 'desc')->paginate($perPage);
}

}


?>