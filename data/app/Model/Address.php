<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Address extends Model {
    public $timestamps = false;
    protected $fillable = ['town', 'home', 'home_number', 'flat'];
}