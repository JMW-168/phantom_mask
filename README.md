# Phantom Mask - Laravel RESTful API 專案

Phantom Mask 是一個基於 Laravel 開發的後端系統，提供藥局平台的 RESTful API，包括藥局營業查詢、口罩銷售、使用者購買與交易紀錄等功能。此專案支援前後端分離架構，後端部署於 `backend/` 資料夾。

---

## 🔧 技術棧

- PHP 8.2
- Laravel 10
- MySQL 8（支援 Docker 快速啟動）
- RESTful API 設計
- JSON 資料匯入（Seeder）
- 單元測試（Laravel Test）
- 可選部署：Render / Fly.io / Railway

---

## 🚀 專案啟動流程

### 📦 安裝 Laravel 專案（已於 `backend/` 建立）

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
