<<<<<<< HEAD
=======
<<<<<<< HEAD
# finance-bot
Personal finance management bot
=======

## 🧩 Database Diagram

![Database Diagram](docs/finance-bot-db.png)
>>>>>>> 20aa862 (Resolve merge conflict in README.md)


---

# 💰 Shaxsiy Moliyani Boshqarish Telegram Boti

Shaxsiy daromad va xarajatlarni nazorat qilish, balansni kuzatish, statistika olish hamda ma’lumotlarni eksport qilish uchun mo‘ljallangan **Telegram bot**.

---

## 🚀 Loyihaning Maqsadi

Foydalanuvchilarga o‘z moliyasini samarali boshqarish imkoniyatini berish:
- Daromad va xarajatlarni yozib borish
- Balansni avtomatik hisoblash
- Statistika olish (kunlik, oylik, yillik)
- Ma’lumotlarni eksport qilish (PDF/Excel)

---

## 📱 Botning Asosiy Bo‘limlari

### 1. 🏠 Bosh sahifa
Foydalanuvchining joriy **balansi** va **kalendari** ko‘rsatiladi.

#### Funksiyalar:
- Balansni ko‘rsatish
- Kalendar orqali vaqt bo‘yicha ko‘rish
- ➕ **Yozuv qo‘shish** (daromad yoki xarajat)

#### ➕ Yozuv qo‘shish bosilganda:
Foydalanuvchi tanlaydi:
- [Xarajat qo‘shish]
- [Daromad qo‘shish]

##### Xarajat qo‘shish:
Bot foydalanuvchidan quyidagilarni so‘raydi:
- Miqdor 💰
- Valyuta (UZS, USD, EUR, ...)
- Kategoriya (ovqat, transport, ijara, va h.k.)
- Daromad manbai (ixtiyoriy)
- Sana 📅
- Izoh ✏️  
  ➡️ So‘ng: **[Xarajatni qo‘shish]**

##### Daromad qo‘shish:
- Miqdor 💵
- Valyuta
- Kategoriya (ish haqi, qo‘shimcha daromad, va h.k.)
- Sana 📅
- Izoh ✏️  
  ➡️ So‘ng: **[Daromadni qo‘shish]**

---

### 2. 📊 Statistika
Foydalanuvchining daromad va xarajatlari bo‘yicha tahliliy ma’lumotlar ko‘rinadi.

#### Funksiyalar:
- [Xarajatlar] yoki [Daromad]ni tanlash
- Vaqt oralig‘ini tanlash:
    - [Kunlik]
    - [Haftalik]
    - [Oylik]
    - [Yillik]
- Statistikani raqamli yoki grafik shaklda ko‘rsatish

---

### 3. ⚙️ Ko‘proq
Qo‘shimcha funksiyalar:
- Ma’lumotlarni **eksport qilish** (PDF yoki Excel)
- Sana oralig‘ini tanlab eksport qilish
- Foydalanuvchi ma’lumotlarini boshqarish

---

## 🗄️ Ma’lumotlar Bazasi

- Har bir foydalanuvchi uchun alohida profil yaratiladi
- Foydalanuvchining barcha daromad/xarajat ma’lumotlari DB’da saqlanadi
- Har bir yozuvda quyidagi maydonlar mavjud:
    - Sana
    - Miqdor
    - Kategoriya
    - Izoh

---

## 🧪 Test va Nazorat

#### Sinov ssenariylari:
- `/start` → bot ishga tushadi, menyu chiqadi
- “Daromad qo‘shish” → barcha maydonlar to‘ldiriladi
- “Xarajat qo‘shish” → to‘liq test qilinadi
- “Statistika” → turli vaqt oralig‘ida natijalar chiqadi
- “Ko‘proq” → eksport fayllari to‘g‘ri yaratiladi va yuboriladi

---

## 🔒 Xavfsizlik va Maxfiylik

- Har bir foydalanuvchining ma’lumoti **shaxsiy** saqlanadi
- Ma’lumotlar bazasiga faqat bot orqali kirish mumkin
- Admin foydalanuvchining ma’lumotlarini **ko‘ra olmaydi**
- HTTPS (TLS) orqali xavfsiz ulanish tavsiya etiladi

---

## 🎯 Yakuniy Natija

Foydalanuvchi quyidagilarni bajara oladi:
- 💵 Daromad va xarajatlarini kiritish
- 📈 Balansni kuzatish
- 📊 Statistika olish
- 📂 Ma’lumotlarni PDF yoki Excel shaklida eksport qilish

---

## 🧰 Texnik Tafsilotlar

| Komponent | Tavsiya etilgan texnologiya |
|------------|-----------------------------|
| Backend | PHP 8.x |
| Ma’lumotlar bazasi | MySQL / PostgreSQL |
| Telegram API | BotFather orqali olingan `BOT_TOKEN` |
| Ma’lumot eksporti | FPDF / PHPSpreadsheet |
| Hosting | Render, Railway, yoki VPS (HTTPS bilan) |

---

## ⚡ Ishga Tushirish (Quick Start)

1. **Bot tokenini oling:**  
   Telegram’da `@BotFather` orqali yangi bot yarating va tokenni saqlang.
2. **Web-serverni sozlang:**  
   PHP 8+ va MySQL o‘rnatilgan bo‘lishi kerak.
3. **Webhook o‘rnatish:**
   ```bash
   curl -F "url=https://yourdomain.com/webhook.php" https://api.telegram.org/bot<YOUR_TOKEN>/setWebhook

© 2025 | Mavlyanov013 tomonidan yaratilgan
<<<<<<< HEAD
=======
>>>>>>> 7cf3227 (Add initial project files and README)
>>>>>>> 20aa862 (Resolve merge conflict in README.md)
