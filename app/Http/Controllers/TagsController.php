<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$tags = Tag::paginate();
		return view('tags.index', compact('tags'));
	}

    public function show(Tag $tag)
    {
        $topics = $tag->topics()->paginate();

        return view('tags.show', compact('tag','topics'));
    }

	public function create(Tag $tag)
	{
		return view('tags.create_and_edit', compact('tag'));
	}

	public function store(TagRequest $request)
	{
		$tag = Tag::create($request->all());
		return redirect()->route('tags.show', $tag->id)->with('message', 'Created successfully.');
	}

	public function edit(Tag $tag)
	{
        $this->authorize('update', $tag);
		return view('tags.create_and_edit', compact('tag'));
	}

	public function update(TagRequest $request, Tag $tag)
	{
		$this->authorize('update', $tag);
		$tag->update($request->all());

		return redirect()->route('tags.show', $tag->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Tag $tag)
	{
		$this->authorize('destroy', $tag);
		$tag->delete();

		return redirect()->route('tags.index')->with('message', 'Deleted successfully.');
	}
}