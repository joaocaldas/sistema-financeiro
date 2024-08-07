@extends('voyager::master')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h3 class="panel-title">Relatório de Cheques</h3>
                    </div>
                    <div class="panel-body">
                        <h4>Relatório de Cheques para {{ $conta->bank }} - {{ $conta->account_number }}</h4>
                        <h4>Período: {{ \Carbon\Carbon::parse($dataInicial)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($dataFinal)->format('d-m-Y') }}</h4>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data de Emissão</th>
                                    <th>Número do Cheque</th>
                                    <th>Valor</th>
                                    <th>Portador</th>
                                    <th>Descrição</th>
                                    <th>Status</th>
                                    <th>Data de Compensação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cheques as $cheque)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($cheque->issue_date)->format('d-m-Y') }}</td>
                                        <td>{{ $cheque->cheque_number }}</td>
                                        <td>R$ {{ number_format($cheque->value, 2, ',', '.') }}</td>
                                        <td>{{ $cheque->payee }}</td>
                                        <td>{{ $cheque->description }}</td>
                                        <td>{{ ucfirst($cheque->status) }}</td>
                                        <td>{{ $cheque->compensation_date ? \Carbon\Carbon::parse($cheque->compensation_date)->format('d-m-Y') : 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Nenhum cheque encontrado para o período selecionado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <a href="{{ route('cheques.form') }}" class="btn btn-secondary mt-3">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
