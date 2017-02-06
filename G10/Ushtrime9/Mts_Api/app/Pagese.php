<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagese extends Model {

    protected $fillable = ['porosi_id','transaction_id','vlera'];
    protected $table = 'pagese';

    public static $rules = [
        'porosi_id' => 'required',
        'transaction_id' => 'required',
        'vlera' => 'required'
    ];

    // Relationships

}
