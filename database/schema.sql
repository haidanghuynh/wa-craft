-- ============================================================
-- Company SPA - Database Schema
-- Tạo database và tables / データベース作成
-- ============================================================

CREATE DATABASE IF NOT EXISTS company_spa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE company_spa;

-- Users (Admin)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Pages (Static: About, Contact)
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    title_vi VARCHAR(255) NOT NULL DEFAULT '',
    title_ja VARCHAR(255) NOT NULL DEFAULT '',
    content_vi TEXT,
    content_ja TEXT,
    meta_description_vi VARCHAR(255) DEFAULT '',
    meta_description_ja VARCHAR(255) DEFAULT '',
    meta_keywords_vi VARCHAR(255) DEFAULT '',
    meta_keywords_ja VARCHAR(255) DEFAULT '',
    og_image VARCHAR(255) DEFAULT '',
    is_active TINYINT(1) DEFAULT 1,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Services
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(50) DEFAULT 'fas fa-cog',
    title_vi VARCHAR(255) NOT NULL DEFAULT '',
    title_ja VARCHAR(255) NOT NULL DEFAULT '',
    description_vi TEXT,
    description_ja TEXT,
    detail_vi TEXT,
    detail_ja TEXT,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Blog Categories
CREATE TABLE IF NOT EXISTS blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    name_vi VARCHAR(255) NOT NULL DEFAULT '',
    name_ja VARCHAR(255) NOT NULL DEFAULT '',
    description_vi TEXT,
    description_ja TEXT,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

-- Posts (Blog)
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category_id INT DEFAULT NULL,
    title_vi VARCHAR(255) NOT NULL DEFAULT '',
    title_ja VARCHAR(255) NOT NULL DEFAULT '',
    summary_vi TEXT,
    summary_ja TEXT,
    content_vi LONGTEXT,
    content_ja LONGTEXT,
    thumbnail VARCHAR(255) DEFAULT '',
    meta_description_vi VARCHAR(255) DEFAULT '',
    meta_description_ja VARCHAR(255) DEFAULT '',
    meta_keywords_vi VARCHAR(255) DEFAULT '',
    meta_keywords_ja VARCHAR(255) DEFAULT '',
    og_image VARCHAR(255) DEFAULT '',
    published_at DATE DEFAULT NULL,
    view_count INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tags
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    name_vi VARCHAR(100) NOT NULL DEFAULT '',
    name_ja VARCHAR(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB;

-- Post-Tag Pivot
CREATE TABLE IF NOT EXISTS post_tags (
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Team Members
CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_vi VARCHAR(100) NOT NULL DEFAULT '',
    name_ja VARCHAR(100) NOT NULL DEFAULT '',
    position_vi VARCHAR(100) DEFAULT '',
    position_ja VARCHAR(100) DEFAULT '',
    bio_vi TEXT,
    bio_ja TEXT,
    photo VARCHAR(255) DEFAULT '',
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

-- Sliders
CREATE TABLE IF NOT EXISTS sliders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) DEFAULT '',
    title_vi VARCHAR(255) DEFAULT '',
    title_ja VARCHAR(255) DEFAULT '',
    subtitle_vi VARCHAR(255) DEFAULT '',
    subtitle_ja VARCHAR(255) DEFAULT '',
    link VARCHAR(255) DEFAULT '',
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;

-- Settings
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    value_vi TEXT,
    value_ja TEXT,
    group_name VARCHAR(50) DEFAULT 'general'
) ENGINE=InnoDB;

-- Contact Messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) DEFAULT '',
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
