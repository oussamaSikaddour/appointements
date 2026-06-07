<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous médical</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #2c3e50;
            margin: 0;
            padding: 40px 50px;
            background-color: #fff;
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

    <h2 class="title">Fiche de rendez-vous médical</h2>

    {{-- Informations patient --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">Informations du patient</td>
        </tr>
        <tr>
            <td class="bold" width="35%">Code patient</td>
            <td class="border-black text-center">{{ $patient_code }}</td>
        </tr>
        <tr>
            <td class="bold">Nom du patient</td>
            <td class="border-black text-center">{{ $patient_name }}</td>
        </tr>
    </table>

    {{-- Détails du rendez-vous --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">Détails du rendez-vous</td>
        </tr>
        <tr>
            <td class="bold" width="35%">Date du rendez-vous</td>
            <td class="border-black text-center">{{ $day_at }}</td>
        </tr>
        <tr>
            <td class="bold">Type de rendez-vous</td>
            <td class="border-black text-center">
                {{ config('constants.APPOINTMENT_TYPES')['fr'][$type] }}
            </td>
        </tr>
        <tr>
            <td class="bold">Position du patient</td>
            <td class="border-black text-center">{{ $queue_number ?? '-' }}</td>
        </tr>
    </table>

    {{-- Lieu de consultation --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">Lieu de consultation</td>
        </tr>
        <tr>
            <td class="bold" width="35%">Clinique / Hôpital</td>
            <td class="border-black text-center">{{ $appointments_location }}</td>
        </tr>
        <tr>
            <td class="bold">Téléphone</td>
            <td class="border-black text-center">{{ $appointments_location_tel }}</td>
        </tr>
    </table>

    {{-- Informations médicales --}}
    <table>
        <tr>
            <td class="section-title" colspan="2">Informations médicales</td>
        </tr>
        <tr>
            <td class="bold" width="35%">Médecin</td>
            <td class="border-black text-center">{{ $doctor_name }}</td>
        </tr>
        <tr>
            <td class="bold">Spécialité</td>
            <td class="border-black text-center">{{ $specialty }}</td>
        </tr>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <hr>
        <p>
            Merci d'arriver à l'heure et d'apporter vos dossiers médicaux, informations d'assurance,
            et la liste de vos médicaments actuels.
        </p>
        <p>
            Nous sommes honorés de soutenir vos besoins de santé.
        </p>
    </div>

</body>
</html>
