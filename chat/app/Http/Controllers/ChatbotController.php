<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    // Method to render the chatbot interface with categories
    public function index()
    {
        $categories = DB::table('questions')->select('Category')->distinct()->get();
        return view('chatbot', ['categories' => $categories]);
    }

    // Method to get SubCat1 options based on Category
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

    // Method to get SubCat2 options based on Category and SubCat1
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

    // Method to get Questions based on Category, SubCat1, and SubCat2
    public function getQuestions(Request $request)
    {
        $category = $request->input('category');
        $subCat1 = $request->input('subCat1');
        $subCat2 = $request->input('subCat2');
        $questions = DB::table('questions')
            ->where('Category', $category)
            ->where('SubCat1', $subCat1)
            ->where('SubCat2', $subCat2)
            ->select('Question')
            ->distinct()
            ->get();
        return response()->json(["questions" => $questions]);
    }

    // Method to get Answer based on Question
    public function getAnswer(Request $request)
    {
        $subCat2 = $request->input('subCat2');
        $subCat1 = $request->input('subCat1');
        $category = $request->input('category');
        $question = $request->input('question');

        $answer = DB::table('questions')
            ->where('Category', $category)
            ->where('SubCat1', $subCat1)
            ->where('SubCat2', $subCat2)
            ->where('Question', $question)
            ->select('Answer')
            ->first(); // Assuming each question has a unique answer
        if ($answer) {
            return response()->json(["answer" => $answer->Answer]);
        } else {
            return response()->json(["error" => "Error: No answer found for the selected question"], 404);
        }
    }
}
