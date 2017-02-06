<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Klient extends Model {

    protected $fillable = ['emri','mbiemri','email','password'];
    protected $table = 'client';

    public static $rules = [
        'emri' => 'required',
        'mbiemri' => 'required',
        'email' => 'required|email|unique:client',
        'password' => 'required'
    ];

    // Relationships
    public function porosi()
    {
        return $this->hasMany('App\Porosi');
    }
}
