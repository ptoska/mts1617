<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Porosi extends Model {

    protected $fillable = ['client_id','pershkrimi','product_id','status'];
    protected $table = 'porosi';

    public static $rules = [
        'client_id' => 'required',
        'pershkrimi' => 'required',
        'product_id' => 'required',
        'status' => 'required'
    ];

    // Relationships
    public function pagese()
    {
        return $this->hasOne('App\Pagese');
    }
}
