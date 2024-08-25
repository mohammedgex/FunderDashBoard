<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    // all terms
    public function index()
    {
        $terms = Terms::get();

        return view('Terms.terms', ["terms" => $terms]);
    }

    // all terms
    public function terms()
    {
        $terms = Terms::get();

        return response()->json([
            'success' => true,
            'terms' => $terms
        ]);
    }


    public function create()
    {
        return view('Terms.create-term');
    }
    // add terms 
    public function addTerm(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $term_old = Terms::where('title', $request->title)->first();

        if (!empty($term_old)) {
            return redirect()->route('term.create')->with('error', 'the term already exists');
        }

        $term = new Terms();
        $term->title = $request->title;
        $term->description = $request->description;
        $term->save();

        return redirect()->route('term.index');
    }

    public function show($id)
    {
        $term = Terms::find($id);
        return view('Terms.edit-term', ['term' => $term]);
    }
    // update terms 
    public function updateTerm(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $term_old = Terms::where('title', $request->title)->first();

        if (!empty($term_old)) {
            return redirect()->route('term.show', $id)->with('error', 'the term already exists');
        }

        $term = Terms::find($id);
        if (!$term) {
            return response()->json([
                'error' => 'term not found',
            ], 400);
        }
        $term->title = $request->title;
        $term->description = $request->description;
        $term->save();

        return redirect()->route('term.index');
    }

    // delete term
    public function delete($id)
    {
        $term = Terms::find($id);
        if (!$term) {
            return response()->json([
                'error' => 'term not found',
            ], 400);
        }

        $term->delete();
        return redirect()->route('term.index');
    }
}
