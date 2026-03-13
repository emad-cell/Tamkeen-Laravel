Tamkeen Platform — Laravel Backend

هذا المستودع يحتوي على جزء (Backend) من منصة تمكين، وهي منصّة تهدف إلى ربط ذوي الاحتياجات الخاصة بالجمعيّات المختصّة من خلال عرض الخدمات والوظائف وإتاحة التقديم عليها بسهولة.

يوفّر هذا المشروع API ونظام إدارة (Dashboard) لإدارة البيانات التي تظهر في الواجهة الأمامية المبنية بـ React.

🎯 الهدف من النظام

تقديم خدمة تمكّن:

الجمعيات من إضافة خدماتها وبرامجها.

الشركات من نشر الوظائف المناسبة لذوي الاحتياجات الخاصة.

المستخدمين من تصفّح الخدمات والوظائف.

التقديم المباشر من خلال المنصّة.

إدارة كاملة للطلبات والمستخدمين عبر لوحة تحكم مبنية بلارافيل.

🛠 التقنيات والأدوات المستخدمة

Laravel (الإصدار الحديث)

MySQL كقاعدة بيانات

Eloquent ORM

Authentication System

API Resources

Migrations & Seeders

Validation Requests

🚀 المميزات الأساسية في الـ Backend

إدارة المستخدمين (Users Management)

إدارة الجمعيات (Organizations)

إدارة الوظائف (Jobs)

إدارة الخدمات (Services)

إدارة طلبات التقديم (Applications)

نظام صلاحيات مرن (إن وجد)

API نظيفة جاهزة للاستهلاك من تطبيق React

📦 التثبيت والتشغيل
1) نسخ المشروع
git clone <repo-url>
cd tamkeen-laravel

2) تثبيت الاعتمادات
composer install

3) إعداد ملف البيئة
cp .env.example .env


ثم عدّل إعدادات قاعدة البيانات داخل ملف .env.

4) توليد مفتاح التشفير
php artisan key:generate

5) إعداد قاعدة البيانات
php artisan migrate --seed

6) تشغيل السيرفر المحلي
php artisan serve


يعمل السيرفر الافتراضي على:

http://localhost:8000

🔌 استهلاك الـ API

واجهة React أو أي عميل آخر يمكنه استهلاك الـ API من خلال المسارات المعرّفة في:

routes/api.php

📁 هيكلة المشروع (مختصر)
app/
 ├── Models/
 ├── Http/
 │    ├── Controllers/
 │    ├── Requests/
 │    └── Resources/
routes/
 ├── api.php
 └── web.php
database/
 ├── migrations/
 ├── seeders/

🧑‍💻 المطوّر

Emad
Full-Stack Developer — Laravel & React

📄 الرخصة

هذا المشروع مفتوح للاستخدام والتطوير.
