# 成果展示文件

> 本內容為 Phantom Mask 專案的最終成果展示。

## A. 必填資訊

### A.1. 功能完成度

- [v] **查詢特定時間與星期幾有營業的藥局清單**  
  - 已實作於 `/api/pharmacies/open`

- [v] **查詢指定藥局販售的口罩清單，可依口罩名稱或價格排序**  
  - 已實作於 `/api/pharmacies/{id}/masks`

- [v] **查詢販售口罩數量多於或少於 x 的藥局，並支援價格範圍過濾**  
  - 已實作於 `/api/pharmacies/filter`

- [v] **查詢特定日期區間內口罩交易總金額前 x 名使用者**  
  - 已實作於 `/api/users/top`

- [v] **查詢特定日期區間內口罩交易總數量與總金額**  
  - 已實作於 `/api/transactions/summary`

- [v] **支援模糊搜尋藥局名稱或口罩名稱，依關聯性排序**  
  - 已實作於 `/api/search?q=xxx`

- [v] **使用者購買藥局的口罩，並以 Laravel Transaction 確保資料一致性**  
  - 已實作於 `/api/purchase`

## A.2. API 文件

請參考以下連結以了解完整 API 文件：

👉 [API 文件連結](https://github.com/JMW-168/phantom_mask/blob/main/API%20Spec.md)

> 文件內容包含：
> - 各 API 功能說明
> - 請求與回應格式
> - 範例參數與回傳資料


### A.3. 匯入資料指令

請執行下列 Laravel 指令匯入資料：

```bash
php artisan migrate:fresh --seed
```

或依照資料格式個別執行：

```bash
php artisan db:seed --class=PharmacySeeder
php artisan db:seed --class=UserSeeder
```

---

## B. Bonus 額外資訊

### B.1. 測試覆蓋率報告（Test Coverage Report）

已撰寫各 API 的單元測試，並成功產出 coverage report。  
使用 Laravel 的 `phpunit` 指令，並以 HTML 格式輸出測試覆蓋率報告至 `/coverage` 目錄。

執行指令如下：

```bash
vendor/bin/phpunit --coverage-html coverage
```
報告已產出，可於專案根目錄下的 coverage/index.html 開啟查看。

### B.2. Docker 化

請參考 `backend/Dockerfile` 與 `docker-compose.yml`。
本機啟動流程如下：

```bash
docker-compose up --build -d
```

並進入容器執行遷移與資料種子：

```bash
docker exec -it laravel_app bash
php artisan migrate --seed
```

### B.3. Demo 線上網址

Fly.io 上線網址：

🔗 https://phantom-mask-cool-tree-6683.fly.dev/api/pharmacies/open?day=Tue&time=14:00

---


