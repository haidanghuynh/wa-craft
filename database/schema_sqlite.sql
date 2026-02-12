-- ============================================================
-- Company SPA - SQLite Database Schema
-- Schema tương thích SQLite / SQLite互換スキーマ
-- ============================================================

-- Users (Admin)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT (datetime('now','localtime'))
);

-- Pages (Static: About, Contact)
CREATE TABLE IF NOT EXISTS pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    slug TEXT NOT NULL UNIQUE,
    title_vi TEXT NOT NULL DEFAULT '',
    title_ja TEXT NOT NULL DEFAULT '',
    content_vi TEXT,
    content_ja TEXT,
    meta_description_vi TEXT DEFAULT '',
    meta_description_ja TEXT DEFAULT '',
    meta_keywords_vi TEXT DEFAULT '',
    meta_keywords_ja TEXT DEFAULT '',
    og_image TEXT DEFAULT '',
    is_active INTEGER DEFAULT 1,
    updated_at DATETIME DEFAULT (datetime('now','localtime'))
);

-- Services
CREATE TABLE IF NOT EXISTS services (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    icon TEXT DEFAULT 'fas fa-cog',
    title_vi TEXT NOT NULL DEFAULT '',
    title_ja TEXT NOT NULL DEFAULT '',
    description_vi TEXT,
    description_ja TEXT,
    detail_vi TEXT,
    detail_ja TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT (datetime('now','localtime'))
);

-- Blog Categories
CREATE TABLE IF NOT EXISTS blog_categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    slug TEXT NOT NULL UNIQUE,
    name_vi TEXT NOT NULL DEFAULT '',
    name_ja TEXT NOT NULL DEFAULT '',
    description_vi TEXT,
    description_ja TEXT,
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- Posts (Blog)
CREATE TABLE IF NOT EXISTS posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    slug TEXT NOT NULL UNIQUE,
    category_id INTEGER DEFAULT NULL,
    title_vi TEXT NOT NULL DEFAULT '',
    title_ja TEXT NOT NULL DEFAULT '',
    summary_vi TEXT,
    summary_ja TEXT,
    content_vi TEXT,
    content_ja TEXT,
    thumbnail TEXT DEFAULT '',
    meta_description_vi TEXT DEFAULT '',
    meta_description_ja TEXT DEFAULT '',
    meta_keywords_vi TEXT DEFAULT '',
    meta_keywords_ja TEXT DEFAULT '',
    og_image TEXT DEFAULT '',
    published_at DATE DEFAULT NULL,
    view_count INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT (datetime('now','localtime')),
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
);

-- Tags
CREATE TABLE IF NOT EXISTS tags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    slug TEXT NOT NULL UNIQUE,
    name_vi TEXT NOT NULL DEFAULT '',
    name_ja TEXT NOT NULL DEFAULT ''
);

-- Post-Tag Pivot
CREATE TABLE IF NOT EXISTS post_tags (
    post_id INTEGER NOT NULL,
    tag_id INTEGER NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- Team Members
CREATE TABLE IF NOT EXISTS team_members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name_vi TEXT NOT NULL DEFAULT '',
    name_ja TEXT NOT NULL DEFAULT '',
    position_vi TEXT DEFAULT '',
    position_ja TEXT DEFAULT '',
    bio_vi TEXT,
    bio_ja TEXT,
    photo TEXT DEFAULT '',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- Sliders
CREATE TABLE IF NOT EXISTS sliders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    image TEXT DEFAULT '',
    title_vi TEXT DEFAULT '',
    title_ja TEXT DEFAULT '',
    subtitle_vi TEXT DEFAULT '',
    subtitle_ja TEXT DEFAULT '',
    link TEXT DEFAULT '',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- Settings
CREATE TABLE IF NOT EXISTS settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    setting_key TEXT NOT NULL UNIQUE,
    value_vi TEXT,
    value_ja TEXT,
    group_name TEXT DEFAULT 'general'
);

-- Contact Messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    subject TEXT DEFAULT '',
    message TEXT NOT NULL,
    is_read INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT (datetime('now','localtime'))
);
