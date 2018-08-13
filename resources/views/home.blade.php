@extends('layouts.landingPage')
@section('title', 'home')
@section('title-content', 'Home')
@section('content')


@if(Session::has('message'))
<div class="alert alert-success" id="Success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ session::get('message') }}
</div>
@endif
<div class="row padding">
    <div class="col-lg-4 col-md-4">
      <div class="">

      <?php           
            $roll = Auth::user()->rolls_id;
            ?>
      @if($roll == 1 || $roll == 3)
      @if (count($query) > 0)
        @include('forms.home_search',['url'=>'home','link'=>'home'])

    @else
    <div class="container" id="error">
    @include('forms.home_search',['url'=>'home','link'=>'home'])
        <figure id="img-error">
          <img src="img/sad-face.png" alt="sad-face">
        </figure>
        <h2 class="text-center">Oops, no se encontro ningun dato.</h2>
    </div>

      @endif
      @else
      <h1>Bienvenido profesor</h1>
      @endif
      </div>
    </div>

@endsection

@section('script')
@include('forms.alerts')

@endsection

