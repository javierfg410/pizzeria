import request from '@/utils/request';
import Resource from '@/api/resource';

class PizzaResource extends Resource {
  constructor() {
    super('pizzas');
  }
  ingredientes(id) {
    return request({
      url: '/' + this.uri + '/' + id + '/ingredientes',
      method: 'get',
    });
  }
}
export { PizzaResource as default };
