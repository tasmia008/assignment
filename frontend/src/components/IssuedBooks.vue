<template>
  <div class="card">
    <h3>Issued Books</h3>
    <p>No of books issued: {{ issuedBooks }}</p>
    <button @click="issueNewBook">Issue New Book</button>
  </div>
</template>

<script>
export default {
  name: "IssuedBooks",
  props: ["issuedBooks"],
  methods: {
    issueNewBook() {
      const newIssuedBookCount = this.issuedBooks + 1;
      this.$emit("updateIssuedBooks", newIssuedBookCount); // Emit updated issued books count
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
