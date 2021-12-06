@extends('layouts.master')
@section('content')
    {!! Form::open(['url' => 'validerManga', 'files' => true]) !!}
    <div class="col-md-12 well well-sm">
        <center>
            <h1>{{ $titreVue }}</h1>
        </center>
        <div class="form-horizontal">
            <div class="form-group">
                <input type="hidden" name="id_manga" value="{{ $manga->id_manga }}" />
                <label class="col-md-3 control-label">Titre : </label>
                <div class="col-md-3">
                    {{-- champs de type text --}}
                    {{ Form::text('titre', old('titre') ? old('titre') : (!empty($manga) ? $manga->titre : null), ['class' => 'form-control', 'placeholder' => 'Titre', 'autofocus']) }}
                </div>
                @error('titre')
                    <span class='invalid-feedback' role="alert">
                        <strong>{{ $message }}</strong>
                    </span>

                @enderror
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Genre : </label>
                <div class="col-md-3">
                    {{-- //champ de type select --}}
                    {{ Form::select('cbGenre', $genres->pluck('lib_genre', 'id_genre'), $manga->id_genre, ['class'=> 'form-control', 'placeholder'=> 'sélectionner un genre']) }}


                    {{-- /* <select class='form-control' name='cbGenre' required>
                        <OPTION VALUE=0>Sélectionner un genre</option>
                        @foreach ($genres as $genre)
                            selected=""
                            <option value="{{ $genre->id_genre }}" @if ($genre->id_genre == $manga->id_genre)
                                selected="selected"
                        @endif
                        >{{ $genre->lib_genre }} </option>
                        @endforeach
                    </select> */ --}}
                </div>
                @error('cbGenre')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Scenariste : </label>
                <div class="col-md-3">
                    {{ Form::select('cbScenariste', $scenaristes->pluck('nom_scenariste', 'id_scenariste'), $manga->id_scenariste, ['class' => 'form-control', 'placeholder' => 'Sélectionner un Scenariste']) }}

                    {{-- // <select class="form-control" name='cbScenariste' required>
                        // <OPTION VALUE=0>Sélectionner un Scenariste</option>
                        // @foreach ($scenaristes as $scenariste)
                            // selected=""
                            // <option value="{{ $scenariste->id_scenariste }}" // @if ($scenariste->id_scenariste == $manga->id_scenariste)
                                // selected="selected"
                                // @endif
                        // > {{ $scenariste->nom_scenariste }} </option>
                        // @endforeach
                        // </select> --}}
                </div>
                @error('cbScenariste')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Dessinateur : </label>
                <div class="col-md-3">

                    {{ Form::select('cbDessinateur', $dessinateurs->pluck('nom_dessinateur','id_dessinateur' ,), $manga->id_dessinateur, ['class' => 'form-control', 'placeholder' => 'Sélectionner un Dessinateur']) }}
                    {{-- <select class='form-control' name='cbDessinateur' required>
                        <OPTION VALUE=0>Sélectionner un Dessinateur</option>
                        @foreach ($dessinateurs as $dessinateur)
                            selected=""
                            <option value="{{ $dessinateur->id_dessinateur }}" @if ($dessinateur->id_dessinateur == $manga->id_dessinateur)
                                selected="selected"
                        @endif
                        > {{ $dessinateur->nom_dessinateur . ' ' . $dessinateur->prenom_dessinateur }} </option>
                        @endforeach
                    </select> --}}
                </div>
                @error('cbDessinateur')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Prix : </label>
                <div class="col-md-3">
                    {{ Form::text('prix', old('prix') ? old('prix') : (!empty($manga) ? $manga->prix : null), ['class' => 'form-control', 'placeholder' => 'Prix','required']) }}


                    {{-- <input type="text" name="prix" value="{{ $manga->prix }}" class="form-control" required> --}}
                </div>
                @error('prix')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Couverture : </label>
                <div class="col-md-6">
                    <input type="hidden" name="MAX_FILE_SIZE" value="204800" />
                    <input name="couverture" type="file" class="btn btn-default pull-left" />
                    <input type="hidden" name="couvertureHidden" value="{{ $manga->couverture }}" />
                    <img src='{{ URL::to('/') }}/images/{{ $manga->couverture }}'
                        class='img-responsive pull-right imgReduite' alt='{{ $manga->couverture }}' />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default btn-primary">
                        <span class="glyphicon glyphicon-ok"></span> Valider
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-default btn-primary"
                        onclick="javascript: window.location = '{{ url('/') }}';">
                        <span class="glyphicon glyphicon-remove"></span> Annuler
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
                @include('error')
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop
