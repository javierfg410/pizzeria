

<div id="carouselPizza" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
    @foreach($pizzas as $num =>$pizza)
    <li data-target="#carouselPizza" data-slide-to="{{$num-1}}" {{  $num == "1" ? 'class="active"' :''  }} ></li>
    @endforeach 
     
    </ol>
    <div class="carousel-inner">
    @foreach($pizzas as $num =>$pizza)
        
        <div class="carousel-item {{  $num == "1" ? "active" :""  }}">
            <img class="d-block h-100 mx-auto" src="{{ asset('img/pizza/' . $pizza["nombre"] . '.png')  }}" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h1 class="texto-borde">{{$pizza["nombre"]}}</h5>
                <p class="texto-borde">
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