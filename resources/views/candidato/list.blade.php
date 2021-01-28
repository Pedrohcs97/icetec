@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lista de candidatos</div>
                <div class="card-body">
                    <div class="form-group" style="display: flex;">
                        <div class="col-md-6">
                            <a href="{{url('candidato/create')}}" class="btn btn-primary">
                                Adicionar
                            </a>
                        </div>

                        <div class="col-md-6">
                            <form class="form" method="get" action="/candidato">
                                <select name="tecnologia" onchange="this.form.submit()" id="tecnologias" class="form-control">
                                    <option value="">Selecione para filtrar</option>
                                    @if(!empty($tecnologias))
                                    @foreach ($tecnologias as $key => $tecnologia)
                                    <option value="{{$tecnologia->id_tecnologia}}" @if(!empty($tecSelected)) @if (!empty($tecnologia) && $tecSelected==$tecnologia->id_tecnologia) <?= 'selected'; ?> @endif
                                        @endif>{{$tecnologia->nome}} </option>
                                    @endforeach
                                    @endif
                                </select>
                            </form>
                        </div>
                    </div>

                    <table id="table" class="table table-striped">
                        <thead>
                            <tr>
                                <th> Nome</th>
                                <th> Email</th>
                                <th> Idade</th>
                                <th> Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($candidatos))
                            @forelse($candidatos as $candidato)
                            <tr>
                                <td> {{$candidato['nome']}} </td>
                                <td> {{$candidato['email']}} </td>
                                <td> {{$candidato['idade']}} </td>
                                <td>
                                    <a style="color: #2196F3;" href="{{url("/candidato/$candidato->id_candidato/edit")}}"> Editar</a>
                                    |
                                    <a onclick='return confirm("Realmente deseja excluir o candidato ?")' style="color: #dc3545;" href="{{ route('candidato.delete', $candidato->id_candidato) }}"> Excluir</a>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                            @endif

                        </tbody>
                    </table>

                    <div>
                        @if(isset($candidatos) && count($candidatos) == 0)
                        Nenhum candidato adicionado
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
