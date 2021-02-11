<?php namespace App\Models;

use CodeIgniter\Model;

class avionesModelo extends Model {

    protected $table = 'aviones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'nombre','codigo','idvuelo'];

}