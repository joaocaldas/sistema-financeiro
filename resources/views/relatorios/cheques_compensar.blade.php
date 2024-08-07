@extends('voyager::master')

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cheques a Compensar</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data de Emissão</th>
                                    <th>Número do Cheque</th>
                                    <th>Valor</th>
                                    <th>Portador</th>
                                    <th>Descrição</th>
                                    <th>Data de Pré-Datado</th>
                                    <th>Ações</th>
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
                                        <td>{{ $cheque->postdated_date ? \Carbon\Carbon::parse($cheque->postdated_date)->format('d-m-Y') : 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('cheque.compensar', $cheque->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Compensar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Nenhum cheque a compensar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        @if (session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <a href="{{ route('cheques.form') }}" class="btn btn-secondary mt-3">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection