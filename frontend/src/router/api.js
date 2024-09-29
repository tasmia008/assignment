import axios from 'axios';

const API_BASE_URL = 'http://your-laravel-api-url/api'; // Change this to your Laravel backend URL

const api = {
  // ********** User Management ********** //
  getUsers() {
    return axios.get(`${API_BASE_URL}/users`);
  },
  getUserInfo(userId) {
    return axios.get(`${API_BASE_URL}/user/${userId}`);
  },
  createUser(userData) {
    return axios.post(`${API_BASE_URL}/users`, userData);
  },
  updateUser(userId, updatedData) {
    return axios.post(`${API_BASE_URL}/updateuser/${userId}`, updatedData);
  },
  deleteUser(userId) {
    return axios.delete(`${API_BASE_URL}/deleteuser/${userId}`);
  },
  login(credentials) {
    return axios.post(`${API_BASE_URL}/login`, credentials);
  },

  // ********** Sub-Admin Management ********** //
  getSubAdmins() {
    return axios.get(`${API_BASE_URL}/subadmins`);
  },
  createSubAdmin(subAdminData) {
    return axios.post(`${API_BASE_URL}/subadmin`, subAdminData);
  },

  // ********** Books Management ********** //
  getBooks() {
    return axios.get(`${API_BASE_URL}/books`);
  },
  addBook(bookData) {
    return axios.post(`${API_BASE_URL}/add-book`, bookData);
  },

  // ********** Categories Management ********** //
  getCategories() {
    return axios.get(`${API_BASE_URL}/categories`);
  },
  addCategory(categoryData) {
    return axios.post(`${API_BASE_URL}/add-category`, categoryData);
  },

  // ********** Authors Management ********** //
  getAuthors() {
    return axios.get(`${API_BASE_URL}/authors`);
  },
  addAuthor(authorData) {
    return axios.post(`${API_BASE_URL}/add-author`, authorData);
  },

  // ********** Issued Books Management ********** //
  getIssuedBooks() {
    return axios.get(`${API_BASE_URL}/issued-books`);
  },
  issueBook(issueData) {
    return axios.post(`${API_BASE_URL}/issue-book`, issueData);
  }
};

export default api;
