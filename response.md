# Phantom Mask API 文件

Phantom Mask 是一個以 Laravel 建構的 RESTful API 專案，用於模擬使用者向藥局購買口罩，並能查詢藥局口罩資訊、交易紀錄與排行。

---

## 🚀 快速啟動 Phantom Mask 專案（Docker 版）

### ✅ 環境需求

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

### 📦 一鍵啟動

在專案根目錄執行：

```bash
docker-compose up --build
```

這將會啟動以下服務：

| 服務 | 說明 | Port |
|------|------|------|
| Laravel API | 後端主服務 | `http://localhost:8000` |
| MySQL | 資料庫服務 | `localhost:3306` |
| PhpMyAdmin | MySQL 網頁管理介面 | `http://localhost:8081` |

---

### 🗃️ PhpMyAdmin 登入資訊

- Host: `db`
- 使用者：`laravel`
- 密碼：`secret`

---

### 🔄 重設資料庫（選用）

如果你要重建資料表並重新匯入 Seeder：

```bash
docker exec -it laravel_app php artisan migrate:fresh --seed
```

---

### 🔍 測試 API 是否正常

開啟 Postman 或瀏覽器測試：

```http
GET http://localhost:8000/api/pharmacies/open?day=Mon&time=10:00
```

應該會看到 JSON 回應代表服務啟動成功 ✅

---

## 📘 API 文件

> 若需詳細 API 參數與範例，請參考 [docs/api-spec.md](docs/api-spec.md)

收錄功能包含：

- 查詢營業中的藥局
- 查詢藥局販售口罩（可排序）
- 查詢藥局口罩數量條件 + 價格範圍
- Top 使用者交易金額排行
- 總交易金額與購買口罩數量統計
- 搜尋口罩或藥局名稱（模糊）
- 處理口罩購買（atomic transaction）

---

專案開發與部署中，如有任何問題歡迎提 issue 👋
