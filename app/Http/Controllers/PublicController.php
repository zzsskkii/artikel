<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category', 'reporter')->orderBy('id', 'desc');
        
        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%')
                  ->orWhere('isi', 'like', '%' . $request->q . '%');
        }
        
        $articles = $query->paginate(6)->withQueryString();
        $categories = Category::all();
        $popularArticles = Article::with('category')->orderBy('views', 'desc')->take(5)->get();
        return view('public.home', compact('articles', 'categories', 'popularArticles'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $articles = Article::with('category', 'reporter')->where('kategori_id', $id)->orderBy('id', 'desc')->paginate(6);
        $categories = Category::all();
        $popularArticles = Article::with('category')->orderBy('views', 'desc')->take(5)->get();
        
        return view('public.category', compact('category', 'articles', 'categories', 'popularArticles'));
    }

    public function article($id)
    {
        $article = Article::with('category', 'reporter')->findOrFail($id);
        $article->increment('views'); // Tambah view count
        
        $categories = Category::all();
        
        return view('public.article', compact('article', 'categories'));
    }
}
