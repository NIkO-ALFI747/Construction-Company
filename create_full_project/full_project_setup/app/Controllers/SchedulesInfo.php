<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SchedulesModel;
use App\Models\ObjectsModel;

class SchedulesInfo extends BaseController
{
    private $schedules_model;
    private $objects_model;

    public function __construct()
    {
        $this->schedules_model = new SchedulesModel();
        $this->objects_model = new ObjectsModel();
    }

    public function index()
    {
        $data = [
            'response_table' => json_encode($this->schedules_model->getSchedulesData(), JSON_UNESCAPED_UNICODE),
            'select_brigades' => json_encode($this->schedules_model->getBrigadesDataName(), JSON_UNESCAPED_UNICODE),
            'select_objects' => json_encode($this->objects_model->getObjectsDataName(), JSON_UNESCAPED_UNICODE),
            'title' => 'Информация о графиках работ на объектах',
        ];

        echo view('templates/Header', $data);
        echo view('pages/SchedulesInfo', $data);
        echo view('templates/Footer');
    }

    public function getFilter()
    {
        $postData = $this->request->getPost();
        $objectName = $postData['object_city'] ?? null;
        $brigadeName = $postData['object_type'] ?? null;

        $response = $this->schedules_model->getFilteredSchedulesData($objectName, $brigadeName);
        return $this->response->setJSON($response);
    }

    public function getFilterCost()
    {
        $postData = $this->request->getPost();

        $minCost = isset($postData['min_cost']) && is_numeric($postData['min_cost']) ? (float)$postData['min_cost'] : null;
        $maxCost = isset($postData['max_cost']) && is_numeric($postData['max_cost']) ? (float)$postData['max_cost'] : null;
        $minDate = $postData['min_date'] ?? null;
        $maxDate = $postData['max_date'] ?? null;

        $response = $this->schedules_model->getCostFilteredSchedulesData($minCost, $maxCost, $minDate, $maxDate);
        return $this->response->setJSON($response);
    }

    public function getSearch()
    {
        $postData = $this->request->getPost();
        $columnIndex = isset($postData['object_column']) ? (int)$postData['object_column'] : null;
        $searchVal = $postData['search_val'] ?? null;

        $response = $this->schedules_model->getSearchedSchedulesData($columnIndex, $searchVal);
        return $this->response->setJSON($response);
    }

    public function getSort()
    {
        $postData = $this->request->getPost();
        $columnIndex = isset($postData['object_column']) ? (int)$postData['object_column'] : null;
        $sortVal = isset($postData['sort_val']) ? (int)$postData['sort_val'] : 0;

        $response = $this->schedules_model->getSortedSchedulesData($columnIndex, $sortVal);
        return $this->response->setJSON($response);
    }

    public function reset()
    {
        $response = $this->schedules_model->getSchedulesData();
        return $this->response->setJSON($response);
    }

    public function getBrigadesDataName()
    {
        $response = $this->schedules_model->getBrigadesDataName();
        return $this->response->setJSON($response);
    }
}
