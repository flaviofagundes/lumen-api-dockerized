<?php
namespace App\Http\Controllers;
  
use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Log;
  
class PostController extends Controller{

  
    public function index(Request $request){

        //objeto de retorno
        $posts = null;
        $filters = [];

        //processa as variáveis de query params
        $avaliableFilters = ['title'   => 'like',
                             'content' => 'like',
                             'status'  => '=',
                             'editor_id' => '=' ];

        $filters = $this->processQueryParams($avaliableFilters, $request);

        if (empty($filters)){
            $posts  = Post::all();
        }else{

            for($i=0; $i < count($filters); $i++){
                if ($i == 0){
                    $posts = Post::where($filters[$i][0], $filters[$i][1], $filters[$i][2]);
                }else{
                    $posts->where($filters[$i][0], $filters[$i][1], $filters[$i][2]);
                }
            }

           $posts = $posts->get();

        }

        return response()->json($posts);
    }
  
    public function get($id){
        $post  = Post::find($id);
        return response()->json($post);
    }
  
    public function create(Request $request){
        $post = Post::create($request->all());
        return response()->json($post,201);
    }
  
    public function delete($id){
        $post  = Post::find($id);
        $post->delete();
        return response()->json('deleted');
    }
  
    public function update(Request $request,$id){
        $post  = Post::find($id);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->status = $request->input('status');
        $post->created_date = $request->input('created_date');
        $post->published_date = $request->input('published_date');
        $post->removed_date = $request->input('removed_date');
        $post->editor_id = $request->input('editor_id');
        $post->save();
        return response()->json($post);
    }
  
}