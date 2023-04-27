<?php
namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trashed = $request->input('trashed');
        if ($trashed) {
            $posts = Post::onlyTrashed()->get();
        } else {
            $posts = Post::all();
        }
        $num_of_trashed = Post::onlyTrashed()->count();
        return view('posts.index', compact('posts', 'num_of_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $tags = Tag::orderBy('name', 'asc')->get();

        return view('posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'category_id' => 'nullable|exists:categories,id',
        'tag_id' => 'nullable|exists:tags,id',
    ]);
    
    $post = new Post();
    $post->title = $validatedData['title'];
    $post->content = $validatedData['content'];
    $post->category_id = $validatedData['category_id'];
    $post->tag_id = $validatedData['tag_id'];
    $post->slug = $validatedData['slug'];
    
    $post->save();

    return redirect()->route('posts.show', $post->id);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $tags = Tag::orderBy('name', 'asc')->get();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validatedData = $request->validated();

        $validatedData['slug'] = Str::slug($validatedData['title']);

        $post->fill($validatedData);
        $post->save();

        return redirect()->route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->trashed()) {
            $post->forceDelete(); // eliminazione def
        } else {
            $post->delete(); //eliminazione soft
        }
        return back();
    }
}
    /**
     * Restore the specified resource from
