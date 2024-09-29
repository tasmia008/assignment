<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Library Management System (LMS)</a>
        <span class="navbar-text">Welcome: {{ userName }}</span>
        <span class="navbar-text">Email: {{ userEmail }}</span>
        <ul class="nav navbar-nav navbar-right">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">My Profile</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="view_profile.php">View Profile</a></li>
              <li><a class="dropdown-item" href="edit_profile.php">Edit Profile</a></li>
              <li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="row">
      <div class="col-md-3" style="margin: 25px">
        <div class="card bg-light" style="width: 300px">
          <div class="card-header">Book Issued</div>
          <div class="card-body">
            <p class="card-text">No of books issued: {{ issuedBookCount }}</p>
            <a class="btn btn-success" href="view_issued_book.php">View Issued Books</a>
          </div>
        </div>
      </div>
      <div class="col-md-3"></div>
      <div class="col-md-3"></div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userName: "admin", // replace with actual data (e.g., from an API)
      userEmail: "admin@gmail.com", // replace with actual data
      issuedBookCount: 0, // default value
    };
  },
  mounted() {
    this.getIssuedBookCount();
  },
  methods: {
    getIssuedBookCount() {
      // Simulate an API call
      fetch("api/issued-books-count", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          // Add authorization if needed
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.issuedBookCount = data.user_issue_book_count; // update issued book count
        })
        .catch((error) => {
          console.error("Error fetching issued book count:", error);
        });
    },
  },
};
</script>

<style scoped>
body {
  background: rgba(245, 245, 245, 0.4);
  background-image: url("https://img.freepik.com/free-photo/abundant-collection-antique-books-wooden-shelves-generated-by-ai_188544-29660.jpg?size=626&ext=jpg&ga=GA1.1.1546980028.1704240000&semt=sph");
}
</style>
