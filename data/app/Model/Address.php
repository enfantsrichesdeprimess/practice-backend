<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Address extends Model {
    public $timestamps = false;
    protected $table = 'address';
    protected $fillable = ['town', 'home', 'home_number', 'flat'];
}
