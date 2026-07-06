<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $query = Article::with('category', 'reporter')->orderBy('id', 'desc');
        
        if ($user && $user->role !== 'admin') {
            $query->where('reporter_id', $user->id);
        }

        $articles = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'List of articles',
            'data' => $articles
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'kategori_nama' => 'required|string',
            'posisi' => 'nullable|string',
            'isi' => 'required|string',
            'foto' => 'nullable|image',
        ]);

        // Auto-assign reporter from the logged-in user
        $validated['reporter_id'] = Auth::id() ?? 1;

        // Find or create category
        $category = Category::firstOrCreate(['name_categori' => $validated['kategori_nama']]);
        $validated['kategori_id'] = $category->id;
        unset($validated['kategori_nama']);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('articles', 'public');
        }

        $article = Article::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Article created successfully',
            'data' => $article
        ], 201);
    }

    public function show(Article $article): JsonResponse
    {
        $article->load('category', 'reporter');
        
        return response()->json([
            'success' => true,
            'message' => 'Article detail',
            'data' => $article
        ]);
    }

    public function update(Request $request, Article $article): JsonResponse
    {
        $user = Auth::user();
        if ($user && $user->role !== 'admin' && $article->reporter_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'judul' => 'required|string',
            'kategori_nama' => 'required|string',
            'posisi' => 'nullable|string',
            'isi' => 'required|string',
            'foto' => 'nullable|image',
        ]);

        $category = Category::firstOrCreate(['name_categori' => $validated['kategori_nama']]);
        $validated['kategori_id'] = $category->id;
        unset($validated['kategori_nama']);

        if ($request->hasFile('foto')) {
            if ($article->foto && Storage::disk('public')->exists($article->foto)) {
                Storage::disk('public')->delete($article->foto);
            }
            
            $validated['foto'] = $request->file('foto')->store('articles', 'public');
        }

        $article->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Article updated successfully',
            'data' => $article
        ]);
    }

    public function destroy(Article $article): JsonResponse
    {
        $user = Auth::user();
        if ($user && $user->role !== 'admin' && $article->reporter_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($article->foto && Storage::disk('public')->exists($article->foto)) {
            Storage::disk('public')->delete($article->foto);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully'
        ]);
    }
}