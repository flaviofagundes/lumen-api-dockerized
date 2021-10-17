<?php
//zach: definição do controller  
namespace App\Http\Controllers;
  
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
use Illuminate\Database\Eloquent\ModelNotFoundException;
  
class TagController extends Controller{

  
    public function index(){
        $tags  = Tag::all();
        return response()->json($tags);
    }
  
    public function getTag($id){
        $secao  = Tag::find($id);
        return response()->json($tag);
    }
  
    public function createTag(Request $request){
        $tag = Tag::create($request->all());
        return response()->json($tag,201);
    }
  
    public function deleteTag($id){
        $tag  = Tag::find($id);
        $tag->delete();
        return response()->json('deleted');
    }
  
    public function updateTag(Request $request,$id){
        $tag  = Tag::find($id);
        $tag->description = $request->input('description');
        $tag->editor_id = $request->input('editor_id');
        $tag->save();
        return response()->json($tag);
    }
  
}