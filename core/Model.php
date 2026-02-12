<?php
/**
 * Base Model - CRUD Operations via PDO
 * Model cơ sở / ベースモデル
 */

class Model
{
    protected PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Tìm theo ID / IDで検索
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Lấy tất cả / 全件取得
     */
    public function findAll(string $orderBy = 'id', string $direction = 'DESC'): array
    {
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy} {$direction}");
        return $stmt->fetchAll();
    }

    /**
     * Lấy các bản ghi active / アクティブレコード取得
     */
    public function findActive(string $orderBy = 'id', string $direction = 'ASC'): array
    {
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY {$orderBy} {$direction}");
        return $stmt->fetchAll();
    }

    /**
     * Tìm theo điều kiện / 条件検索
     */
    public function findWhere(array $conditions, string $orderBy = 'id', string $direction = 'DESC'): array
    {
        $where = [];
        $params = [];
        foreach ($conditions as $key => $value) {
            $where[] = "{$key} = :{$key}";
            $params[$key] = $value;
        }
        $whereStr = implode(' AND ', $where);
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$whereStr} ORDER BY {$orderBy} {$direction}");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Tìm 1 bản ghi theo điều kiện / 条件で1件検索
     */
    public function findOneWhere(array $conditions): ?array
    {
        $where = [];
        $params = [];
        foreach ($conditions as $key => $value) {
            $where[] = "{$key} = :{$key}";
            $params[$key] = $value;
        }
        $whereStr = implode(' AND ', $where);
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$whereStr} LIMIT 1");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tạo mới / 新規作成
     */
    public function create(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Cập nhật / 更新
     */
    public function update(int $id, array $data): bool
    {
        $set = [];
        foreach (array_keys($data) as $key) {
            $set[] = "{$key} = :{$key}";
        }
        $setStr = implode(', ', $set);
        $data[$this->primaryKey] = $id;
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$setStr} WHERE {$this->primaryKey} = :{$this->primaryKey}");
        return $stmt->execute($data);
    }

    /**
     * Xóa / 削除
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Đếm / カウント
     */
    public function count(array $conditions = []): int
    {
        if (empty($conditions)) {
            $stmt = $this->db->query("SELECT COUNT(*) FROM {$this->table}");
        } else {
            $where = [];
            $params = [];
            foreach ($conditions as $key => $value) {
                $where[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
            $whereStr = implode(' AND ', $where);
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$whereStr}");
            $stmt->execute($params);
        }
        return (int) $stmt->fetchColumn();
    }

    /**
     * Phân trang / ページネーション
     */
    public function paginate(int $page = 1, int $perPage = 10, array $conditions = [], string $orderBy = 'id', string $direction = 'DESC'): array
    {
        $offset = ($page - 1) * $perPage;
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        $where = '';
        $params = [];
        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $key => $value) {
                $whereParts[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
            $where = 'WHERE ' . implode(' AND ', $whereParts);
        }

        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} {$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} {$where} ORDER BY {$orderBy} {$direction} LIMIT {$perPage} OFFSET {$offset}");
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => (int) ceil($total / $perPage),
        ];
    }

    /**
     * Raw query / 生クエリ
     */
    public function raw(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
