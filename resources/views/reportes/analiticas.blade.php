<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-bottom:20px;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
        }

        h1,h2{
            text-align:center;
        }
    </style>
</head>
<body>

<h1>Reporte de Analíticas</h1>

<h2>Visitantes</h2>

<table>
    <tr>
        <th>Total</th>
        <th>Nuevos</th>
        <th>Recurrentes</th>
    </tr>

    <tr>
        <td>{{ $visitantes->total_visitantes ?? 0 }}</td>
        <td>{{ $visitantes->visitantes_nuevos ?? 0 }}</td>
        <td>{{ $visitantes->visitantes_recurrentes ?? 0 }}</td>
    </tr>
</table>

<h2>Interacciones Perfil</h2>

<table>
    <tr>
        <th>LinkedIn</th>
        <th>GitHub</th>
        <th>Correo</th>
        <th>CV</th>
    </tr>

    <tr>
        <td>{{ $perfil->clic_linkedin ?? 0 }}</td>
        <td>{{ $perfil->clic_github ?? 0 }}</td>
        <td>{{ $perfil->clic_correo ?? 0 }}</td>
        <td>{{ $perfil->clic_descargar_cv ?? 0 }}</td>
    </tr>
</table>

<h2>Habilidades Técnicas</h2>

<table>
    <tr>
        <th>Expandir</th>
        <th>Cerrar</th>
    </tr>

    <tr>
        <td>{{ $tecnicas->clic_expandir ?? 0 }}</td>
        <td>{{ $tecnicas->clic_cerrar ?? 0 }}</td>
    </tr>
</table>

</body>
</html>