
<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>book</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link :to="{name: 'Home'}">Home</router-link></li>
              <li class="breadcrumb-item active">book</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content" v-if="has_permission === true">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <div class="btn-toolbar pull-right">
                <el-dropdown split-button :trigger="'click'"
                             @command="handleSelectedRows"
                             type="primary" v-if="this.selected_row.length" class="mr-1">
                  {{ this.selected_row.length }} {{ 'item' | pluralize(this.selected_row.length) }} selected
                  <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item command="delete">Delete Selected Items</el-dropdown-item>
                  </el-dropdown-menu>
                </el-dropdown>
                <button class="btn btn-info" type="button" @click="showFilter = !showFilter">
                  <i class="fa fa-filter"></i> Filter
                </button>
              </div>

              <div class="card-tools">
                <router-link :to="{ name: 'bookAdd'}" class="btn btn-success" v-if="actionCreate">
                  <i class="fas fa-plus"></i> New
                </router-link>
                <button class="btn btn-info" @click="exportFile()">
                  <i class="fas fa-download"></i> Export
                </button>

              </div>
            </div>
            <div class="overlay" v-if="is_loading">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
            <form @submit.prevent="getFilterData()" method="GET" novalidate>
              <div class="card-body" v-if="showFilter">
                <div class="form-row">
                  <div class="col-md-6">
                    <div class="form-group from-row">
                      <label class="col-md-3 col-form-label" for="name">Product Name</label>
                      <div class="col-md-9">
                        <input type="text" id="name" class="form-control" v-model="filter.name" placeholder="Product Name">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-9">
                        <button type="submit" class="btn btn-common m-2px"><i class="fas fa-search"></i> Search</button>
                        <button type="reset" class="btn btn-warning" @click="resetFilter()"><i class="fas fa-undo"></i> Reset</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <div class="card-body table-responsive-md p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th style="width: 10px">
                      <input type="checkbox" v-model="is_selected_all" @click="selectedRowAll()">
                    </th>
                    <th>ID <sort-icons :_sort="'id'"/></th>
                    <th>Product Name <sort-icons :_sort="'name'"/></th>
                    <th>quantity <sort-icons :_sort="'quantity'"/></th>
                    <th>Image  <sort-icons :_sort="'iamge'"/></th>
                    <th>Status  <sort-icons :_sort="'status'"/></th>

                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                  <tr v-for="(val, index) in list.data" :key="index">
                    <td>
                      <input type="checkbox" v-model="selected_row" :value="val.id">
                    </td>
                    <td>{{ val.id }}</td>
                    <td>{{ val.name }}</td>
                    <td>{{ val.quantity }}</td>
                     
                    <td><img :src="API_ASSET_UPLOAD_URL+ '/' + val.iamge" /> </td>

                    <td>{{ val.status }}</td> 
                      <td class="text-right">


                        <router-link v-if="actionView == true" :to="{ name: 'bookShow', params: { id: val.id }}" class="btn btn-info btn-sm m-2px">
                          <i class="fas fa-eye"></i>
                        </router-link>
                        <router-link v-if="actionEdit == true && checkEditPermission(val)" :to="{ name: 'bookEdit', params: { id: val.id }}" class="btn btn-info btn-sm m-2px">
                          <i class="fas fa-pencil-alt"></i>
                        </router-link>
                        <a v-if="actionDelete == true && checkDeletePermission(val)" class="btn btn-danger btn-sm m-2px" href="javascript:void(0)" @click="deleteObject(val.id, index)"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="p-4" v-if="_.isEmpty(list.data) && is_loading == false">
                <div class="alert alert-default-warning" role="alert">
                  No data found!
                </div>
              </div>
            </div>
            <div class="card-footer">
              <vue-pagination
                :pagination="list"
                v-if="list.total > list.per_page"
                @paginate="reload()"
              ></vue-pagination>
            </div>
          </div>
        </div>
    </section>

    <section class="content" v-if="has_permission === false">
      <div class="alert alert-danger alert-dismissible">
        <h5><i class="icon fas fa-ban"></i> Permission denied!</h5>
      </div>
    </section>
  </div>
</template>

