<?php

namespace App\Http\Controllers\Web\Backend\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('backend.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagepath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagepath = time() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imagepath);
        }

        Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $imagepath
        ]);

        return redirect()->route('post.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('backend.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        ]);



        $post = Post::findOrFail($id);

        // Default image path
        $imagepath = $post->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if (!$image->isValid()) {
                return redirect()->back()->with('error', 'Uploaded image is not valid.');
            }

            // Delete old image if exists
            if ($post->image && file_exists(public_path('images/' . $post->image))) {
                unlink(public_path('images/' . $post->image));
            }

            // Save new file
            $imagepath = time() . '.' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imagepath);
        }

        $post->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $imagepath
        ]);

        return redirect()->route('post.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        // ✅ Delete image file if exists
        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            unlink(public_path('images/' . $post->image));
        }

        // ✅ Delete post from database
        $post->delete();

        return redirect()->route('post.index')->with('success', 'Post deleted successfully.');
    }
}
