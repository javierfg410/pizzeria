@extends('layouts.app')

@section('content')

<div id="carouselPizza" class=" bg-trasparente carousel slide" data-ride="carousel" style="height:90vh">
    <img class=" w-100 " src="{{ asset('img/clasicas.png')  }}" alt="">
    <ol class="carousel-indicators">
    @foreach($pizzas as $num =>$pizza)
    <li data-target="#carouselPizza" data-slide-to="{{$num-1}}" {{  $num == "1" ? 'class="active"' :''  }} ></li>
    @endforeach 
     
    </ol>
    <div class="carousel-inner">
    @foreach($pizzas as $num =>$pizza)
        
        <div class="carousel-item {{  $num == "1" ? "active" :""  }} product">
            <img class="d-block h-100 mx-auto" src="{{ asset('img/pizza/' . $pizza["nombre"] . '.png')  }}" alt="First slide">
            <div class="carousel-caption d-none d-md-block" style="position: static">
                <button class="add-to-cart"  @click='addToCart("{{ $pizza["nombre"] }}", "{{ $pizza["precio"] }}")'>Añadir a la cesta</button>
                <h1 class="texto-borde"style="">{{$pizza["nombre"]}}</h1>
                <p class="texto-borde" style="">
                @foreach($pizza["ingredientes"] as $valor => $ingrediente)
                    {{$ingrediente["nombre"]}} {{  $valor == count($pizza["ingredientes"])-1 ? "" :","  }}
                @endforeach</p>
            </div>
        </div>
        
        @endforeach 

    </div>
    <a class="carousel-control-prev" href="#carouselPizza" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselPizza" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <img class=" w-100 bg-trasparente" src="{{ asset('img/menu.png')  }}" alt="">
  <div class="container-fluid bg-trasparente overflow-hidden ">
    
    @foreach($pizzas as $num =>$pizza)
    @if( $num ==1)
        <div class="row">
    @elseif($num % 7 == 0 )
    </div>
    <div class="row">
    @endif 
        <div class="col-lg-2 col-sm-2 col-md-2" >
            <p class="texto-borde texto-pizza"
             >
                {{$pizza["nombre"]}}
            </p>
            <a href="#carouselPizza" data-slide-to="{{$num-1}}"><img  class="img-fluid" src="{{ asset('img/pizza/' . $pizza["nombre"] . '.png')  }}" alt="" ></a>
            
           
        </div>
       
    @endforeach 
  
  </div>
  
  @endsection