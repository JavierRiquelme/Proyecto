@extends('dashboard.master')

@section('content')
<h1>Listar Clases:</h1>
<form action="{{ route('clase.index') }}" class="form-inline mb-2">
    <select name="start" class="form-control">
        <option value="DESC">Descendente</option>
        <option {{ request('start') == "ASC" ? "selected" : '' }} value="ASC">Ascendente</option>
    </select>

    <input type="text" value="{{ request('search') }}" name="search" placeholder="Buscar..." class="ml-1 form-control">

    <button type="submit" class="ml-2 btn btn-success"><i class="fa fa-search"></i>Buscar</button>
</form>
<table class="table">
    <thead>
        <tr>
            <td>Id</td>
            <td>Título</td>
            <td>Categorías</td>
            <td>Posteado</td>
            <td>Creación</td>
            <td>Actualización</td>
            <td>Acciones</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($clases as $clase)
        <tr>
            <td>{{$clase->id}}</td>
            <td>{{$clase->title}}</td>
            <td>{{$clase->category->title}}</td>
            <td>{{$clase->posted}}</td>
            <td>{{substr($clase->start, 0, 10)}}</td>
            <td>{{substr($clase->end, 0, 10)}}</td>
            <td>
            <a href="{{route('clase.show', $clase->id)}}" class="btn btn-primary">Ver</a>
            <a href="{{route('clase.edit', $clase->id)}}" class="btn btn-primary">Actualizar</a>
            <a href="{{route('post-comment.post', $clase->id)}}" class="btn btn-primary">Comentarios</a>

            <button class="btn btn-danger" type="button"  data-toggle="modal" data-target="#deleteModal" data-id="{{$clase->id}}">Eliminar</button>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p>Seguro que quieres borrar el registro seleccionado?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

          <form id="formDelete" method="POST" action="{{route('clase.destroy', 0)}}" data-action="{{route('clase.destroy', 0)}}">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger">Borrar</button>
          </form>

        </div>
      </div>
    </div>
  </div>

{{$clases->appends(
    [
        'start' => request('start'),
        'search' => request('search'),
    ]
    )->links()}}

<script>
      window.onload = function(){
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
        
            action = $('#formDelete').attr('data-action').slice(0,-1)
            action += id
            console.log(action)
            $('#formDelete').attr('action', action)
            var modal = $(this)
            modal.find('.modal-title').text('Vas a borrar la Clase: ' + id)
        })
      }
  </script>
@endsection