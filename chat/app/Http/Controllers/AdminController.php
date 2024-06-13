<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $categories = DB::table('questions')->select('Category')->distinct()->get();
        $questions = DB::table('questions')->get();
        return view('admin.index', compact('categories', 'questions'));
    }

    public function filter(Request $request)
    {
        $query = DB::table('questions');

        if ($request->category) {
            $query->where('Category', $request->category);
        }

        if ($request->subCat1) {
            $query->where('SubCat1', $request->subCat1);
        }

        if ($request->subCat2) {
            $query->where('SubCat2', $request->subCat2);
        }

        $questions = $query->get();

        return response()->json(['questions' => $questions]);
    }

    public function store(Request $request)
    {
        DB::table('questions')->insert([
            'Category' => $request->category,
            'SubCat1' => $request->subCat1,
            'SubCat2' => $request->subCat2,
            'Question' => $request->question,
            'Answer' => $request->answer
        ]);

        return response()->json(['message' => 'Question added successfully']);
    }

    public function update(Request $request, $id)
    {
        DB::table('questions')->where('id', $id)->update([
            'Category' => $request->category,
            'SubCat1' => $request->subCat1,
            'SubCat2' => $request->subCat2,
            'Question' => $request->question,
            'Answer' => $request->answer
        ]);

        return response()->json(['message' => 'Question updated successfully']);
    }

    public function destroy($id)
    {
        DB::table('questions')->where('id', $id)->delete();

        return response()->json(['message' => 'Question deleted successfully']);
    }

    public function show($id)
    {
        $question = DB::table('questions')->where('id', $id)->first();

        return response()->json($question);
    }

    public function getSubCat1Options(Request $request)
    {
        $category = $request->input('category');
        $subCat1Options = DB::table('questions')
            ->where('Category', $category)
            ->select('SubCat1')
            ->distinct()
            ->get();

        return response()->json(["options" => $subCat1Options]);
    }

    public function getSubCat2Options(Request $request)
    {
        $category = $request->input('category');
        $subCat1 = $request->input('subCat1');
        $subCat2Options = DB::table('questions')
            ->where('Category', $category)
            ->where('SubCat1', $subCat1)
            ->select('SubCat2')
            ->distinct()
            ->get();

        return response()->json(["options" => $subCat2Options]);
    }
}
