<template>
  <div class="card">
    <h3>Total Books</h3>
    <p>No of books available: {{ books }}</p>
    <button @click="addBook">Add New Book</button>
  </div>
</template>

<script>
export default {
  name: "AvailableBooks",
  props: ["books"],
  methods: {
    addBook() {
      const newBookCount = this.books + 1;
      this.$emit("updateBooks", newBookCount); // Emit updated book count
    }
  }
};
</script>

<style scoped>
.card {
  width: 30%;
  padding: 15px;
  border: 1px solid #ddd;
}
</style>
