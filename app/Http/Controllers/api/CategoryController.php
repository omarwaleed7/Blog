<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // trait for api response
    use ApiResponseTrait;

    // store a category
    public function store(CategoryRequest $request){
        $post=Category::create([
            'name'=>$request->name
        ]);
        return $this->apiResponse($post,'Category stored successfully',201);
    }

    // show all posts
    public function index(){
        $categories=Category::all();

        //check if posts
        if($categories){
            return $this->apiResponse($categories,'Categories retrieved successfully',200);
        }
        else{
            return $this->apiResponse(null,'Categories not found',404);
        }
    }

    // update a comment
    public function update(CategoryRequest $request,$id){

        // check if comment
        $category = Category::find($id);
        if ($category) {
            $category->update([
                'name' => $request->name,
            ]);
            $comment = Category::find($id);
            return $this->apiResponse($comment, 'Category updated successfully', 200);
        }
        else{
            return $this->apiResponse(null,'Category not found',404);
        }
    }
    // delete a post
    public function delete($id){
        $category=Category::find($id);

        // check if post
        if($category){
            $category->delete();
            return $this->apiResponse(null,'Category deleted successfully',204);
        }
        else{
            return $this->apiResponse(null,'Category not found',404);
        }
    }
}
