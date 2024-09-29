<template>
  <div class="card">
    <h3>Book Categories</h3>
    <p>No of Book’s Categories: {{ categories }}</p>
    <button @click="addCategory">Add New Category</button>
  </div>
</template>

<script>
export default {
  name: "BookCategories",
  props: ["categories"],
  methods: {
    addCategory() {
      const newCategoryCount = this.categories + 1;
      this.$emit("updateCategories", newCategoryCount); // Emit updated categories count
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
