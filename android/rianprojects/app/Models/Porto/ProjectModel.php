<?php
// app/Models/Porto/ProjectModel.php
namespace App\Models\Porto;
use CodeIgniter\Model;

class ProjectModel extends Model {
    protected $table         = 'porto_projects';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['title','description','image','tech_stack','demo_url','github_url','order_position'];
    public function getOrdered() {
        return $this->orderBy('order_position','ASC')->findAll();
    }
}