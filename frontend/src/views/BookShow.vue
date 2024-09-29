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
              <li class="breadcrumb-item">
                <router-link :to="{name: 'Home'}">Home</router-link>
              </li>
              <li class="breadcrumb-item active">book</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="overlay" v-if="is_loading">
        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="overlay" v-if="is_loading">
              <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
            <div class="card-header">
              <h3 class="card-title">Detail</h3>
              <div class="card-tools">
                <router-link class="btn btn-info" :to="{name: 'bookList'}">
                  <i class="fas fa-list"></i> List
                </router-link>
              </div>
            </div>
            <div class="card-body">
              <div class="custom-list">
                <ul>
                  
                  <li><strong>ID</strong> {{ value.id }}</li>
                  
                  <li><strong>Product Name</strong> {{ value.name }}</li>
                  
                  <li><strong>quantity</strong> {{ value.quantity }}</li>
                  
                  <li><strong>Image </strong> 
                   <li><strong>Status </strong> 
                      <img v-bind:src="API_ASSET_UPLOAD_URL+value.iamge" class="img-fluid img-thumbnail rounded" style="width: 200px;">
                      </li>
                  
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </section>
  </div>
</template>

<script>
// import MasterLayout from "@/components/layouts/MasterLayoutComponent.vue";
import {DepartmentsAPI} from '@/services/api'
import axios from 'axios'
import { Notification } from 'element-ui'
const fileDownload = require("js-file-download")


export default {
  name: 'bookShow',
  metaInfo: {
    title: 'book '
  },
  data: () => ({
    value: {
      
    },
    pre: {
      
    },
    is_loading: false
  }),
  mounted: function () {
    this.initialize()
  },
  methods: {
    
    async initialize () {
      this.is_loading = true
      this.params = this.$route.params

      

      await this.getDetail(this.params.id).then(response => {
        this.value = response.data
      });

      this.is_loading = false
    },
    downloadFile: function(url) {
      this.is_loading = true
      axios.get(this.API_ASSET_UPLOAD_URL+url, {responseType: "arraybuffer"})
        .then(response => {
          fileDownload(response.data, url.replaceAll("/", "-"))
          Notification.success({ title: 'Download Completed', message: 'Download completed successfully', type: 'success' })
        })
        .catch(error => {
          Notification.error({ title: 'Download Failed', message: 'Failed to download', type: 'error' })
        })
        .finally(() => {
          this.is_loading = false
        });
    },
    getDetail: function (id) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line camelcase
        const api_url = '/books/' + id;
        axios.get(api_url)
          .then(response => {
            resolve(response)
          })
          .catch((error) => {
            console.log('error ' + error)
            reject(error)
          })
          .finally(() => {
          });
      })
    },
  },
  /* created() {
    this.$emit("update:layout", MasterLayout);
  }, */
}
</script>
        