<script>
import VuePagination from '@/components/partials/PaginationComponent'
import SortIcons from '@/components/utils/SortIcons'
import axios from 'axios'
import DatePicker from 'vue3-datepicker';
import 'vue2-datepicker/index.css'
import { CommonAPI, PermissionChecker } from '@/services/api'
import { mapGetters, mapActions } from 'vuex'
import { Notification } from 'element-ui'
// eslint-disable-next-line @typescript-eslint/no-var-requires
const fileDownload = require('js-file-download')

export default {
  name: 'book',
  metaInfo: {
    title: 'book '
  },
  components: {
    DatePicker, VuePagination, SortIcons
  },
  data: () => ({
    list: {
      total: 0,
      per_page: 1,
      from: 1,
      to: 0,
      current_page: 1
    },
    actionCreate: false,
    actionView: true,
    actionEdit: true,
    actionDelete: true,
    api_url: '',
    showFilter: false,
    filter: {},
    dateRange: '',
    pre: [],
    is_loading: false,
    empty: false,
    empty_message: '',
    custom_permission_data: [],
    has_permission: true,
    selected_row: [],
    is_selected_all: false
  }),
  watch: {
    '$route.query' () {
      this.reload()
    }
  },
  mounted: function () {
    if (this.isMobile()) {
      // window.$(document).find('.push-menu-class').trigger('click');
      window.$('body').removeClass('sidebar-open')
      window.$('body').addClass('sidebar-closed sidebar-collapse')
    }
    this.api_url = '/books'
    this.initialize()
    /* this.$root.$on('sort-data', () => {
      this.$root.$emit('show-icon')
      this.reload()
    }) */
  },
  computed: {
    ...mapGetters(['profile'])
  },
  methods: {
    async initialize () {
      this.is_loading = true      
      if ('name' in this.$route.query) {
        this.filter.name = this.$route.query.name
        this.showFilter = true
      } else {
        this.filter.name = ''
      }
      if ('quantity' in this.$route.query) {
        this.filter.quantity = this.$route.query.quantity
        this.showFilter = true
      } else {
        this.filter.quantity = ''
      }
      
      // eslint-disable-next-line no-undef
      if (_.isEmpty(this.profile)) {
        // eslint-disable-next-line camelcase
        await CommonAPI.getProfile().then(profile_info => {
          // eslint-disable-next-line camelcase
          this.user_detail = profile_info
        })
      } else {
        this.user_detail = this.profile
      }

      await CommonAPI.getCustomPermission('/get-custom-permission-infos?path=api/books').then(response => {
        // eslint-disable-next-line eqeqeq
        if (response.status == 200) {
          this.custom_permission_data = response.data
        }
      })

      // eslint-disable-next-line no-undef
      if (!_.isEmpty(this.custom_permission_data)) {
        this.actionCreate = await PermissionChecker.checkCreateButtonPermission(this.custom_permission_data.action_permission,
          this.custom_permission_data['create_id_condition'], this.user_detail, this.custom_permission_data.enableAdministratorPermissionByDefault)
      }

      await this.getList().then(response => {
        this.list = response.data
      }).catch(error => {
        this.empty = true
        if (error.response.status === 403) {
          this.has_permission = false
        }
      })
      this.is_loading = false
    },
    async getFilterData () {
      /* this.is_loading = true
      await this.getList().then(response => {
        this.list = response.data
      }).catch(error => {
        this.empty = true
        if (error.response.status === 403) {
          this.has_permission = false
        }
      })
      this.is_loading = false */
      // eslint-disable-next-line @typescript-eslint/no-empty-function
      this.$router.push({ path: this.$route.fullPath, query: { name: this.filter.name, quantity: this.filter.quantity,  } }).catch(() => {})
    },
    reload: function () {
      this.is_loading = true
      if ('name' in this.$route.query) {
        this.filter.name = this.$route.query.name
        this.showFilter = true
      } else {
        this.filter.name = ''
      }
      if ('quantity' in this.$route.query) {
        this.filter.quantity = this.$route.query.quantity
        this.showFilter = true
      } else {
        this.filter.quantity = ''
      }
      
      this.getList().then(response => {
        this.list = response.data
      }).catch(error => {
        this.empty = true
        if (error.response.status === 403) {
          this.has_permission = false
        }
      }).finally(() => {
        this.is_loading = false
      })
    },
    getList: function () {
      return new Promise((resolve, reject) => {
        /* let params = {page: this.list.current_page}
        params = {...this.filter, ...this.$route.query, ...params} */
        const params = { ...this.filter, ...this.$route.query }
        axios.get(this.api_url, {
          params: params
        }).then(response => {
          resolve(response)
        }).catch(error => {
          reject(error)
          // console.log("error", error.response.data);
        }).finally(() => {
          // _this.is_loading = false;
        })
      })
    },
    checkEditPermission: function (data) {
      // eslint-disable-next-line no-undef
      if (!_.isEmpty(this.custom_permission_data)) {
        return PermissionChecker.checkEditButtonPermission(this.custom_permission_data.action_permission, this.custom_permission_data['edit_id_condition'],
          this.custom_permission_data['edit_refid_condition'], this.custom_permission_data['edit_custom_condition'], data, this.user_detail, this.custom_permission_data.enableAdministratorPermissionByDefault, this.custom_permission_data['operator_between_block_condition_rules'])
      } else {
        return false
      }
    },
    checkDeletePermission: function (data) {
      // eslint-disable-next-line no-undef
      if (!_.isEmpty(this.custom_permission_data)) {
        return PermissionChecker.checkDeleteButtonPermission(this.custom_permission_data.action_permission, this.custom_permission_data['delete_id_condition'],
          this.custom_permission_data['delete_refid_condition'], this.custom_permission_data['delete_custom_condition'], data, this.user_detail, this.custom_permission_data.enableAdministratorPermissionByDefault, this.custom_permission_data['operator_between_block_condition_rules'])
      } else {
        return false
      }
    },
    async resetFilter () {
      /* this.list.current_page = 1
      this.filter = {}
      this.is_loading = true
      await this.getList().then(response => {
        this.list = response.data
      }).catch(error => {
        this.empty = true

        if (error.response.status === 403) {
          this.has_permission = false
        }
      })
      this.is_loading = false */
      this.filter = {}
      // eslint-disable-next-line @typescript-eslint/no-empty-function
      this.$router.push({ path: this.$route.path }).catch(() => {})
    },
    deleteObject: function (id, index) {
      // eslint-disable-next-line @typescript-eslint/no-this-alias
      const _this = this
      // eslint-disable-next-line camelcase
      const delete_api_url = '/books/' + id

      _this.$swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          _this.is_loading = true
          axios.delete(delete_api_url)
            .then(response => {
              _this.list.data.splice(index, 1)
              _this.$toaster.success(response.data.message)
              _this.is_loading = false
            })
            .catch(error => {
              _this.is_loading = false
              console.log(error)
              _this.$swal.fire(
                'Failed!',
                'failed to delete.',
                'error'
              )
            })
            .finally(() => {
              _this.is_loading = false
            })
        }
      })
    },
    exportFile: function () {
      this.is_loading = true
      axios.get('/books-export', {responseType: 'blob'})
        .then(response => {
          fileDownload(response.data, 'books.xlsx')
        })
        .catch((error) => {
          console.log('error ' + error)
        })
        .finally(() => {
          this.is_loading = false
          Notification.success({ title: 'Export Completed', message: 'Export operation completed successfully', type: 'success' })
        })
    },
    selectedRowAll: function () {
      const isSelectedAll = this.is_selected_all = !this.is_selected_all
      if (isSelectedAll) {
        var items = []
        this.list.data.forEach(function (item) {
          items.push(item.id)
        })
        this.selected_row = items
      } else {
        this.selected_row = []
      }
    },
    handleSelectedRows(command) {
      if (command === 'delete') {
        axios({
          method: 'delete',
          url: '/books/delete-all',
          data: { 'ids': this.selected_row },
          headers: { 'Content-Type': 'application/json' }
        }).then(function (response) {
          Notification.success({ title: 'Deleted Successfully', message: 'Data deleted successfully', type: 'success' })
          this.initialize()
        }).catch((errors) => {
          // eslint-disable-next-line no-undef
          if (!_.isEmpty(errors.response) && errors.response.status === 500) {
            this.$toaster.error(errors.response.data.message)
          }
        }).finally(() => {
          this.is_selected_all = false
          this.initialize()
        })
      }
    }
  }
  /* created() {
    this.$emit("update:layout", MasterLayout);
  } */
}
</script>
