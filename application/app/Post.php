<?php namespace App;
use Illuminate\Database\Eloquent\Model;
  
class Post extends Model
{
    protected $primaryKey = 'post_id';

    protected $fillable = ['post_id', 'title', 'content','created_date','published_date','removed_date','editor_id'];

    protected $table = 'post';

    public $timestamps = false;     
    
}
?>