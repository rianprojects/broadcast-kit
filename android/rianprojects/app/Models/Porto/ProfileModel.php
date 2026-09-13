<?php
// app/Models/Porto/ProfileModel.php
namespace App\Models\Porto;
use CodeIgniter\Model;

class ProfileModel extends Model {
    protected $table         = 'porto_profile';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'hero_name','hero_tagline','hero_photo',
        'about_text',
        'contact_email','contact_phone','contact_location',
        'social_github','social_linkedin','social_instagram','social_website',
        'section_order',
    ];
    protected $useTimestamps  = true;
    protected $createdField   = '';
    protected $updatedField   = 'updated_at';

    public function get() {
        return $this->find(1);
    }
}