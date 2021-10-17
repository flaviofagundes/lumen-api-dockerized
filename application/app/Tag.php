<?php namespace App;
use Illuminate\Database\Eloquent\Model;
  
class Tag extends Model
{
    protected $primaryKey = 'tag_id';

    protected $fillable = ['tag_id', 'description', 'editor_id'];

    protected $table = 'tag';

    public $timestamps = false;     
     
}
?>