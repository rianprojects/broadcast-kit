<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\AiPromptModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $promptModel = new AiPromptModel();
        $userModel   = new UserModel();

        $userId      = session()->get('user_id');
        $totalPrompt = $promptModel->where('user_id', $userId)->countAllResults();
        $currentUser = $userModel->find($userId);

        if (!$currentUser) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi tidak valid, silakan login kembali.');
        }

        $purchasedPrompts = $promptModel
            ->select('ai_prompts.*')
            ->join('user_prompts', 'user_prompts.prompt_id = ai_prompts.id')
            ->where('user_prompts.user_id', $userId)
            ->orderBy('user_prompts.created_at', 'DESC')
            ->findAll();

        return view('user/dashboard', [
            'title'            => 'Dashboard User',
            'user'             => $currentUser,
            'totalPrompt'      => $totalPrompt,
            'purchasedPrompts' => $purchasedPrompts,
        ]);
    }
}