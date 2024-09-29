<template>
  <div class="dashboard">
    <header>
      <h1>Library Management System (LMS)</h1>
      <div class="admin-info">
        <span>Welcome, {{ admin.name }}</span> | 
        <span>Email: {{ admin.email }}</span>
        <router-link to="/profile">My Profile</router-link> | 
        <a @click="logout">Logout</a>
      </div>
    </header>

    <div class="dashboard-content">
      <RegisteredUsers :users="users" @updateUsers="updateUsers" />
      <AvailableBooks :books="books" @updateBooks="updateBooks" />
      <BookCategories :categories="categories" @updateCategories="updateCategories" />
      <Authors :authors="authors" @updateAuthors="updateAuthors" />
      <IssuedBooks :issuedBooks="issuedBooks" @updateIssuedBooks="updateIssuedBooks" />
    </div>
  </div>
</template>

<script>
import RegisteredUsers from '../components/RegisteredUsers.vue';
import AvailableBooks from '../components/AvailableBooks.vue';
import BookCategories from '../components/BookCategories.vue';
import Authors from '../components/Authors.vue';
import IssuedBooks from '../components/IssuedBooks.vue';

export default {
  name: 'AdminDashboard',
  components: { RegisteredUsers, AvailableBooks, BookCategories, Authors, IssuedBooks },
  data() {
    return {
      admin: {
        name: 'Admin',
        email: 'admin@gmail.com',
      },
      users: 5,           // Dynamically updated
      books: 3,           // Dynamically updated
      categories: 4,      // Dynamically updated
      authors: 4,         // Dynamically updated
      issuedBooks: 3      // Dynamically updated
    };
  },
  methods: {
    logout() {
      alert("Logged out");
    },
    updateUsers(newCount) {
      this.users = newCount;
    },
    updateBooks(newCount) {
      this.books = newCount;
    },
    updateCategories(newCount) {
      this.categories = newCount;
    },
    updateAuthors(newCount) {
      this.authors = newCount;
    },
    updateIssuedBooks(newCount) {
      this.issuedBooks = newCount;
    }
  }
};
</script>

<style>
.dashboard {
  padding: 20px;
}
.dashboard-content {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}


.card {
  margin: 15px 0;
}

.navbar-brand {
  font-weight: bold;
}

.navbar-text {
  color: white;
  margin-left: 10px;
}

.btn {
  width: 100%;
  margin-top: 10px;
}

.btn-danger {
  background-color: #dc3545;
}

.btn-success {
  background-color: #28a745;
}

.btn-warning {
  background-color: #ffc107;
}

.btn-primary {
  background-color: #007bff;
}
</style>
