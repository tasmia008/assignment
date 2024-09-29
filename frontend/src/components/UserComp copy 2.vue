
<template>
  <div>
    <h1>
      <h2>Welcome to User Dashboard</h2>
      <div v-if="user">
        <p>Name: {{ user.username }}</p>
        <p>Status: {{ user.status }}</p>
      </div>
      <p v-if="error">{{ error }}</p>
    </h1>
    <button @click="logout">Logout</button>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: null,
      error: null
    };
  },
  mounted() {
    this.fetchUserInfo();
  },
  methods: {
    async fetchUserInfo() {
      try {
        const userId = localStorage.getItem('id');

        if (!userId) {
          this.error = "User ID not found. Please log in again.";
          return;
        }

        const response = await axios.get(`http://127.0.0.1:8000/api/user/${userId}`);
        console.log(response);
        this.user = response.data.user;
      } catch (err) {
        this.error = err.response ? err.response.data.message : err.message;
      }
    },
    logout() {
      localStorage.removeItem('id');
      localStorage.removeItem('role');
      this.$router.push('/about');
    }
  }
};
</script>

<style scoped>
</style>
