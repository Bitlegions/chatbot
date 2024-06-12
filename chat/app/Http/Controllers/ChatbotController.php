<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    // Sample data representing categories and their subcategories
    public $data = [
            'cat1' => ['subcat1' => 'ans1', 'subcat2' => 'ans2'],
            'cat2' => ['subcat3' => 'ans3', 'subcat4' => 'ans4'],
            'cat3' => ['subcat5' => 'ans5', 'subcat6' => 'ans6']
        ];

    // Method to render the chatbot interface
    public function index()
    {
        return view('chatbot', ['data' => $this->data]);
    }

    // Method to get subcategories based on category
    public function getOptions(Request $request)
    {
        $category = $request->input('category');
        $options = $this->data[$category] ?? [];
        return response()->json(["options" => $options]);
    }

    // Method to get answer based on category and subcategory
    public function getAnswer(Request $request)
    {
        $category = $request->input('category');
        $subcategory = $request->input('subcategory');


        if (isset($this->data[$category])) {

            if (isset($this->data[$category][$subcategory])) {

                $answer = $this->data[$category][$subcategory];
                return response()->json(["answer" => $answer]);
            }
        }

        // If the category or subcategory doesn't exist, return a default error message
        $error = "Error: No answer found for $subcategory in $category";
        return response()->json(["error" => $error], 404);
    }

}
