<template>
  <div class="card">
    <h3>Authors</h3>
    <p>No of Authors: {{ authors }}</p>
    <button @click="addAuthor">Add New Author</button>
  </div>
</template>

<script>
export default {
  name: "Authors",
  props: ["authors"],
  methods: {
    addAuthor() {
      const newAuthorCount = this.authors + 1;
      this.$emit("updateAuthors", newAuthorCount); // Emit updated author count
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
