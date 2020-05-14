@extends('dashboard.master')

@section('content')

    <div class="form-group">
        <label for="title">Nombre</label>
            <input readonly class="form-control" type="text" value="{{$contact->name}}">

    </div>
    <div class="form-group">
        <label for="url_clean">Teléfono</label>
            <input readonly class="form-control" type="text" value="{{$contact->phone}}">

    </div>
    <div class="form-group">
        <label for="url_clean">Email</label>
            <input readonly class="form-control" type="text" value="{{$contact->email}}">

    </div>
    <div class="form-group">
        <label for="content">Contenido</label>
            <textarea readonly class="form-control" name="content" id="content" cols="30" rows="10" >{{$contact->message}}</textarea>
    </div>
    
@endsection