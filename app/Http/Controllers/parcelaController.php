<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\cobrarParcela;
use App\Repositories\parcelaRepository;
use App\Repositories\itemVendaRepository;




class parcelaController extends Controller
{
    protected $parcelaRepository;
    protected $itemVendaRepository;

    public function __construct(parcelaRepository $parcelaRepository , itemVendaRepository $itemVendaRepository)
    {
        $this->parcelaRepository = $parcelaRepository;
        $this->itemVendaRepository = $itemVendaRepository;
    }
    public function show($id)
    {
        $parcelas = $this->parcelaRepository->getByVendaId($id)->get();
        $itensVenda = $this->itemVendaRepository->getByVendaId($id)->get();
        return view('parcelas.show', compact('parcelas', 'itensVenda'));
    }


public function update(Request $request)
{
    $parcela = $this->parcelaRepository->findById($request['parcela_id']);
    $parcela->status = $request['status'];
    $parcela->save();
    return $parcela;
}
public function emailEnviar(Request $request){
    
    $parcela = $this->parcelaRepository->findById($request->parcela_id);
    $data = [
        'subject'=>$request->email,
        'body'=>$parcela->preco,
        
    ];
    Mail::to('aialagabrielvicente@gmail.com')->send(new cobrarParcela($data) );
    return 'email enviado';
}


    


}
