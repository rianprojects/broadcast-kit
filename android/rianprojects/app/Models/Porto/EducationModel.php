<?php
// app/Models/Porto/EducationModel.php
namespace App\Models\Porto;
use CodeIgniter\Model;

class EducationModel extends Model {
    protected $table         = 'porto_education';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['institution','degree','field','period','description','order_position'];
    public function getOrdered() {
        return $this->orderBy('order_position','ASC')->findAll();
    }
}