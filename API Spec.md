# Phantom Mask API 文件

後端 RESTful API 文件，適用於前端或第三方串接。

---

## 📦 Base URL

```
http://localhost:8000/api
```

---

## 1️⃣ 查詢營業中的藥局

### GET `/pharmacies/open`

查詢在指定時間與星期幾有營業的藥局。

#### ✅ Query Parameters
| 參數 | 說明 | 範例 |
|------|------|------|
| `day` | 星期（3碼） | `Mon`, `Fri` |
| `time` | 時間（HH:MM） | `10:00` |

#### 🔄 範例請求
```
GET /pharmacies/open?day=Mon&time=10:00
```

#### 🔁 回傳格式
```json
[
  {
    "id": 1,
    "name": "DFW Wellness",
    "cash_balance": 328.41
  }
]
```

---

## 2️⃣ 查詢藥局販售的口罩

### GET `/pharmacies/{id}/masks`

查詢指定藥局販售的所有口罩，支援排序。

#### ✅ Query Parameters
| 參數 | 說明 | 範例 |
|------|------|------|
| `sort` | 排序依據 | `name`, `price` |

#### 🔄 範例請求
```
GET /pharmacies/1/masks?sort=price
```

#### 🔁 回傳格式
```json
{
  "pharmacy": "DFW Wellness",
  "masks": [
    {
      "id": 3,
      "name": "Second Smile (black) (3 per pack)",
      "price": 5.84
    }
  ]
}
```

---

## 3️⃣ 依口罩數量篩藥局（價格範圍內）

### GET `/pharmacies/filter`

查詢在價格區間內，口罩數量 > 或 < 某值的藥局。

#### ✅ Query Parameters
| 參數 | 說明 |
|------|------|
| `min` | 最低價格（預設 0） |
| `max` | 最高價格（預設 999999） |
| `more_than` | 口罩數量多於 |
| `less_than` | 口罩數量少於 |

#### 🔄 範例請求
```
GET /pharmacies/filter?min=10&max=50&more_than=3
```

---

## 4️⃣ 查詢交易金額前 X 名的使用者

### GET `/users/top`

#### ✅ Query Parameters
| 參數 | 說明 |
|------|------|
| `limit` | 前幾名（預設 10） |
| `start` | 起始時間（YYYY-MM-DD） |
| `end` | 結束時間（YYYY-MM-DD） |

#### 🔄 範例請求
```
GET /users/top?limit=5&start=2021-01-01&end=2021-01-31
```

---

## 5️⃣ 查詢總交易資訊

### GET `/transactions/summary`

取得口罩總交易數量與金額，可加時間區間。

#### ✅ Query Parameters
| 參數 | 說明 |
|------|------|
| `start` | 起始時間（選填） |
| `end` | 結束時間（選填） |

#### 🔄 範例請求
```
GET /transactions/summary?start=2021-01-01&end=2021-01-31
```

---

## 6️⃣ 搜尋藥局 / 口罩名稱（模糊）

### GET `/search`

#### ✅ Query Parameters
| 參數 | 說明 |
|------|------|
| `q` | 搜尋字串 |

#### 🔄 範例請求
```
GET /search?q=mask
```

#### 🔁 回傳格式
```json
{
  "pharmacies": [
    { "id": 1, "name": "DFW Wellness" }
  ],
  "masks": [
    {
      "id": 5,
      "name": "Masquerade (green) (3 per pack)",
      "price": 9.4,
      "pharmacy": {
        "id": 1,
        "name": "DFW Wellness"
      }
    }
  ]
}
```

---

## 7️⃣ 處理購買交易（User Buy）

### POST `/purchase`

用戶購買某藥局販售的口罩。交易須完全成功（atomic）。

#### 📥 Request Body（JSON）
```json
{
  "user_id": 1,
  "pharmacy_id": 1,
  "mask_id": 3,
  "quantity": 2
}
```

#### 🔁 回傳格式
```json
{
  "message": "Purchase completed successfully.",
  "new_mask_price": 16.5,
  "user_cash_balance": 150.00
}
```

#### ⚠️ 錯誤範例
```json
{
  "message": "Purchase failed: User does not have enough cash."
}
```

---

📘 文件結束｜v1.0
