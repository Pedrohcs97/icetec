@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(empty($candidato->id_candidato))
                <div class="card-header">Cadastrar candidato</div>
                @else
                <div class="card-header">Editar candidato</div>
                @endif
                <div class="card-body">
                    <div id="form" style="display: none;">
                        @if(empty($candidato->id_candidato))
                        <form class="form" method="post" action="/candidato">
                            @else
                            <form class="form" method="post" action="/candidato/{{$candidato->id_candidato}}">
                                @method('PUT')
                                @endif
                                {!! csrf_field() !!}

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nome">Nome</label>
                                        <input required maxlength="60" name="nome" type="text" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" value="@if(old('nome')){{ old('nome')}}@elseif(isset($candidato->nome)){{$candidato->nome}}@endif" id="nome" placeholder="Nome">
                                        @if ($errors->has('nome'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input required maxlength="60" name="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="@if(old('email')){{ old('email')}}@elseif(isset($candidato->email)){{$candidato->email}}@endif" id="email" placeholder="Email">
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="idade">Idade</label>
                                        <input required maxlength="60" name="idade" type="number" class="form-control {{ $errors->has('idade') ? ' is-invalid' : '' }}" value="@if(old('idade')){{ old('idade')}}@elseif(isset($candidato->idade)){{$candidato->idade}}@endif" id="idade" placeholder="Idade (anos)">
                                        @if ($errors->has('idade'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('idade') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="linkedin">Url linkedin</label>
                                        <input required maxlength="60" name="linkedin" type="text" class="form-control {{ $errors->has('linkedin') ? ' is-invalid' : '' }}" value="@if(old('linkedin')){{ old('linkedin')}}@elseif(isset($candidato->linkedin)){{$candidato->linkedin}}@endif" id="linkedin" placeholder="Url linkedin">
                                        @if ($errors->has('linkedin'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('linkedin') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tecnologia">Tecnologias</label>
                                    <select id="tecnologias" multiple="multiple" class="form-control {{ $errors->has('tecnologias') ? ' is-invalid' : '' }}" style="width:100% !important;" name="tecnologias[]">
                                        @if(!empty($tecnologias))
                                        @foreach ($tecnologias as $key => $tecnologia)
                                        <option value="{{$tecnologia->id_tecnologia}}" @if(!empty($tecsSelected)) @foreach($tecsSelected as $key=> $tecSelected)
                                            @if (!empty($tecnologia) && $tecSelected['id_tecnologia'] == $tecnologia->id_tecnologia) <?= 'selected'; ?> @endif
                                            @endforeach
                                            @endif>{{$tecnologia->nome}} </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                    <a href="{{url('candidato')}}" class="btn btn-danger"> Voltar </a>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('js/select2.min.js') }}" defer></script>

<script type="application/javascript">
    setTimeout(() => {
        $("#tecnologias").select2();
        $("#form").show();
    }, 400);
</script>

@endsection
