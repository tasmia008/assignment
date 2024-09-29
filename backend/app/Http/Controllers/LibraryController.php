<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\IssuedBook;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function getUsers()
    {
        return response()->json(User::all(), 200);
    }

    public function getBooks()
    {
        return response()->json(Book::with('author', 'category')->where('available', true)->get(), 200);
    }

    public function getCategories()
    {
        return response()->json(Category::with('books')->get(), 200);
    }

    public function getAuthors()
    {
        return response()->json(Author::with('books')->get(), 200);
    }

    public function getIssuedBooks()
    {
        return response()->json(IssuedBook::with('user', 'book')->get(), 200);
    }

    public function issueBook(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'issue_date' => 'required|date',
        ]);

        $book = Book::find($request->book_id);
        if (!$book->available) {
            return response()->json(['message' => 'Book is not available'], 400);
        }

        $issuedBook = IssuedBook::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'issue_date' => $request->issue_date,
        ]);

        $book->update(['available' => false]);

        return response()->json($issuedBook, 201);
    }

    public function addBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
        ]);

        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    public function addCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function addAuthor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::create($validated);
        return response()->json($author, 201);
    }
}
