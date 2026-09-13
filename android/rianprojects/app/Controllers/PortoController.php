<?php

namespace App\Controllers;

use App\Models\Porto\ProfileModel;
use App\Models\Porto\SkillModel;
use App\Models\Porto\ExperienceModel;
use App\Models\Porto\ProjectModel;
use App\Models\Porto\EducationModel;

class PortoController extends BaseController
{
    public function index()
    {
        $profile = (new ProfileModel())->get();

        $data = [
            'title'       => 'Portfolio - Rian Projects',
            'profile'     => $profile,
            'skills'      => (new SkillModel())->getOrdered(),
            'experiences' => (new ExperienceModel())->getOrdered(),
            'projects'    => (new ProjectModel())->getOrdered(),
            'education'   => (new EducationModel())->getOrdered(),
            'sections'    => json_decode($profile['section_order'] ?? '[]', true),
        ];

        return view('porto/public', $data);
    }
}