<template>
  <div class="card">
    <h3>Registered Users</h3>
    <p>No. of total Users: {{ users }}</p>
    <button @click="increaseUsers">Add New User</button>
  </div>
</template>

<script>
export default {
  name: "RegisteredUsers",
  props: ["users"],
  methods: {
    increaseUsers() {
      const newUserCount = this.users + 1;
      this.$emit("updateUsers", newUserCount); // Emitting updated user count to parent
    },
  },
};
</script>

<style scoped>
.card {
  width: 30%;
  padding: 15px;
  border: 1px solid #ddd;
}
</style>
