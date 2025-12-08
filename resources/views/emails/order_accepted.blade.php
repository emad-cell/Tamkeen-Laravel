<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلبك مقبول - منصة تمكين</title>
    <style>
        body {
            font-family: "Tahoma", sans-serif;
            background-color: #f9fafb;
            color: #333;
            padding: 20px;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2563eb; /* لون أزرق قريب لهوية تمكين */
        }
        .footer {
            margin-top: 25px;
            font-size: 13px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>مرحباً 👋</h1>
        <p>
            يسرنا إعلامك أن طلبك رقم <strong>#{{ $order->id }}</strong>
            والمتعلق بخدمة <strong>{{ $order->service->name }}</strong>
            قد تم <span style="color: green; font-weight: bold;">قبوله</span>.
        </p>
        <p>
            يمكنك متابعة تفاصيل الخدمة والتواصل مع الجمعية المقدمة من خلال الايميل التالي
            association@example.com
        او من عبر هذا الرقم
         0938614264
        </p>
        <p>
            شكراً لاستخدامك منصتنا ونتمنى لك تجربة مميزة.
        </p>

        <div class="footer">
            &copy; {{ date('Y') }} منصة تمكين. جميع الحقوق محفوظة.
        </div>
    </div>
</body>
</html>
