<template>
  <div>
    <h2>Admin Profile</h2>
    <form @submit.prevent="updateProfile">
      <label for="name">Name:</label>
      <input v-model="admin.name" type="text" id="name" />

      <label for="email">Email:</label>
      <input v-model="admin.email" type="email" id="email" />

      <button type="submit">Update Profile</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "AdminProfile",
  data() {
    return {
      admin: {
        name: "Admin",
        email: "admin@gmail.com",
      },
    };
  },
  methods: {
    updateProfile() {
      alert("Profile Updated!");
    },
  },
};
</script>

<style scoped>
form {
  margin: 20px 0;
}
input {
  display: block;
  margin-bottom: 10px;
}
button {
  padding: 10px;
}
</style>
