<template>
  <div class="app-container" style="backgroung-color:black">
    <div class="filter-container">
      <div class="right-menu" style="float: right;">
        <button class=" button btn btn-light" @click="login()">
          <span class="description">Inicio Sesión</span>
        </button>
        <el-dropdown class=" right-menu-item hover-effect" trigger="click">
          <button class=" button btn btn-light">
            <span class="amount">{{ cartAmount }} </span>
            <span class="description">Cart</span>
            <span class="total">{{ pizzaCesta }}</span>
          </button>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item>
              <span style="display:block;"> Pedido </span>
            </el-dropdown-item>
            <el-dropdown-item>
              <span v-for="i in cart" :key="i.id">
                <ul>
                  <li>
                    {{ i.cantidad }}{{ i.id }}: Precio {{ precioIndividual(i.id) }}
                  </li>
                </ul>
              </span>
            </el-dropdown-item>
            <el-dropdown-item>
              <div>Total pedido {{ pizzaCesta }} <button @click="enviarPedido">pedir</button> <button @click="borrarPedido">Limpiar</button></div>
            </el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div v-for="pizza in pizzas" :key="pizza.pizza_id" :data="pizzas" class="col-md-6">
          <div class="container-fluid" @click="addToCart(pizza.nombre, pizza.precio)">
            <div class="row">
              <div class="col-md-12 w-100 h-100 vertical-center" style="text-align: center;">
                <img :src="pizza.src" class="img-fluid " alt="pizza.nombre">
              </div>
              <div class="col-md-12 w-100 h-100 vertical-center" style="position: absolute; text-align: center;display: flex;align-items: center;">
                <div class=" w-100">
                  <button class="btn btn-light">
                    Pizza: {{ pizza.nombre }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PizzaResource from '@/api/pizza';
import PedidoResource from '@/api/pedido';
import waves from '@/directive/waves'; // Waves directive
import permission from '@/directive/permission'; // Permission directive
import '@splidejs/splide/dist/css/themes/splide-default.min.css';
const pizzaResource = new PizzaResource();
const pedidoResource = new PedidoResource();

export default {
  name: 'CatalogoPizza',
  directives: { waves, permission },
  data() {
    return {
      cart: [],
      pizzas: null,
      total: 0,
      loading: true,
      downloading: false,
      pizzaCreating: false,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        pizza: '',
      },
      newPizza: {},
      dialogFormVisible: false,
      dialogPermissionVisible: false,
      dialogPermissionLoading: false,
      currentPizzaId: 0,
      currentPizza: {
        name: '',
        precio: '',
        src: '',
      },
    };
  },
  computed: {
    pizzaCesta(){
      var precioTotal = 0;
      this.cart.forEach(pizza => {
        precioTotal = precioTotal + (parseFloat(pizza.precio) * pizza.cantidad);
      });
      return precioTotal;
    },
    cartAmount(){
      this.getList;
      var cestaTotal = 0;
      this.cart.forEach(pizza => {
        cestaTotal = cestaTotal + (1 * pizza.cantidad);
      });
      return cestaTotal;
    },
  },
  async mounted() {
    const { limit, page } = this.query;
    this.loading = true;
    const data = await pizzaResource.list(this.query);
    this.pizzas = data;
    console.log(data);
    this.pizzas.forEach((element, index) => {
      this.getIngredienes(element.pizza_id);
      this.pizzas[index].src = '/img/pizza/' + element.nombre + '.png';
      element['index'] = (page - 1) * limit + index + 1;
    });
    this.total = 0;
    this.loading = false;
    if (localStorage.getItem('cart')) {
      try {
        this.cart = JSON.parse(localStorage.getItem('cart'));
      } catch (e) {
        localStorage.removeItem('cart');
      }
    }
  },
  methods: {
    login(){
      this.$router.push('/login?redirect=');
    },
    async getIngredienes(id){
      this.loading = true;
      const data = await pizzaResource.ingredientes(id);
      this.pizzas[id].ingredientes = data;
      console.log(this.pizzas);
      this.loading = false;
    },
    precioIndividual(id){
      if (this.cart.find(b => b.id === id)){
        var pizza = this.cart.find(b => b.id === id);
        return (pizza.cantidad * parseFloat(pizza.precio));
      } else {
        return 0;
      }
    },
    addToCart(id, precio){
      if (this.cart.find(b => b.id === id)){
        this.cart.find(b => b.id === id).cantidad++;
      } else {
        var pizzaCart = {
          'id': id,
          'precio': precio,
          'cantidad': 1,
        };
        this.cart.push(pizzaCart);
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
      pedidoResource
        .store(this.cart)
        .then(response => {
          this.$message({
            message: 'Nuevo Pedido  Realizado correctamente.',
            type: 'success',
            duration: 5 * 1000,
          });
          this.borrarPedido();
        })
        .catch(error => {
          console.log(error);
        });
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => v[j]));
    },
  },
};
</script>

<style lang="scss" scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
.dialog-footer {
  text-align: left;
  padding-top: 0;
  margin-left: 150px;
}
.app-container {
  flex: 1;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
  .block {
    float: left;
    min-width: 250px;
  }
  .clear-left {
    clear: left;
  }
}
</style>
