<?php
// app/Controllers/Admin/Porto.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Porto\ProfileModel;
use App\Models\Porto\SkillModel;
use App\Models\Porto\ExperienceModel;
use App\Models\Porto\ProjectModel;
use App\Models\Porto\EducationModel;

class Porto extends BaseController
{
    protected $profile;
    protected $skills;
    protected $experiences;
    protected $projects;
    protected $education;

    public function __construct()
    {
        $this->profile     = new ProfileModel();
        $this->skills      = new SkillModel();
        $this->experiences = new ExperienceModel();
        $this->projects    = new ProjectModel();
        $this->education   = new EducationModel();
    }

    private function _processWebp($file, $folder)
    {
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getClientExtension());
            $newName = $file->getRandomName();
            if ($ext === 'webp' || $ext === 'svg') {
                $file->move(FCPATH . $folder, $newName);
                return $folder . '/' . $newName;
            }

            $targetName = pathinfo($newName, PATHINFO_FILENAME) . '.webp';
            $targetPath = FCPATH . $folder . '/' . $targetName;
            
            $info = getimagesize($file->getTempName());
            if ($info['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($file->getTempName());
            } elseif ($info['mime'] == 'image/png') {
                $image = imagecreatefrompng($file->getTempName());
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            } elseif ($info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($file->getTempName());
            } else {

                $file->move(FCPATH . $folder, $newName);
                return $folder . '/' . $newName; 
            }

            imagewebp($image, $targetPath, 80);
            imagedestroy($image);
            
            return $folder . '/' . $targetName;
        }
        return null;
    }


    public function admin()
    {
        $profile = $this->profile->get();
        $data = [
            'title'       => 'Porto Builder',
            'profile'     => $profile,
            'skills'      => $this->skills->getOrdered(),
            'experiences' => $this->experiences->getOrdered(),
            'projects'    => $this->projects->getOrdered(),
            'education'   => $this->education->getOrdered(),
            'sections'    => json_decode($profile['section_order'] ?? '[]', true),
        ];
        return view('admin/porto/index', $data);
    }


    public function saveProfile()
    {
        $data = [
            'hero_name'        => $this->request->getPost('hero_name'),
            'hero_tagline'     => $this->request->getPost('hero_tagline'),
            'about_text'       => $this->request->getPost('about_text'),
            'contact_email'    => $this->request->getPost('contact_email'),
            'contact_phone'    => $this->request->getPost('contact_phone'),
            'contact_location' => $this->request->getPost('contact_location'),
            'social_github'    => $this->request->getPost('social_github'),
            'social_linkedin'  => $this->request->getPost('social_linkedin'),
            'social_instagram' => $this->request->getPost('social_instagram'),
            'social_website'   => $this->request->getPost('social_website'),
        ];


        $photo = $this->request->getFile('hero_photo');
        if ($photo && $photo->isValid()) {
            $old = $this->profile->get();
            if ($old['hero_photo'] && file_exists(FCPATH . $old['hero_photo'])) {
                unlink(FCPATH . $old['hero_photo']);
            }
            $data['hero_photo'] = $this->_processWebp($photo, 'uploads/porto');
        }

        $this->profile->update(1, $data);
        return redirect()->to('/admin/porto')->with('success', 'Profile berhasil disimpan!');
    }


    public function reorderSections()
    {
        $order = $this->request->getJSON(true);
        $this->profile->update(1, ['section_order' => json_encode($order)]);
        return $this->response->setJSON(['status' => 'ok']);
    }


    public function bulkDelete($type)
    {
        $ids = $this->request->getPost('ids');
        if (empty($ids) || !is_array($ids)) {
            return redirect()->to('/admin/porto')->with('error', 'Tidak ada item yang dipilih.');
        }

        if ($type === 'skill') $this->skills->delete($ids);
        if ($type === 'experience') $this->experiences->delete($ids);
        if ($type === 'education') $this->education->delete($ids);
        if ($type === 'project') {
            foreach($ids as $id) {
                $p = $this->projects->find($id);
                if ($p && $p['image'] && file_exists(FCPATH . $p['image'])) {
                    unlink(FCPATH . $p['image']);
                }
            }
            $this->projects->delete($ids);
        }

        return redirect()->to("/admin/porto#section-{$type}s")->with('success', count($ids) . ' item berhasil dihapus massal!');
    }


    public function saveSkill()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'name'     => $this->request->getPost('name'),
            'level'    => $this->request->getPost('level'),
            'category' => $this->request->getPost('category'),
        ];
        if ($id) {
            $this->skills->update($id, $data);
        } else {
            $last = $this->skills->selectMax('order_position')->first();
            $data['order_position'] = ($last['order_position'] ?? 0) + 1;
            $this->skills->insert($data);
        }
        return redirect()->to('/admin/porto#section-skills')->with('success', 'Skill berhasil disimpan!');
    }

    public function deleteSkill($id)
    {
        $this->skills->delete($id);
        return redirect()->to('/admin/porto#section-skills')->with('success', 'Skill dihapus!');
    }

    public function reorderSkills()
    {
        foreach ($this->request->getJSON(true) as $item) {
            $this->skills->update($item['id'], ['order_position' => $item['position']]);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }


    public function saveExperience()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'company'     => $this->request->getPost('company'),
            'role'        => $this->request->getPost('role'),
            'period'      => $this->request->getPost('period'),
            'description' => $this->request->getPost('description'),
        ];
        if ($id) {
            $this->experiences->update($id, $data);
        } else {
            $last = $this->experiences->selectMax('order_position')->first();
            $data['order_position'] = ($last['order_position'] ?? 0) + 1;
            $this->experiences->insert($data);
        }
        return redirect()->to('/admin/porto#section-experience')->with('success', 'Experience berhasil disimpan!');
    }

    public function deleteExperience($id)
    {
        $this->experiences->delete($id);
        return redirect()->to('/admin/porto#section-experience')->with('success', 'Experience dihapus!');
    }

    public function reorderExperiences()
    {
        foreach ($this->request->getJSON(true) as $item) {
            $this->experiences->update($item['id'], ['order_position' => $item['position']]);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }


    public function saveProject()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'tech_stack'  => $this->request->getPost('tech_stack'),
            'demo_url'    => $this->request->getPost('demo_url'),
            'github_url'  => $this->request->getPost('github_url'),
        ];


        $img = $this->request->getFile('image');
        if ($img && $img->isValid()) {
            if ($id) {
                $old = $this->projects->find($id);
                if ($old['image'] && file_exists(FCPATH . $old['image'])) unlink(FCPATH . $old['image']);
            }
            $data['image'] = $this->_processWebp($img, 'uploads/porto/projects');
        }

        if ($id) {
            $this->projects->update($id, $data);
        } else {
            $last = $this->projects->selectMax('order_position')->first();
            $data['order_position'] = ($last['order_position'] ?? 0) + 1;
            $this->projects->insert($data);
        }
        return redirect()->to('/admin/porto#section-projects')->with('success', 'Project berhasil disimpan!');
    }

    public function deleteProject($id)
    {
        $p = $this->projects->find($id);
        if ($p['image'] && file_exists(FCPATH . $p['image'])) unlink(FCPATH . $p['image']);
        $this->projects->delete($id);
        return redirect()->to('/admin/porto#section-projects')->with('success', 'Project dihapus!');
    }

    public function reorderProjects()
    {
        foreach ($this->request->getJSON(true) as $item) {
            $this->projects->update($item['id'], ['order_position' => $item['position']]);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }


    public function saveEducation()
    {
        $id   = $this->request->getPost('id');
        $data = [
            'institution' => $this->request->getPost('institution'),
            'degree'      => $this->request->getPost('degree'),
            'field'       => $this->request->getPost('field'),
            'period'      => $this->request->getPost('period'),
            'description' => $this->request->getPost('description'),
        ];
        if ($id) {
            $this->education->update($id, $data);
        } else {
            $last = $this->education->selectMax('order_position')->first();
            $data['order_position'] = ($last['order_position'] ?? 0) + 1;
            $this->education->insert($data);
        }
        return redirect()->to('/admin/porto#section-education')->with('success', 'Education berhasil disimpan!');
    }

    public function deleteEducation($id)
    {
        $this->education->delete($id);
        return redirect()->to('/admin/porto#section-education')->with('success', 'Education dihapus!');
    }

    public function reorderEducation()
    {
        foreach ($this->request->getJSON(true) as $item) {
            $this->education->update($item['id'], ['order_position' => $item['position']]);
        }
        return $this->response->setJSON(['status' => 'ok']);
    }

    public function getItem($type, $id)
    {
        $map = [
            'skill'      => $this->skills,
            'experience' => $this->experiences,
            'project'    => $this->projects,
            'education'  => $this->education,
        ];
        return $this->response->setJSON($map[$type]?->find($id));
    }
}