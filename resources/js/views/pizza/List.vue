<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-plus" @click="handleCreate">
        Añadir
      </el-button>
    </div>
    <el-table v-loading="loading" :data="list" border fit highlight-current-row style="width: 100%">
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Nombre">
        <template slot-scope="scope">
          <span>{{ scope.row.nombre }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Precio">
        <template slot-scope="scope">
          <span>{{ scope.row.precio }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.pizza_id, scope.row.nombre);">
            Eliminar
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog :title="'Crear Nueva Pizza'" :visible.sync="dialogFormVisible">
      <div class="form-container">
        <el-form ref="pizzaForm" :rules="rules" :model="newPizza" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item label="Nombre" prop="name">
            <el-input v-model="newPizza.nombre" />
          </el-form-item>
          <el-form-item label="Precio" prop="number">
            <el-input v-model="newPizza.precio" />
          </el-form-item>
          <el-form-item label="Ingredientes" prop="checkbox">
            <div v-for="ingrediente in listIngredientes" :key="ingrediente.ingrediente_id" :data="listIngredientes">
              <el-checkbox :id="ingrediente.ingrediente_id" v-model="ingredientes" :label="ingrediente.nombre" :value="ingrediente.ingrediente_id">{{ ingrediente.nombre }}</el-checkbox>
            </div>
          </el-form-item>
        </el-form>

        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">
            {{ $t('table.cancel') }}
          </el-button>
          <el-button type="primary" @click="createPizza()">
            {{ $t('table.confirm') }}
          </el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import PizzaResource from '@/api/pizza';
import waves from '@/directive/waves'; // Waves directive
import permission from '@/directive/permission'; // Permission directive
import IngredienteResource from '@/api/ingrediente';

const pizzaResource = new PizzaResource();
const ingredienteResource = new IngredienteResource();

export default {
  name: 'PizzaList',
  directives: { waves, permission },
  data() {
    return {
      list: null,
      listIngredientes: null,
      ingredientes: [],
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
      newPizza: {
        nombre: null,
        precio: null,
        ingredientes: [],
      },
      dialogFormVisible: false,
      dialogPermissionVisible: false,
      dialogPermissionLoading: false,
      currentPizzaId: 0,
      currentPizza: {
        pizza_id: '',
        name: '',
        precio: '',
      },
      rules: {
        nombre: [{ required: true, message: 'Nombre es obligatorio', trigger: 'blur' }],
        precio: [{ required: true, message: 'Precio es obligatorio', trigger: 'blur' }],
      },
    };
  },
  computed: {
  },
  created() {
    this.resetNewPizza();
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const data = await pizzaResource.list(this.query);
      const ing = await ingredienteResource.list(this.query);
      this.list = data;
      this.listIngredientes = ing;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = 0;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleCreate() {
      this.resetNewPizza();
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['pizzaForm'].clearValidate();
        this.ingredientes = [];
      });
    },
    handleDelete(id, name) {
      this.$confirm('Se eliminara la Pizza ' + name + '. ¿Continuar?', 'Warning', {
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        type: 'warning',
      }).then(() => {
        pizzaResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
          this.handleFilter();
        }).catch(error => {
          console.log(error);
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },
    createPizza() {
      this.newPizza.ingredientes = this.ingredientes;
      this.$refs['pizzaForm'].validate((valid) => {
        if (valid) {
          this.pizzaCreating = true;
          pizzaResource
            .store(this.newPizza)
            .then(response => {
              this.$message({
                message: 'New Pizza ' + this.newPizza.nombre + '(' + this.newPizza.precio + ') has been created successfully.',
                type: 'success',
                duration: 5 * 1000,
              });
              this.resetNewPizza();
              this.dialogFormVisible = false;
              this.handleFilter();
              this.loading = false;
              this.PizzaCreating = false;
              console.log(this.PizzaCreating);
            })
            .catch(error => {
              console.log(error);
              this.PizzaCreating = false;
            })
            .finally(() => {
              this.PizzaCreating = false;
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    resetNewPizza() {
      this.newPizza = {
        nombre: '',
        precio: '',
      };
    },

    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => v[j]));
    },
    permissionKeys(permissions) {
      return permissions.map(permssion => permssion.id);
    },

    normalizeMenuPermission(permission) {
      return { id: permission.id, name: this.$options.filters.uppercaseFirst(permission.name.substring(10)), disabled: permission.disabled || false };
    },

    normalizePermission(permission) {
      const disabled = permission.disabled || permission.name === 'manage permission';
      return { id: permission.id, name: this.$options.filters.uppercaseFirst(permission.name), disabled: disabled };
    },

    confirmPermission() {
      const checkedMenu = this.$refs.menuPermissions.getCheckedKeys();
      const checkedOther = this.$refs.otherPermissions.getCheckedKeys();
      const checkedPermissions = checkedMenu.concat(checkedOther);
      this.dialogPermissionLoading = true;

      pizzaResource.updatePermission(this.currentPizzaId, { permissions: checkedPermissions }).then(response => {
        this.$message({
          message: 'Permissions has been updated successfully',
          type: 'success',
          duration: 5 * 1000,
        });
        this.dialogPermissionLoading = false;
        this.dialogPermissionVisible = false;
      });
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
