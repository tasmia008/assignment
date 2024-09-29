<template>
  <div class="dashboard-container">
    <h2 class="dashboard-heading">Welcome To Admin Dashboard</h2>

    <div class="section">
      <h2 class="section-heading">User Information</h2>
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.username }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="section">
      <h2 class="section-heading">User Information</h2>
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Status</th>
            <th>State</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.status }}</td>
            <td>
              <select v-model="user.state" class="styled-select">
                <option value="pending">Pending</option>
                <option value="accepted">Accept</option>
                <option value="reject">Reject</option>
              </select>
            </td>
            <td>
              <button
                type="button"
                class="btn btn-primary"
                @click="updateUser(user.id)"
              >
                Update
              </button>
              <button
                type="button"
                class="btn btn-danger"
                @click="deleteUser(user.id)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      subadmins: [],
      users: [],
      subadmin: {
        username: "",
        password: "",
      },
      error: null,
      successMessage: "",
    };
  },
  mounted() {
    // this.fetchSubadminInfo();
    this.fetchUserInfo();
  },
  methods: {
    // async fetchSubadminInfo() {
    //   try {
    //     const response = await axios.get("http://127.0.0.1:8000/api/users");
    //     this.subadmins = response.data.subadmins;
    //   } catch (err) {
    //     this.error = err.response ? err.response.data.message : err.message;
    //   }
    // },
    async fetchUserInfo() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/users");
        this.users = response.data.users;
      } catch (err) {
        this.error = err.response ? err.response.data.message : err.message;
      }
    },
    // async createSubadmin() {
    //   try {
    //     await axios.post("http://127.0.0.1:8000/api/subadmin", this.subadmin);
    //     this.successMessage = "Sub Admin created successfully";
    //     this.error = null;
    //     // Clear the form
    //     this.subadmin.username = "";
    //     this.subadmin.password = "";
    //     // Refresh the list of subadmins
    //     this.fetchSubadminInfo();
    //   } catch (err) {
    //     this.error = err.response ? err.response.data.message : err.message;
    //     this.successMessage = "";
    //   }
    // },
    async updateUser(userId) {
      try {
        const user = this.users.find((u) => u.id === userId);
        await axios.post(`http://127.0.0.1:8000/api/updateuser/${userId}`, {
          status: user.state,
        });
        this.successMessage = "User updated successfully";
        this.error = null;
        // refresh user
        this.fetchUserInfo();
      } catch (err) {
        this.error = err.response ? err.response.data.message : err.message;
        this.successMessage = "";
      }
    },

    async deleteUser(userId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/deleteuser/${userId}`);
        this.successMessage = "User deleted successfully";
        this.error = null;
        // Refresh the user list
        this.fetchUserInfo();
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
  },
};
</script>

<style>
/* General Styles */
.dashboard-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 12px;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.dashboard-heading {
  text-align: center;
  font-size: 32px;
  color: #333;
  margin-bottom: 30px;
}

.section {
  margin-bottom: 40px;
}

.section-heading {
  font-size: 24px;
  color: #555;
  margin-bottom: 15px;
}

/* Table Styles */
.styled-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.styled-table th,
.styled-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.styled-table thead tr {
  background-color: #4285f4;
  color: #ffffff;
  text-align: left;
}

.styled-table tbody tr {
  background-color: #f3f3f3;
  border-bottom: 1px solid #ddd;
}

.styled-table tbody tr:hover {
  background-color: #f1f1f1;
}

/* Button Styles */
.btn {
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 14px;
  cursor: pointer;
}

.btn-primary {
  background-color: #4285f4;
  color: white;
  border: none;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #357ae8;
}

.btn-danger {
  background-color: #ff4d4d;
  color: white;
  border: none;
  transition: background-color 0.3s ease;
}

.btn-danger:hover {
  background-color: #e60000;
}

/* Select Styles */
.styled-select {
  padding: 8px;
  border-radius: 8px;
  border: 1px solid #ddd;
  font-size: 14px;
  color: #333;
}

.styled-select:focus {
  border-color: #4285f4;
  outline: none;
}
</style>
