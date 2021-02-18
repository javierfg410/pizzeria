require('./bootstrap');
window.Vue = require('vue').default;
//import Vue from 'vue/dist/vue.esm.js';
import Vue from 'vue';


import DropdownMenu from 'v-dropdown-menu';
import 'v-dropdown-menu/dist/v-dropdown-menu.css'; // Base style, required.


Vue.use(DropdownMenu)  ;
  const app = new Vue({
    el: '#app',
    data: {
        cart:[],
        mostrarMenu: 'true',
    },
    mounted() {
        if (localStorage.getItem('cart')) {
          try {
            this.cart = JSON.parse(localStorage.getItem('cart'));
          } catch(e) {
            localStorage.removeItem('cart');
          }
        }
    },
    computed : {
      
      pizzaCesta(){
        var precioTotal = 0;
        this.cart.forEach(pizza => {
          precioTotal = precioTotal + (parseFloat(pizza.precio) * pizza.cantidad);
        });
        return precioTotal;
      },
      cartAmount(){
        var cestaTotal = 0;
        this.cart.forEach(pizza => {
          cestaTotal = cestaTotal + (1 * pizza.cantidad);
        });
        return cestaTotal
      }
    },
    methods: {
      precioIndividual(id){
        if(this.cart.find(b => b.id === id)){
          var pizza = this.cart.find(b => b.id === id);
          return (pizza.cantidad * parseFloat(pizza.precio));
        }else{
          return 0;
        }

      },
      addToCart(id,precio){
        if(this.cart.find(b => b.id === id)){
          this.cart.find(b => b.id === id).cantidad++;
        }else{
          var pizza = {
            'id' : id,
            'precio' : precio,
            'cantidad' : 1
          }   
          this.cart.push(pizza);
        }
        const parsed = JSON.stringify(this.cart);
        localStorage.setItem('cart', parsed);
      },
      borrarPedido(){
        this.cart = [];
        const parsed = JSON.stringify(this.cart);
        localStorage.setItem('cart', parsed);
      },
      enviarPedido(){
        let vm= this;
        axios.post('/pedido', vm.cart).then(
          function(response){
            if(response.data){
              console.log(response);
            }else{
              window.location.href = '/login';
            }
          })
          .catch(function (error){
            var errors = error.response;
            console.log(errors);
          });
        
      }

    }
  });