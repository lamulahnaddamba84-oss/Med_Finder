<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Search_log;
class searchcontroller extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Log the search query
        Search_log::create([
            'search_query' => $query,
            'user_id' => auth()->id(),
            'is_found' => Medicine::where('name', 'like', "%$query%")->exists(),
        ]);

        // Perform the search
        $medicines = Medicine::where('name', 'like', "%$query%")->get();

        return view('search_results', compact('medicines', 'query'));
    }
}
