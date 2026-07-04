<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        $articles = Article::with('category', 'reporter')->orderBy('id', 'desc')->get();

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
            'kategori_id' => 'required|integer',
            'isi' => 'required|string',
            'foto' => 'nullable|image',
        ]);

        // Auto-assign reporter from the logged-in user
        $validated['reporter_id'] = Auth::id() ?? 1;

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
        $validated = $request->validate([
            'judul' => 'required|string',
            'kategori_id' => 'required|integer',
            'isi' => 'required|string',
            'foto' => 'nullable|image',
        ]);

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