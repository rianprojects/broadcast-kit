<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\PostModel;
use App\Models\AiPromptModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $incomeQuery = $db->table('transactions')
                          ->selectSum('amount')
                          ->whereIn('status', ['approved', 'success'])
                          ->get()->getRow();
        $totalIncome = $incomeQuery->amount ?? 0;

        $wdQuery = $db->table('withdrawals')
                      ->selectSum('amount', 'gross')
                      ->selectSum('net_amount', 'net')
                      ->selectSum('transfer_fee', 'fee_flat')
                      ->selectSum('platform_fee', 'fee_percent')
                      ->where('status', 'completed')
                      ->get()->getRow();

        $totalWdNet      = $wdQuery->net ?? 0; 
        $totalFeeFlat    = $wdQuery->fee_flat ?? 0;
        $totalFeePercent = $wdQuery->fee_percent ?? 0; 
        $platformProfit  = $totalFeeFlat + $totalFeePercent;
        $builder = $db->table('visitor_logs'); 

        $filter = $this->request->getGet('filter') ?? 'daily';

        if ($filter == 'yearly') {
            $query = $builder->select("YEAR(created_at) as label, COUNT(*) as total")
                             ->groupBy("YEAR(created_at)")
                             ->orderBy("label", "ASC")
                             ->limit(5)
                             ->get();
        } elseif ($filter == 'monthly') {
            $query = $builder->select("MONTHNAME(created_at) as label, COUNT(*) as total")
                             ->where("YEAR(created_at)", date('Y'))
                             ->groupBy("MONTH(created_at)")
                             ->orderBy("MONTH(created_at)", "ASC")
                             ->get();
        } else {
            $query = $builder->select("DATE_FORMAT(created_at, '%d %b') as label, COUNT(*) as total")
                             ->groupBy("DATE(created_at)")
                             ->orderBy("created_at", "ASC")
                             ->limit(30)
                             ->get();
        }
        $chartData = $query->getResultArray();

        $osStats = $db->table('visitor_logs')
                      ->select('os, COUNT(*) as count')
                      ->groupBy('os')
                      ->orderBy('count', 'DESC')
                      ->limit(5)
                      ->get()
                      ->getResultArray();

        $recentVisits = $db->table('visitor_logs')
                           ->select('ip_address, os, browser,url_visited, created_at')
                           ->orderBy('created_at', 'DESC')
                           ->limit(10)
                           ->get()
                           ->getResultArray();


        $projectModel = new ProjectModel();
        $postModel    = new PostModel();
        $promptModel  = new AiPromptModel();

        $data = [
            'title'           => 'Dashboard Overview',
            'filter'          => $filter,
            'total_income'    => $totalIncome,
            'total_wd_net'    => $totalWdNet,
            'platform_profit' => $platformProfit,
            'fee_flat'        => $totalFeeFlat,
            'fee_percent'     => $totalFeePercent,
            'total_project'   => $projectModel->countAllResults(),
            'total_post'      => $postModel->countAllResults(),
            'total_prompt'    => $promptModel->countAllResults(),
            'total_visit'     => $db->table('visitor_logs')->countAllResults(),
            'chart_labels'    => json_encode(array_column($chartData, 'label')),
            'chart_values'    => json_encode(array_column($chartData, 'total')),
            'os_stats'        => $osStats,
            'recent_visits'   => $recentVisits
        ];

        return view('admin/dashboard', $data);
    }
}