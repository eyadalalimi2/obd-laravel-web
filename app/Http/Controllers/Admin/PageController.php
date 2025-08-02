<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'slug'    => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'nullable|string',
            'status'  => 'required|in:published,draft',
        ]);

        $slug = $request->slug ?: Str::slug($request->title);

        Page::create([
            'title'   => $request->title,
            'slug'    => $slug,
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'تم إنشاء الصفحة بنجاح.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'slug'    => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'status'  => 'required|in:published,draft',
        ]);

        $page->update([
            'title'   => $request->title,
            'slug'    => $request->slug ?: Str::slug($request->title),
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'تم تحديث الصفحة بنجاح.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'تم حذف الصفحة بنجاح.');
    }
}
