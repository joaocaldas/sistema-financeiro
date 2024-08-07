<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Cheque;
use Illuminate\Support\Facades\DB;

class RelatoriosController extends Controller
{
    public function formFluxoCaixa()
    {
        $contas = Account::all();
        return view('relatorios.form_fluxo_caixa', compact('contas'));
    }

    public function fluxoCaixa(Request $request)
    {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $contaId = $request->input('conta_id');

        $conta = Account::find($contaId);

        if (!$conta) {
            return redirect()->route('relatorios.form_fluxo_caixa')->withErrors(['message' => 'Conta não encontrada.']);
        }

        if (!$dataInicial || !$dataFinal) {
            return redirect()->route('relatorios.form_fluxo_caixa')->withErrors(['message' => 'Datas inválidas.']);
        }

        $saldoAnterior = DB::table('cheques')
            ->where('account_id', $contaId)
            ->whereDate('issue_date', '<', $dataInicial)
            ->sum(DB::raw('CASE WHEN status = "compensated" THEN value ELSE -value END'));

        $cheques = DB::table('cheques')
            ->where('account_id', $contaId)
            ->whereBetween('issue_date', [$dataInicial, $dataFinal])
            ->get();

        $saldo = $saldoAnterior;
        $entradas = 0;
        $saidas = 0;

        foreach ($cheques as $cheque) {
            if ($cheque->status === 'compensated') {
                $entradas += $cheque->value;
                $saldo += $cheque->value;
            } elseif ($cheque->status === 'to_be_compensated') {
                $saidas += $cheque->value;
                $saldo -= $cheque->value;
            }
        }

        return view('relatorios.fluxo_caixa', compact('conta', 'dataInicial', 'dataFinal', 'saldoAnterior', 'entradas', 'saidas', 'cheques', 'saldo'));
    }

    
}
