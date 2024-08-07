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
                        <form action="{{ url('relatorio-cheques') }}" method="GET">
                            <div class="form-group">
                                <label for="data_lancamento">Data de Lançamento</label>
                                <input type="date" name="data_lancamento" class="form-control" value="{{ $dataLancamento }}">
                            </div>
                            <div class="form-group">
                                <label for="data_pre_datado">Data Pré-Datado</label>
                                <input type="date" name="data_pre_datado" class="form-control" value="{{ $dataPreDatado }}">
                            </div>
                            <div class="form-group">
                                <label for="numero">Número do Cheque</label>
                                <input type="text" name="numero" class="form-control" value="{{ $numero }}">
                            </div>
                            <div class="form-group">
                                <label for="portador">Portador</label>
                                <input type="text" name="portador" class="form-control" value="{{ $portador }}">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="compensated" {{ $status == 'compensated' ? 'selected' : '' }}>Compensado</option>
                                    <option value="to_be_compensated" {{ $status == 'to_be_compensated' ? 'selected' : '' }}>A Compensar</option>
                                    <option value="returned" {{ $status == 'returned' ? 'selected' : '' }}>Devolvido</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                        </form>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Data de Lançamento</th>
                                    <th>Data Pré-Datado</th>
                                    <th>Número</th>
                                    <th>Portador</th>
                                    <th>Descrição</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cheques as $cheque)
                                    <tr>
                                        <td>{{ $cheque->issue_date->format('d-m-Y') }}</td>
                                        <td>{{ $cheque->postdated_date->format('d-m-Y') }}</td>
                                        <td>{{ $cheque->cheque_number }}</td>
                                        <td>{{ $cheque->payee }}</td>
                                        <td>{{ $cheque->description }}</td>
                                        <td>{{ ucfirst($cheque->status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection