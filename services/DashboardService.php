<?php
namespace services;

use repository\MySqlDashboardRepository;

class DashboardService{
    private $dashboardRepository;

    public function __construct(MySqlDashboardRepository $repository) {
        $this->dashboardRepository = $repository;
    }

    public function findById(int|string $id){
        return $this->dashboardRepository->findById($id);
    }
}