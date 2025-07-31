<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectTypesModel extends Model
{
    protected $DBGroup = 'default';
    protected $primaryKey = 'ID_type';
    protected $allowedFields = ['Name'];
    protected $table = 'types_of_objects';
    protected $useTimestamps = false;
    protected $returnType = 'array';
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        parent::__construct($this->db);
    }

    public function create($typeName)
    {
        $type = [
            'Name' => $typeName
        ];
        $this->db->table('types_of_objects')->insert($type);
        return "Информация о новом типе добавлена";
    }

    public function getObjectTypesDataWithOrder(): array
    {
        $query = $this->db->query("
            SELECT Name AS Наименование_типа
            FROM types_of_objects
            ORDER BY Name ASC
        ");
        return $this->formatResultToArray($query);
    }

    public function getObjectTypesDataWithId(): array
    {
        $query = $this->db->query("
            SELECT ID_type AS Номер_типа, Name AS Наименование_типа
            FROM types_of_objects
            ORDER BY ID_type ASC
        ");
        return $this->formatResultToArray($query);
    }

    public function getObjectTypesData(): array
    {
        $query = $this->db->table('types_of_objects')->select('Name')->get();
        return $this->formatResultToArray($query, false);
    }

    public function getObjectCitiesData(): array
    {
        $query = $this->db->table('objects')->select('City')->get();
        return $this->formatResultToArray($query, false);
    }

    public function deleteObjectType($deleteId): string
    {
        $this->db->query("DELETE FROM types_of_objects WHERE ID_type = ?", [$deleteId]);
        return "Информация о типе удалена";
    }

    public function editObjectType($editId, $typeName): string
    {
        $this->db->query(
            "UPDATE types_of_objects SET Name = ? WHERE ID_type = ?",
            [$typeName, $editId]
        );
        return "Информация о типе объекта с номером $editId успешно изменена";
    }

    public function getSearchedObjectTypesData(?int $columnIndex = null, ?string $searchValue = null): array
    {
        $columnMap = [
            0 => 'types_of_objects.Name',
            1 => 'objects.Name',
            2 => 'City',
            3 => 'Street',
        ];

        $column = $columnMap[$columnIndex] ?? null;

        $builder = $this->db->table('types_of_objects')
            ->select("Name AS Наименование_типа");

        if ($column && $searchValue) {
            $builder->like($column, $searchValue, 'after');
        }

        $builder->orderBy('Name', 'ASC');

        $query = $builder->get();
        return $this->formatResultToArray($query);
    }

    public function getSortedObjectTypesData(?int $columnIndex = null, ?int $sortDirection = null): array
    {
        $columnMap = [
            0 => 'Name',
        ];

        $directionMap = [
            0 => 'ASC',
            1 => 'DESC',
        ];

        $column = $columnMap[$columnIndex] ?? 'Name';
        $direction = $directionMap[$sortDirection] ?? 'ASC';

        $builder = $this->db->table('types_of_objects')
            ->select("Name AS Наименование_типа")
            ->orderBy($column, $direction);

        $query = $builder->get();
        return $this->formatResultToArray($query);
    }

    public function formatResultToArray($query, bool $withHeaders = true): array
    {
        $resultArr = [];

        if ($withHeaders) {
            $headers = $query->getFieldNames();
            $resultArr[] = $headers;
        }

        foreach ($query->getResultArray() as $row) {
            $resultArr[] = array_values($row);
        }

        return $resultArr;
    }
}
