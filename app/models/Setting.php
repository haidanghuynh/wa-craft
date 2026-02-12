<?php
class Setting extends Model {
    protected string $table = 'settings';

    /**
     * Lấy setting theo key
     */
    public function get(string $key): ?array
    {
        return $this->findOneWhere(['setting_key' => $key]);
    }

    /**
     * Lấy tất cả settings theo group
     */
    public function getByGroup(string $group): array
    {
        return $this->findWhere(['group_name' => $group], 'id', 'ASC');
    }

    /**
     * Lấy tất cả settings dạng key => value
     */
    public function getAllAsMap(string $lang = 'vi'): array
    {
        $suffix = '_' . $lang;
        $all = $this->findAll('id', 'ASC');
        $map = [];
        foreach ($all as $s) {
            $map[$s['setting_key']] = $s['value' . $suffix] ?? $s['value_vi'];
        }
        return $map;
    }

    /**
     * Cập nhật hoặc tạo setting
     */
    public function set(string $key, string $valueVi, string $valueJa, string $group = 'general'): void
    {
        $existing = $this->get($key);
        if ($existing) {
            $this->update($existing['id'], [
                'value_vi' => $valueVi,
                'value_ja' => $valueJa,
            ]);
        } else {
            $this->create([
                'setting_key' => $key,
                'value_vi' => $valueVi,
                'value_ja' => $valueJa,
                'group_name' => $group,
            ]);
        }
    }
}
