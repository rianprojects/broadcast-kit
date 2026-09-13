<?php
// app/Models/Porto/SkillModel.php
namespace App\Models\Porto;
use CodeIgniter\Model;

class SkillModel extends Model {
    protected $table         = 'porto_skills';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['name','level','category','order_position'];
    public function getOrdered() {
        return $this->orderBy('order_position','ASC')->findAll();
    }
}