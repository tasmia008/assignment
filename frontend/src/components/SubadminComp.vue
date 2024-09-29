<template>
  <div class="dashboard-container">
    <!-- Header Section -->
    <header class="dashboard-header">
      <h2>Sub-Admin Dashboard</h2>
      <button class="btn btn-logout" @click="logout">Logout</button>
    </header>

    <!-- User Creation Section -->
    <section class="form-section">
      <h3>Create a New User</h3>
      <form @submit.prevent="createUser" class="form">
        <div class="form-group">
          <label for="username">Username</label>
          <input
            type="text"
            id="username"
            v-model="user.username"
            class="input-field"
            required
          />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            v-model="user.password"
            class="input-field"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
      </form>

      <!-- Feedback Messages -->
      <div v-if="error" class="error-message">{{ error }}</div>
      <div v-if="successMessage" class="success-message">
        {{ successMessage }}
      </div>
    </section>

    <!-- User Information Table -->
    <section class="user-info-section">
      <h3>User Information</h3>
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.username }}</td>
            <td>
              <button class="btn btn-edit" @click="editUser(user.id)">
                Edit
              </button>
              <button class="btn btn-delete" @click="deleteUser(user.id)">
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      user: {
        username: "",
        password: "",
      },
      users: [],
      error: null,
      successMessage: "",
    };
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/users");
        this.users = response.data.users;
      } catch (err) {
        this.error = err.response ? err.response.data.message : err.message;
      }
    },
    async createUser() {
      try {
        await axios.post("http://127.0.0.1:8000/api/users", this.user);
        this.successMessage = "User created successfully";
        this.error = null;
        // Clear the form
        this.user.username = "";
        this.user.password = "";
        // Refresh the user list
        this.fetchUsers();
      } catch (err) {
        this.error = err.response ? err.response.data.message : err.message;
        this.successMessage = "";
      }
    },
    logout() {
      localStorage.removeItem("id");
      localStorage.removeItem("role");
      this.$router.push("/about");
    },
    editUser(userId) {
      const user = this.users.find((user) => user.id === userId);
      if (user) {
        this.user.username = user.username;
        this.user.password = ""; // Password is not accessible, so it's left blank
      }
    },
    async deleteUser(userId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/users/${userId}`);
        this.successMessage = "User deleted successfully";
        this.fetchUsers(); // Refresh the user list
      } catch (err) {
        this.error = err.response ? err.response.data.message : err.message;
        this.successMessage = "";
      }
    },
  },
};
</script>

<style scoped>
/* General Layout */
.dashboard-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 30px;
  background-color: #f5f7fa;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Header Section */
.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #2d3748;
  border-radius: 12px;
  color: #fff;
  margin-bottom: 40px;
}

.dashboard-header h2 {
  font-size: 24px;
  font-weight: bold;
}

.btn-logout {
  background-color: #e53e3e;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
}

.btn-logout:hover {
  background-color: #c53030;
}

/* Form Section */
.form-section {
  background-color: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  margin-bottom: 40px;
}

.form h3 {
  font-size: 20px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.input-field {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.error-message {
  color: #e53e3e;
  margin-top: 10px;
}

.success-message {
  color: #38a169;
  margin-top: 10px;
}

/* Button Styles */
.btn {
  padding: 10px 20px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  font-size: 14px;
}

.btn-primary {
  background-color: #4299e1;
  color: #fff;
}

.btn-edit {
  background-color: #48bb78;
  color: #fff;
}

.btn-delete {
  background-color: #e53e3e;
  color: #fff;
}

.btn:hover {
  opacity: 0.9;
}

/* Table Styles */
.styled-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.styled-table th,
.styled-table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #e2e8f0;
}

.styled-table th {
  background-color: #2d3748;
  color: #fff;
}

.styled-table td {
  background-color: #f7fafc;
}

.styled-table tbody tr:hover {
  background-color: #edf2f7;
}
</style>
