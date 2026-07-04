<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        $articles = Article::with('category')->get();

        return response()->json([
            'success' => true,
            'message' => 'List of articles',
            'data' => $articles
        ]);
    }

    public function store(StoreArticleRequest $request): JsonResponse
    {
        $validated = $request->validated();

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
        $article->load('category');
        
        return response()->json([
            'success' => true,
            'message' => 'Article detail',
            'data' => $article
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article): JsonResponse
    {
        $validated = $request->validated();

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