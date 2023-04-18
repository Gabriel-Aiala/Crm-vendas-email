<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Parcela;

class AtualizarParcelasEmAberto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:atualizar-parcelas-em-aberto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $parcelas = Parcela::where('status', 'aberto')
            ->whereDate('data_limite', '<', now())
            ->update(['status' => 'atrasado']);
    }
    
}
