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
                        <form action="{{ route('relatorio.result') }}" method="GET">
                            @csrf
                            <div class="form-group">
                                <label for="conta_id">Conta</label>
                                <select name="conta_id" class="form-control" required>
                                    @foreach ($contas as $conta)
                                        <option value="{{ $conta->id }}">
                                            {{ $conta->bank }} - {{ $conta->account_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="data_inicial">Data Inicial</label>
                                <input type="date" name="data_inicial" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="data_final">Data Final</label>
                                <input type="date" name="data_final" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                        </form>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection