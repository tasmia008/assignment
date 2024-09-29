<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController ;

use App\Http\Controllers\LibraryController;

Route::get('/users', [LibraryController::class, 'getUsers']);
Route::get('/books', [LibraryController::class, 'getBooks']);
Route::get('/categories', [LibraryController::class, 'getCategories']);
Route::get('/authors', [LibraryController::class, 'getAuthors']);
Route::get('/issued-books', [LibraryController::class, 'getIssuedBooks']);

Route::post('/issue-book', [LibraryController::class, 'issueBook']);
Route::post('/add-book', [LibraryController::class, 'addBook']);
Route::post('/add-category', [LibraryController::class, 'addCategory']);
Route::post('/add-author', [LibraryController::class, 'addAuthor']);



Route::post('subadmin', [RoleController::class, 'createSubadmin']);
Route::get('index', [RoleController::class, 'index']);
Route::get('subadmins', [RoleController::class, 'subAdminInfo']); 
Route::get('users', [RoleController::class, 'allUserInfo']); 


Route::post('users', [RoleController::class, 'createUser']);


// Route::get('index', [RoleController::class, 'index']);
Route::post('login', [RoleController::class, 'login']);

Route::post('updateuser/{userId}', [RoleController::class, 'updateuserinfo']);
Route::delete('deleteuser/{userId}', [RoleController::class, 'destroy']) ;
Route::get('user/{userId}', [RoleController::class, 'getUserInfo']) ;





