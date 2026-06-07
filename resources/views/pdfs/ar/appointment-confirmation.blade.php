<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>موعد طبي</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #2c3e50;
            margin: 0;
            padding: 40px 50px;
            background-color: #fff;
            direction: rtl;
        }

        img {
            display: block;
            margin: 0 auto 25px auto;
            height: 80px;
            object-fit: contain;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            color: #34495e;
            margin-bottom: 35px;
            letter-spacing: 0.5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 13px;
        }

        th, td {
            padding: 10px 12px;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .border-black {
            border: 1px solid #2c3e50 !important;
            background-color: #f9f9f9;
        }

        .section-title {
            background-color: #ecf0f1;
            font-weight: bold;
            color: #2c3e50;
            padding: 8px 12px;
            text-transform: uppercase;
            font-size: 12px;
            border: 1px solid #bdc3c7;
        }

        .bold {
            font-weight: bold;
            color: #2c3e50;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #7f8c8d;
            text-align: center;
            line-height: 1.5;
        }

        hr {
            border: none;
            border-top: 1px solid #bdc3c7;
            margin: 30px 0;
        }
    </style>
</head>
<body>

    <img src="{{ public_path('img/med.png') }}" alt="logo">

    <h2 class="title">نموذج موعد طبي</h2>

    {{-- معلومات المريض --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">معلومات المريض</td>
        </tr>
        <tr>
            <td class="bold" width="35%">رمز المريض</td>
            <td class="border-black text-center">{{ $patient_code }}</td>
        </tr>
        <tr>
            <td class="bold">اسم المريض</td>
            <td class="border-black text-center">{{ $patient_name }}</td>
        </tr>
    </table>

    {{-- تفاصيل الموعد --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">تفاصيل الموعد</td>
        </tr>
        <tr>
            <td class="bold" width="35%">تاريخ الموعد</td>
            <td class="border-black text-center">{{ $day_at }}</td>
        </tr>
        <tr>
            <td class="bold">نوع الموعد</td>
            <td class="border-black text-center">
                {{ config('constants.APPOINTMENT_TYPES')['ar'][$type] }}
            </td>
        </tr>
        <tr>
            <td class="bold">ترتيب المريض</td>
            <td class="border-black text-center">{{ $queue_number ?? '-' }}</td>
        </tr>
    </table>

    {{-- مكان الاستشارة --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">مكان الاستشارة</td>
        </tr>
        <tr>
            <td class="bold" width="35%">العيادة / المستشفى</td>
            <td class="border-black text-center">{{ $appointments_location }}</td>
        </tr>
        <tr>
            <td class="bold">رقم الهاتف</td>
            <td class="border-black text-center">{{ $appointments_location_tel }}</td>
        </tr>
    </table>

    {{-- المعلومات الطبية --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">المعلومات الطبية</td>
        </tr>
        <tr>
            <td class="bold" width="35%">الطبيب</td>
            <td class="border-black text-center">{{ $doctor_name }}</td>
        </tr>
        <tr>
            <td class="bold">التخصص</td>
            <td class="border-black text-center">{{ $specialty }}</td>
        </tr>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <hr>
        <p>
            يرجى الحضور مبكرًا وإحضار السجلات الطبية، ومعلومات التأمين،
            وقائمة بالأدوية الحالية.
        </p>
        <p>
            نحن فخورون بدعم احتياجاتك الصحية.
        </p>
    </div>

</body>
</html>
