<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Post extends Model {
    public $timestamps = false;
    protected $fillable = ['name'];
}