<nav class="navbar navbar-expand-md navbar-light bg-danger shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
           
            <img class="bg-white rounded-circle" src="{{ asset('img/logo.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Lado izquierdo del menu -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Lado derecho del menu -->
            <ul class="navbar-nav ml-auto">
                <!-- Registro e Inicio de Sesion -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item bg-white">
                           
                            <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                           
                        </li>
                    @endif
                    
                    @if (Route::has('register'))
                        <li class="nav-item bg-white">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
                        </li>
                    @endif
                @else
                    <!--Menu de usuario-->
                    
                    <li class="nav-item dropdown" style="display: flex;
                    align-items: center;">
                  
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <li class="nav-item bg-white rounded-circle">
                    
                    <dropdown-menu
                    mode="hover">
                        <button slot="trigger"><div class="cart">
                            <img  src="{{ asset('img/cesta.png')  }}" alt="">
                            <span class="amount"> @{{ cartAmount }} </span>
                            <span class="description">Cart</span>
                            <span class="total">@{{ pizzaCesta }}</span>
                        </div></button>
                        <div slot="header">Pedido</div>
                        <ul slot="body">
                          <li v-for="i in cart" :key="i.id">@{{i.cantidad}} <a href="">@{{i.id}}: Precio @{{precioIndividual(i.id)}}</a></li>
                        </ul>
                        <div slot="footer">Total pedido @{{ pizzaCesta }} <button @click="enviarPedido">pedir</button> <button @click="borrarPedido">Limpiar</button></div>
                      </dropdown-menu>
                    
                </li>
            </ul>
        </div>
    </div>
</nav>