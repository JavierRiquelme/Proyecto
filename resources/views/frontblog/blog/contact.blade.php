@extends('frontblog.master')

@section('content')

<header class="masthead" style="background-image: url('/img/contact-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1>Contáctame</h1>
            <span class="subheading">¿Tiene preguntas? Tengo respuestas</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <p>¿Quieres ponerte en contacto? Complete el siguiente formulario para enviarme un mensaje y me pondré en contacto con usted lo antes posible.</p>

        @if (session('status'))
              <div class="alert alert-success">
                  {{session('status')}}
              </div>
        @endif
        
        <form method="POST" action="{{route('blog.store')}}" name="sentMessage" id="contactForm" novalidate>
          @csrf
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label for="name">Nombre</label>
              <input type="text" class="form-control" placeholder="Nombre" id="name" name="name" required data-validation-required-message="por favor introduce tú nombre.">
              @error('name')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label for="email">Dirección Email</label>
              <input type="email" class="form-control" placeholder="Dirección email" id="email" name="email" required data-validation-required-message="por favor introducce tú dirección email.">
              @error('email')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
          <div class="control-group">
            <div class="form-group col-xs-12 floating-label-form-group controls">
              <label for="phone">Número de Teléfono</label>
              <input type="tel" class="form-control" placeholder="Número de teléfono" id="phone" name="phone" required data-validation-required-message="Por favor introduce tú número de teléfono.">
              @error('phone')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label for="message">Mensaje</label>
              <textarea rows="5" class="form-control" placeholder="Mensaje" id="message" name="message" required data-validation-required-message="Por favor introduce un mensaje."></textarea>
              @error('message')
                <small class="text-danger">{{$message}}</small>
              @enderror
            </div>
          </div>
          <br>
          <input type="hidden" name="user_id" id="user_id" value="2">
          <div id="success"></div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" id="sendMessageButton">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <hr>
@endsection