@extends('layouts.landingPage')
@section('title', 'Citas')
@section('content')


<div class="container">
<div class="text-center">
  <img src="{{ asset('img/logo.png') }}" alt="Logo del ITSC" class="text-center">
<br><br>
            <h4>La cita de {{ $language->language }} esta pautada para el
            {{ $language->date }}
            en el edificio
            {{ $language->location }} 
            a las 
           {{ $language->time }}</h4>

            
      </div> 
</div>

@endsection

@section('script')
<script>

  $(document).ready(inicio);
  
  function inicio(){
    window.print();
   
  }
</script>

@endsection
   