<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        // Fetch the news, ordered by date_published descending
        $news = News::orderBy('date_published', 'desc')->orderBy('created_at', 'desc')->with('user')->get();

        // Optionally, set a success or error message in session
        if (session('status')) {
            $status = session('status');
        } else {
            $status = null;
        }

        // Return the view with news and user info, passing session status
        return view('dashboard', [
            'news' => $news,
            'userName' => auth()->user()->name,
            'status' => $status,
        ]);
    }
    public function welcome()
    {
        // Fetch the news, ordered by date_published descending
        $news = News::orderBy('date_published', 'desc')->orderBy('created_at', 'desc')->get();

        // Return the view with news and user info, passing session status
        return view('welcome', compact('news'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'headline' => 'required|min:10',
            'content' => 'required|min:100',
            'author' => 'required|string|max:255',
            'date_published' => 'required|date',
        ]);

        try {
            // Create and store the new news item
            News::create([
                'headline' => $request->headline,
                'content' => $request->content,
                'author' => $request->author,
                'date_published' => $request->date_published,
                'user_id' => auth()->id(),
            ]);

            // Redirect to the dashboard with a success message
            return redirect()->route('dashboard')->with('status', 'success')->with('message', 'News post created successfully.');
        } catch (\Exception $e) {
            // Redirect to the dashboard with an error message
            return redirect()->route('dashboard')->with('status', 'error')->with('message', 'Failed to create news post. Please try again.');
        }
    }


    public function create()
    {
        return view('news.create'); // Create a view for creating a new news post
    }


    public function edit($id)
    {
        // Fetch the news item by ID
        $news = News::findOrFail($id);

        // Pass the news item to the edit view
        return view('news.edit', compact('news'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'headline' => 'required|min:10',
            'content' => 'required|min:100',
            'author' => 'required|string|max:255',
            'date_published' => 'required|date',
        ]);

        try {
            // Find the news item by ID and update it
            $news = News::findOrFail($id);
            $news->update([
                'headline' => $request->headline,
                'content' => $request->content,
                'author' => $request->author,
                'date_published' => $request->date_published,
            ]);


            // Redirect with success message
            return redirect()->route('dashboard')->with('status', 'success')->with('message', 'News post updated successfully.');
        } catch (\Exception $e) {
            // Redirect with error message
            return redirect()->route('dashboard')->with('status', 'error')->with('message', 'Failed to update news post. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            // Find the news item by ID and delete it
            $news = News::findOrFail($id);
            $news->delete();

            // Redirect to the dashboard with a success message
            return redirect()->route('dashboard')->with('status', 'success')->with('message', 'News post deleted successfully.');
        } catch (\Exception $e) {
            // Redirect to the dashboard with an error message
            return redirect()->route('dashboard')->with('status', 'error')->with('message', 'Failed to delete news post. Please try again.');
        }
    }

    public function search(Request $request)
    {
        // Initialize query builder
        $query = News::query();

        // Apply filters if present
        if ($request->has('headline') && !empty($request->headline)) {
            $query->where('headline', 'like', '%' . $request->headline . '%');
        }

        if ($request->has('author') && !empty($request->author)) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        if ($request->has('date_published') && !empty($request->date_published)) {
            $query->whereDate('date_published', $request->date_published);
        }

        // Get the results
        $news = $query->orderBy('date_published', 'desc')->orderBy('created_at', 'desc')->get();


        // Return view with results
        return view('welcome', compact('news'));
    }
}
