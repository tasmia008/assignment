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
                <router-link :to="{ name: 'Home' }">Home</router-link>
              </li>
              <li class="breadcrumb-item active">book</li>
            </ol>
          </div>
        </div>
      </div>
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="card" id="book">
          <div class="overlay" v-if="is_loading">
            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
          </div>
          <form @submit.prevent="handleSubmission" method="POST" novalidate>
            <div class="card-header">
              <h3 class="card-title" v-if="!is_edit">Create</h3>
              <h3 class="card-title" v-if="is_edit">Edit</h3>
              <div class="card-tools">
                <router-link
                  class="btn btn-info"
                  :to="{ name: 'bookList' }"
                >
                  <i class="fas fa-list"></i> List
                </router-link>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <div class="form-group required">
                    <label class="control-label">book Name</label>
                    <input
                      type="text"
                      id="name"
                      name="name"
                      :class="{ 'has-error': errors.has('name') }"
                      v-validate="'required'"
                      v-model="value.name"
                      class="form-control name"
                      placeholder="book Name"
                    />
                    <div class="help text-danger" v-show="errors.has('name')">
                      {{ errors.first("name") }}
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="control-label">Quantity</label>
                    <input
                      type="text"
                      id="quantity"
                      name="quantity"
                      :class="{ 'has-error': errors.has('quantity') }"
                      v-validate="'required'"
                      v-model="value.quantity"
                      class="form-control quantity"
                      placeholder="Quantity"
                    />
                    <div
                      class="help text-danger"
                      v-show="errors.has('quantity')"
                    >
                      {{ errors.first("quantity") }}
                    </div>
                  </div>
                                              <!-- Conditionally show either the uploaded image or the existing image -->


                  <div class="col-md-12">
                    <h4 class="site-heading my-3"><span>Image </span></h4>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="iamge"></label>
                    <div class="row align-items-center">
                      <div class="col-4">
                        <div class="input-group p-2">
                          <div>
                            <img
                              :src="filePath"
                              alt="Image Preview"
                              width="100"
                              height="100"
                            />
                          </div>
                        </div>
                        <div class="input-group">
                          <div class="custom-file">
                            <input
                              type="file"
                              name="iamge"
                              class="custom-file-input"
                              id="iamge"
                              @change="select_file_iamge"
                            />
                            <label class="custom-file-label" for="iamge">
                              {{ value.iamge_name }}
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="help text-danger" v-show="errors.has('iamge')">
                    {{ errors.first("iamge") }}
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group required">
                    <label class="control-label" for="status">Status</label>
                    <multiselect
                      v-model="value.status"
                      :options="['Active', 'Inactive']"
                      placeholder="Select Status"
                      :searchable="true"
                      :multiple="false"
                      :class="{ 'has-error': errors.has('status') }"
                      id="status"
                      v-validate="'required'"
                      name="status"
                    ></multiselect>
                    <div class="help text-danger" v-show="errors.has('status')">
                      {{ errors.first("status") }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" v-if="!is_edit" class="btn btn-primary">
                Submit
              </button>
              <button type="submit" v-if="is_edit" class="btn btn-primary">
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>


<script>
import axios from "axios";


export default {
  name: "bookForm",
  data() {
    return {
      is_loading: false,
      is_edit: false,
      value: {
        iamge: "",
        iamge_name: "Choose file",
      },
      filePath: "", // For the newly uploaded image preview
    };
  },
 
 
  methods: {
    // select_file_iamge(event) {
    //         try {
    //   console.log("select file");
    //     const reader = new FileReader();
    //     reader.readAsDataURL(event.target.files[0]); //binary data get


    //     // Convert file to base64 string
    //     reader.onload = () => {
    //       this.value.iamge = reader.result; // file upload er binary data storee kore
    //       this.filePath = reader.result; // image show koreteche
    //       console.log(event.target.files);
    //       // Set preview for the newly selected image
    //       this.$set(this.value, "iamge_name", file.name); // Update image name
    //     };
    //   }
    // }
    // },
    select_file_iamge(event) {
  try {
    console.log("select file");
    const reader = new FileReader();
    reader.readAsDataURL(event.target.files[0]); // Get binary data


    // Convert file to base64 string
    reader.onload = () => {
      this.value.iamge = reader.result; // Store the binary data for upload
      this.filePath = reader.result; // Show image preview
      console.log(event.target.files);


      // Set preview for the newly selected image
      this.$set(this.value, "iamge_name", event.target.files[0].name); // Update image name
    };
  } catch (error) {
    console.error("Error reading file:", error);
  }
} ,


  handleSubmission() {
      let _this = this;
      this.$validator.validateAll().then((result) => {
        // all validator check kore
        if (result) {
          _this.is_loading = true;
          let api_url = "/books";
          let method = "POST";
          if (_this.is_edit) {
            api_url = "/books/" + _this.$route.params.id;
            method = "PUT";
          }


          axios({
            method: method,
            url: api_url,
            data: _this.value,
            headers: { "Content-Type": "application/json" },
          })
            .then(function (response) {
              _this.$toaster.success(response.data.message);
              _this.$router.push({ name: "bookList" });
            })
            .catch((errors) => {
              if (errors.response.status === 500) {
                _this.$toaster.error(errors.response.data.message);
              }
              _this.$setErrorsFromResponse(errors.response.data);
            })
            .finally(() => {
              _this.is_loading = false;
            });
        }
      });
    },
    getDetail: function (id) {
      return new Promise((resolve, reject) => {
        let api_url = "/books/" + id;


        axios
          .get(api_url)
          .then((response) => {
            this.value = response.data;
            this.filePath = `http://127.0.0.1:8000/uploads/${this.value.iamge}`;


            resolve(response);
          })
          .catch((error) => {
            //console.log('error ' + error)
            reject(error);
          });
      });
    },
    async initialize() {
      this.is_loading = true;
      this.params = this.$route.params;


      if (!_.isEmpty(this.params) && this.params.id !== undefined) {
        this.is_edit = true;
      }
      if (this.is_edit) {
        await this.getDetail(this.params.id)
          .then((response) => {
            this.value = response.data;
          })
          .catch((error) => {
            console.log(error.response);
          });


        this.value.iamge = "";
      }


      this.is_loading = false;
    },
  },
  mounted() {
    this.initialize();
  },
};
</script>




