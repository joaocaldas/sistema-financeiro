@extends('voyager::master')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h3 class="panel-title">Relatório de Fluxo de Caixa</h3>
                    </div>
                    <div class="panel-body">
                        <h4>Saldo Anterior: R$ {{ number_format($saldoAnterior, 2, ',', '.') }}</h4>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Fornecedor</th>
                                    <th>Histórico</th>
                                    <th>Entradas</th>
                                    <th>Saídas</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $saldoAtual = $saldoAnterior;
                                @endphp
                                @foreach ($cheques as $cheque)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($cheque->issue_date)->format('d-m-Y') }}</td>
                                        <td>{{ $cheque->payee }}</td>
                                        <td>{{ $cheque->description }}</td>
                                        <td>{{ $cheque->status == 'compensated' ? number_format($cheque->value, 2, ',', '.') : '0,00' }}</td>
                                        <td>{{ $cheque->status == 'to_be_compensated' ? number_format($cheque->value, 2, ',', '.') : '0,00' }}</td>
                                        <td>{{ number_format($saldoAtual, 2, ',', '.') }}</td>
                                    </tr>
                                    @php
                                        $saldoAtual += $cheque->status == 'compensated' ? $cheque->value : -$cheque->value;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Totais</td>
                                    <td>{{ number_format($entradas, 2, ',', '.') }}</td>
                                    <td>{{ number_format($saidas, 2, ',', '.') }}</td>
                                    <td>{{ number_format($saldoAtual, 2, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <a href="{{ route('relatorio.form') }}" class="btn btn-secondary mt-3">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection