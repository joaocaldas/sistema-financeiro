<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Cheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    // Método para exibir o formulário de seleção
    public function form()
    {
        $contas = Account::all();
        return view('relatorios.cheques_form', compact('contas'));
    }

    // Método para processar e exibir o relatório de cheques
    public function relatorio(Request $request)
    {
        $dataInicial = $request->input('data_inicial');
        $dataFinal = $request->input('data_final');
        $contaId = $request->input('conta_id');

        $conta = Account::find($contaId);

        if (!$conta) {
            return redirect()->route('cheques.form')->withErrors(['message' => 'Conta não encontrada.']);
        }

        if (!$dataInicial || !$dataFinal) {
            return redirect()->route('cheques.form')->withErrors(['message' => 'Datas inválidas.']);
        }

        $cheques = Cheque::where('account_id', $contaId)
            ->whereBetween('issue_date', [$dataInicial, $dataFinal])
            ->get();

        return view('relatorios.cheques_resultado', compact('conta', 'dataInicial', 'dataFinal', 'cheques'));
    }

    // Método para listar cheques a compensar
    public function chequesACompensar()
    {
        $cheques = Cheque::where('status', 'to_be_compensated')->get();
        return view('relatorios.cheques_compensar', compact('cheques'));
    }

    // Método para marcar cheque como compensado
    public function compensar(Request $request, $id)
    {
        $cheque = Cheque::find($id);

        if (!$cheque || $cheque->status != 'to_be_compensated') {
            return redirect()->route('cheques.compensar')->withErrors(['message' => 'Cheque não encontrado ou já compensado.']);
        }

        $cheque->status = 'compensated';
        $cheque->compensation_date = now();
        $cheque->save();

        // Lançar saída da conta
        DB::table('transactions')->insert([
            'account_id' => $cheque->account_id,
            'value' => -$cheque->value,
            'description' => "Compensação do cheque nº {$cheque->cheque_number} para {$cheque->payee}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('cheques.compensar')->with('success', 'Cheque compensado com sucesso.');
    }
}