<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'tags'])->orderByDesc('created_at')->paginate(5);

        return Inertia::render('Articles/ArticleIndex', [
            'title' => 'Articles',
            'articles' => $articles,
        ]);
    }


    public function indexCreate()
    {
        $categories = Category::all(); // Получаем список всех категорий

        return Inertia::render('Articles/ArticleCreate', [
            'title' => 'Add Article',
            'categories' => $categories, // Передаем список категорий в представление
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => ['required'],
            'content' => ['required'],
            'category_id' => ['required', 'exists:categories,id'], // Убедитесь, что категория существует
        ]);

        $article = new Article($validatedData);
        $article->save();

        // Добавление тегов
        $this->attachTags($article, $request->input('tags'));

        session()->flash('message', 'Статья создана успешно!');

        return redirect()->route('articles.index');
    }

    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => ['required'],
            'content' => ['required'],
            'category_id' => ['required', 'exists:categories,id'],
            'tags' => ['nullable', 'string'], // Теги передаются строкой
        ]);

        // Обновление атрибутов статьи
        $article->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
        ]);

        // Разбиваем строку с тегами на массив
        $tags = explode(',', $validatedData['tags']);

        // Связываем теги с статьей
        $this->syncTags($article, $tags);

        session()->flash('message', 'Статья обновлена успешно!');

        return redirect()->route('articles.index');
    }


    public function indexEdit($id)
    {
        $article = Article::with('category')->find($id);
        $categories = Category::all();

        if (!$article) {
            abort(404);
        }

        return Inertia::render('Articles/ArticleEdit', [
            'title' => 'Edit Article',
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    public function destroy(Article $article)
    {
        // Удаление изображения, если оно было
        if ($article->photo_path) {
            Storage::disk('public')->delete($article->photo_path);
        }

        $article->delete();

        session()->flash('message', 'Статья удалена успешно!');

        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        return Inertia::render('Articles/ArticleShow', [
            'article' => $article,
        ]);
    }

    // Метод для добавления тегов к статье
    private function attachTags(Article $article, $tags)
    {
        if (!empty($tags)) {
            $tagNames = explode(',', $tags); // Разбиваем строку на массив по запятым
            $tagNames = array_map('trim', $tagNames); // Удаляем пробелы вокруг тегов

            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $article->tags()->attach($tag->id);
            }
        }
    }


    // Метод для обновления тегов у статьи
    private function syncTags(Article $article, $tags)
    {
        $tagIds = [];

        if (!empty($tags)) {
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
        }

        $article->tags()->sync($tagIds);
    }
}
