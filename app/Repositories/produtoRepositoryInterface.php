<?php
namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

interface produtoRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function create(array $data);
    public function findOrFail($id);
    public function update($id, array $data);
    public function delete($id);
}
?>