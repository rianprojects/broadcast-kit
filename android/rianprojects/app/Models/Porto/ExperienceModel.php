<?php
// app/Models/Porto/ExperienceModel.php
namespace App\Models\Porto;
use CodeIgniter\Model;

class ExperienceModel extends Model {
    protected $table         = 'porto_experiences';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['company','role','period','description','order_position'];
    public function getOrdered() {
        return $this->orderBy('order_position','ASC')->findAll();
    }
}