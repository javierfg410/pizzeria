<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-plus" @click="handleCreate">
        {{ $t('table.add') }}
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
      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button type="danger" size="small" icon="el-icon-delete" @click="handleDelete(scope.row.id, scope.row.name);">
            Eliminar
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog :title="'Crear Nuevo Ingrediente'" :visible.sync="dialogFormVisible">
      <div v-loading="ingredienteCreating" class="form-container">
        <el-form ref="ingredienteForm" :rules="rules" :model="newIngrediente" label-position="left" label-width="150px" style="max-width: 500px;">
          <el-form-item :label="$t('ingrediente.nombre')" prop="name">
            <el-input v-model="newIngrediente.nombre" />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">
            {{ $t('table.cancel') }}
          </el-button>
          <el-button type="primary" @click="createIngrediente()">
            {{ $t('table.confirm') }}
          </el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import IngredienteResource from '@/api/ingrediente';
import waves from '@/directive/waves'; // Waves directive
import permission from '@/directive/permission'; // Permission directive

const ingredienteResource = new IngredienteResource();

export default {
  name: 'IngredienteList',
  directives: { waves, permission },
  data() {
    return {
      list: null,
      total: 0,
      loading: true,
      downloading: false,
      ingredienteCreating: false,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
        ingrediente: '',
      },
      newIngrediente: {},
      dialogFormVisible: false,
      dialogPermissionVisible: false,
      dialogPermissionLoading: false,
      currentIngredienteId: 0,
      currentIngrediente: {
        name: '',
        precio: '',
      },
      rules: {
        nombre: [{ required: true, message: 'Nombre es obligatorio', trigger: 'blur' }],
      },
    };
  },
  computed: {
  },
  created() {
    this.resetNewIngrediente();
    this.getList();
  },
  methods: {
    async getList() {
      console.log('aqui llego');
      console.log(this.query);
      const { limit, page } = this.query;
      this.loading = true;
      const data = await ingredienteResource.list(this.query);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      console.log(this.list);
      this.total = 0;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleCreate() {
      this.resetNewIngrediente();
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['ingredienteForm'].clearValidate();
      });
    },
    handleDelete(id, name) {
      this.$confirm('This will permanently delete Ingrediente ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        ingredienteResource.destroy(id).then(response => {
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
    createIngrediente() {
      this.$refs['ingredienteForm'].validate((valid) => {
        if (valid) {
          this.ingredienteCreating = true;
          ingredienteResource
            .store(this.newIngrediente)
            .then(response => {
              this.$message({
                message: 'New Ingrediente ' + this.newIngrediente.nombre + '(' + this.newIngrediente.precio + ') has been created successfully.',
                type: 'success',
                duration: 5 * 1000,
              });
              this.resetNewIngrediente();
              this.dialogFormVisible = false;
              this.handleFilter();
            })
            .catch(error => {
              console.log(error);
            })
            .finally(() => {
              this.IngredienteCreating = false;
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    resetNewIngrediente() {
      this.newIngrediente = {
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

      ingredienteResource.updatePermission(this.currentIngredienteId, { permissions: checkedPermissions }).then(response => {
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
