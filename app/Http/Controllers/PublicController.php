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
        
        $articles = $query->get();
        $categories = Category::all();
        return view('public.home', compact('articles', 'categories'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $articles = Article::with('category', 'reporter')->where('kategori_id', $id)->orderBy('id', 'desc')->get();
        $categories = Category::all();
        
        return view('public.category', compact('category', 'articles', 'categories'));
    }

    public function article($id)
    {
        $article = Article::with('category', 'reporter')->findOrFail($id);
        $categories = Category::all();
        
        return view('public.article', compact('article', 'categories'));
    }
}
