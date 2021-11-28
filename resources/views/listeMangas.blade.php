@extends('layouts.master')
@section('content')
<div class="container">
    <div class="blanc">
        <h1>Liste de mes Mangas</h1>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Genre</th>
                <th>Dessinateur</th>
                <th>Scénariste</th>
                <th>Prix</th>
                <th style="width: 50px;">Modifier</th>
                <th style="width: 50px;">Supprimer</th>
            </tr>
        </thead>        
        @foreach($mangas as $manga)
        <tr>   
            <td> {{$manga->titre}} </td>
            <td> {{$manga->genre->lib_genre}} </td>
            <td> {{$manga->dessinateur->nom_dessinateur}} </td>
            <td> {{$manga->scenariste->nom_scenariste}} </td>
            <td> {{$manga->prix}} </td>         
            <td style="text-align:center;"><a href="{{url('modifierManga')}}/{{$manga->id_manga}}">
                    <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="Modifier"></span></a>
            </td>
            <td style="text-align:center;">
                <a class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" title="Supprimer" href="#"
                   onclick="javascript:if (confirm('Suppression confirmée ?'))
                           {
                               window.location = '{{url('/supprimerManga')}}/{{$manga->id_manga}}';
                           }">
                </a>
            </td>            
        </tr>
       @endforeach
        <BR> <BR>
    </table>
</div>
@stop