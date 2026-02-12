<?php
/**
 * Base Controller
 * Controller cơ sở / ベースコントローラー
 */

class Controller
{
    protected string $lang = 'vi';

    public function __construct()
    {
        $this->lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? DEFAULT_LANG);
        if (!in_array($this->lang, SUPPORTED_LANGS)) {
            $this->lang = DEFAULT_LANG;
        }
        $_SESSION['lang'] = $this->lang;
    }

    /**
     * Render view / ビューレンダリング
     */
    protected function view(string $viewPath, array $data = []): void
    {
        extract($data);
        $lang = $this->lang;
        $viewFile = VIEWS_PATH . '/' . $viewPath . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View not found: {$viewPath}");
        }
    }

    /**
     * Trả về JSON / JSONレスポンス
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Redirect / リダイレクト
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Lấy suffix ngôn ngữ cho field name
     * VD: lang = 'vi' -> '_vi', lang = 'ja' -> '_ja'
     */
    protected function langSuffix(): string
    {
        return '_' . $this->lang;
    }

    /**
     * Lấy giá trị field theo ngôn ngữ từ data
     * VD: getLocalized($row, 'title') -> $row['title_vi'] hoặc $row['title_ja']
     */
    protected function getLocalized(array $data, string $field): string
    {
        $key = $field . $this->langSuffix();
        return $data[$key] ?? $data[$field . '_vi'] ?? '';
    }

    /**
     * Localize một mảng dữ liệu — chỉ giữ field theo ngôn ngữ hiện tại
     */
    protected function localizeItem(array $item): array
    {
        $result = [];
        $suffix = $this->langSuffix();
        $otherSuffix = $this->lang === 'vi' ? '_ja' : '_vi';

        foreach ($item as $key => $value) {
            // Nếu key kết thúc bằng suffix hiện tại, đổi tên bỏ suffix
            if (str_ends_with($key, $suffix)) {
                $baseKey = substr($key, 0, -strlen($suffix));
                $result[$baseKey] = $value;
            } elseif (str_ends_with($key, $otherSuffix)) {
                // Bỏ qua field ngôn ngữ khác
                continue;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Localize một danh sách
     */
    protected function localizeList(array $items): array
    {
        return array_map([$this, 'localizeItem'], $items);
    }

    /**
     * Kiểm tra request là AJAX
     */
    protected function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Lấy input POST an toàn
     */
    protected function input(string $key, $default = ''): string
    {
        return trim($_POST[$key] ?? $default);
    }

    /**
     * Upload file
     */
    protected function uploadFile(string $inputName, string $subDir = ''): ?string
    {
        if (empty($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $file = $_FILES[$inputName];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ALLOWED_EXTENSIONS)) {
            return null;
        }

        if ($file['size'] > MAX_UPLOAD_SIZE) {
            return null;
        }

        $uploadDir = UPLOAD_PATH . ($subDir ? '/' . $subDir : '');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = uniqid() . '_' . time() . '.' . $ext;
        $destination = $uploadDir . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return ($subDir ? $subDir . '/' : '') . $filename;
        }

        return null;
    }

    /**
     * Xóa file upload
     */
    protected function deleteFile(?string $path): void
    {
        if ($path) {
            $fullPath = UPLOAD_PATH . '/' . $path;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
