<template>
  <div class="home">
    <div v-if="userRole == 1">
      <AdmindashboardView />
    </div>

      <div v-if="userRole==2">
      <UserComp/>
    </div>
  </div>
</template>

<script>
import axios from "axios";
// import AdminComp from "../components/AdminComp.vue";
// import UserComp from "../components/UserComp.vue";


export default {
  name: "HomeView",
  // components: {
  //   AdminComp,
  //   UserComp ,
  // },
  data() {
    return {
      userRole: null,
    };
  },
  mounted() {
    this.checkConnection();
    if (!localStorage.getItem("id")) {
      this.$router.push("/about");
    }

    this.userRole = localStorage.getItem("role");
  },
  methods: {
    checkConnection() {
      axios
        .get("http://127.0.0.1:8000/api/index")
        .then((res) => {
          console.log(res.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
