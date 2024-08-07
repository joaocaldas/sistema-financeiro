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
                                    <th>Data de Lançamento</th>
                                    <th>Data Pré-Datado</th>
                                    <th>Número</th>
                                    <th>Portador</th>
                                    <th>Descrição</th>
                                    <th>Ação</th>
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
                                        <td>
                                            <form action="{{ url('cheques/' . $cheque->id . '/compensar') }}" method="POST">
                                                @csrf
                                                <input type="date" name="data_compensacao" class="form-control" required>
                                                <button type="submit" class="btn btn-success mt-2">Compensar</button>
                                            </form>
                                        </td>
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