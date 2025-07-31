<?php

namespace App\Models;

use CodeIgniter\Model;

class SchedulesModel extends Model
{
    protected $table = 'work_schedules';
    protected $primaryKey = 'Serial_number';
    protected $allowedFields = [
        'ID_object',
        'ID_brigade',
        'Description_of_works',
        'From1',
        'To1',
        'Cost',
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $DBGroup = 'default';
    protected $db;
    private $object_types_model;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        parent::__construct($this->db);
        $this->object_types_model = new ObjectTypesModel();
    }

    public function getBrigadeIdByName(string $name): ?int
    {
        $query = $this->db->table('brigades')
            ->select('ID_brigade')
            ->where('Name', $name)
            ->get()
            ->getRowArray();
        return $query['ID_brigade'] ?? null;
    }

    public function getObjectIdByName(string $name): ?int
    {
        $query = $this->db->table('objects')
            ->select('ID_object')
            ->where('Name', $name)
            ->get()
            ->getRowArray();
        return $query['ID_object'] ?? null;
    }

    public function getBrigadesDataName(): array
    {
        $query = $this->db->table('brigades')->select('Name')->get();
        return $this->object_types_model->formatResultToArray($query, false);
    }

    public function create(array $objectData): bool
    {
        return $this->insert($objectData);
    }

    public function getSchedulesDataWithId(): array
    {
        $builder = $this->db->table('work_schedules')
            ->select('work_schedules.Serial_number AS Номер_графика, 
                brigades.Name AS Название_бригады, 
                objects.Name AS Название_объекта, 
                work_schedules.Description_of_works AS Описание_работ, 
                work_schedules.From1 AS Дата_начала, 
                work_schedules.To1 AS Дата_окончания, 
                work_schedules.Cost AS Стоимость')
            ->join('objects', 'objects.ID_object = work_schedules.ID_object')
            ->join('brigades', 'brigades.ID_brigade = work_schedules.ID_brigade')
            ->orderBy('work_schedules.Serial_number', 'ASC');
        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function deleteSchedule(int $deleteId): bool
    {
        return $this->delete($deleteId);
    }

    public function editSchedule(
        int $editId,
        int $brigadeId,
        int $objectId,
        string $description,
        string $from,
        string $to,
        float $cost
    ): bool {
        $data = [
            'ID_brigade'           => $brigadeId,
            'ID_object'            => $objectId,
            'Description_of_works' => $description,
            'From1'                => $from,
            'To1'                  => $to,
            'Cost'                 => $cost,
        ];

        return $this->update($editId, $data);
    }

    public function getSchedulesData(): array
    {
        $builder = $this->db->table('work_schedules')
            ->select([
                'brigades.Name AS Наименование_бригады',
                'objects.Name AS Название_объекта',
                'description_of_works AS Описание_работ',
                'From1 AS Дата_начала_работ',
                'To1 AS Дата_окончания_работ',
                'Cost AS Стоимость_работ'
            ])
            ->join('objects', 'objects.ID_object = work_schedules.ID_object')
            ->join('brigades', 'brigades.ID_brigade = work_schedules.ID_brigade')
            ->orderBy('brigades.Name', 'ASC');
        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getFilteredSchedulesData(?string $objectName, ?string $brigadeName): array
    {
        $builder = $this->db->table('work_schedules')
            ->select('brigades.Name AS Наименование_бригады, objects.Name AS Название_объекта, description_of_works AS Описание_работ, 
                      From1 AS Дата_начала_работ, To1 AS Дата_окончания_работ, Cost AS Стоимость_работ')
            ->join('objects', 'objects.ID_object = work_schedules.ID_object')
            ->join('brigades', 'brigades.ID_brigade = work_schedules.ID_brigade');

        if ($brigadeName) {
            $builder->where('brigades.Name', $brigadeName);
        }

        if ($objectName) {
            $builder->where('objects.Name', $objectName);
        }

        $builder->orderBy('brigades.Name', 'ASC');

        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getCostFilteredSchedulesData(?float $minCost, ?float $maxCost, ?string $minDate, ?string $maxDate): array
    {
        $builder = $this->db->table('work_schedules')
            ->select('brigades.Name AS Наименование_бригады, objects.Name AS Название_объекта, description_of_works AS Описание_работ, 
                      From1 AS Дата_начала_работ, To1 AS Дата_окончания_работ, Cost AS Стоимость_работ')
            ->join('objects', 'objects.ID_object = work_schedules.ID_object')
            ->join('brigades', 'brigades.ID_brigade = work_schedules.ID_brigade');

        if ($minCost !== null) {
            $builder->where('Cost >=', $minCost);
        }

        if ($maxCost !== null) {
            $builder->where('Cost <=', $maxCost);
        }

        if ($minDate) {
            $builder->where('From1 >=', $minDate);
        }

        if ($maxDate) {
            $builder->where('To1 <=', $maxDate);
        }

        $builder->orderBy('brigades.Name', 'ASC');

        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getSearchedSchedulesData(?int $columnIndex, ?string $searchVal): array
    {
        $columns = [
            0 => 'brigades.Name',
            1 => 'objects.Name',
            2 => 'description_of_works',
            3 => 'From1',
            4 => 'To1',
            5 => 'Cost',
        ];

        $column = $columns[$columnIndex] ?? null;

        $builder = $this->db->table('work_schedules')
            ->select('brigades.Name AS Наименование_бригады, objects.Name AS Название_объекта, description_of_works AS Описание_работ, 
                      From1 AS Дата_начала_работ, To1 AS Дата_окончания_работ, Cost AS Стоимость_работ')
            ->join('objects', 'objects.ID_object = work_schedules.ID_object')
            ->join('brigades', 'brigades.ID_brigade = work_schedules.ID_brigade');

        if ($column && $searchVal !== null) {
            $builder->like($column, $searchVal, 'after');
        }

        $builder->orderBy('brigades.Name', 'ASC');
        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }

    public function getSortedSchedulesData(?int $columnIndex = null, ?int $sortDirection = null): array
    {
        $columnMap = [
            0 => 'brigades.Name',
            1 => 'objects.Name',
            2 => 'description_of_works',
            3 => 'From1',
            4 => 'To1',
            5 => 'Cost',
        ];

        $directionMap = [
            0 => 'ASC',
            1 => 'DESC',
        ];

        $column = $columnMap[$columnIndex] ?? 'brigades.Name';
        $direction = $directionMap[$sortDirection] ?? 'ASC';

        $builder = $this->db->table('work_schedules')
            ->select([
                'brigades.Name AS Наименование_бригады',
                'objects.Name AS Название_объекта',
                'description_of_works AS Описание_работ',
                'From1 AS Дата_начала_работ',
                'To1 AS Дата_окончания_работ',
                'Cost AS Стоимость_работ'
            ])
            ->join('objects', 'objects.ID_object = work_schedules.ID_object')
            ->join('brigades', 'brigades.ID_brigade = work_schedules.ID_brigade')
            ->orderBy($column, $direction);

        $query = $builder->get();
        return $this->object_types_model->formatResultToArray($query);
    }
}
