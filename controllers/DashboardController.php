<?php
namespace controllers;

use services\DashboardService;
use controllers\jsonResponseController;

class DashboardController{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService){
        $this->dashboardService = $dashboardService;
    }

    public function getDashboard(){
        session_start();
        $id = $_SESSION['user']['id'];
        $this->dashboardService->findById($id);
        //new jsonResponseController()->jsonResponse(['message' => 'Запрос успешно выполнен'], 200);
        return include __DIR__ . '/../views/dashboard.php';
    }
}