<?php
class Post extends Model {
    protected string $table = 'posts';

    /**
     * Lấy bài viết kèm tên category
     */
    public function findWithCategory(int $id): ?array
    {
        $sql = "SELECT p.*, c.name_vi as category_name_vi, c.name_ja as category_name_ja, c.slug as category_slug
                FROM posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Lấy bài viết theo slug kèm category
     */
    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT p.*, c.name_vi as category_name_vi, c.name_ja as category_name_ja, c.slug as category_slug
                FROM posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.slug = :slug AND p.is_active = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Phân trang bài viết active kèm category
     */
    public function paginateActive(int $page = 1, int $perPage = 9, ?int $categoryId = null): array
    {
        $where = "WHERE p.is_active = 1";
        $params = [];

        if ($categoryId) {
            $where .= " AND p.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        $countSql = "SELECT COUNT(*) FROM posts p {$where}";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = ($page - 1) * $perPage;
        $sql = "SELECT p.*, c.name_vi as category_name_vi, c.name_ja as category_name_ja, c.slug as category_slug
                FROM posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                {$where}
                ORDER BY p.published_at DESC
                LIMIT {$perPage} OFFSET {$offset}";
        $stmt = $this->db->prepare($sql);
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
     * Lấy bài viết theo tag
     */
    public function findByTag(string $tagSlug, int $page = 1, int $perPage = 9): array
    {
        $countSql = "SELECT COUNT(*) FROM posts p
                     JOIN post_tags pt ON p.id = pt.post_id
                     JOIN tags t ON pt.tag_id = t.id
                     WHERE t.slug = :slug AND p.is_active = 1";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute(['slug' => $tagSlug]);
        $total = (int) $countStmt->fetchColumn();

        $offset = ($page - 1) * $perPage;
        $sql = "SELECT p.*, c.name_vi as category_name_vi, c.name_ja as category_name_ja, c.slug as category_slug
                FROM posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                JOIN post_tags pt ON p.id = pt.post_id
                JOIN tags t ON pt.tag_id = t.id
                WHERE t.slug = :slug AND p.is_active = 1
                ORDER BY p.published_at DESC
                LIMIT {$perPage} OFFSET {$offset}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $tagSlug]);
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
     * Lấy tags của bài viết
     */
    public function getTags(int $postId): array
    {
        $sql = "SELECT t.* FROM tags t
                JOIN post_tags pt ON t.id = pt.tag_id
                WHERE pt.post_id = :post_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll();
    }

    /**
     * Đồng bộ tags cho bài viết
     */
    public function syncTags(int $postId, array $tagIds): void
    {
        $this->db->prepare("DELETE FROM post_tags WHERE post_id = :post_id")->execute(['post_id' => $postId]);
        $stmt = $this->db->prepare("INSERT INTO post_tags (post_id, tag_id) VALUES (:post_id, :tag_id)");
        foreach ($tagIds as $tagId) {
            $stmt->execute(['post_id' => $postId, 'tag_id' => $tagId]);
        }
    }

    /**
     * Bài viết liên quan
     */
    public function getRelated(int $postId, int $categoryId, int $limit = 3): array
    {
        $sql = "SELECT p.*, c.name_vi as category_name_vi, c.name_ja as category_name_ja
                FROM posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.id != :id AND p.category_id = :cat_id AND p.is_active = 1
                ORDER BY p.published_at DESC LIMIT {$limit}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $postId, 'cat_id' => $categoryId]);
        return $stmt->fetchAll();
    }

    /**
     * Tăng lượt xem
     */
    public function incrementViews(int $postId): void
    {
        $this->db->prepare("UPDATE posts SET view_count = view_count + 1 WHERE id = :id")->execute(['id' => $postId]);
    }

    /**
     * Bài viết mới nhất
     */
    public function getLatest(int $limit = 3): array
    {
        $sql = "SELECT p.*, c.name_vi as category_name_vi, c.name_ja as category_name_ja
                FROM posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                WHERE p.is_active = 1
                ORDER BY p.published_at DESC LIMIT {$limit}";
        return $this->db->query($sql)->fetchAll();
    }
}
