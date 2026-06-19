<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Analíticas - Devlinked</title>
    <style>
        @page { margin: 110px 50px 70px 50px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #2c3e50; margin: 0; padding: 0; font-size: 12px; line-height: 1.5; }
        .watermark { position: fixed; top: 38%; left: 5%; width: 90%; text-align: center; opacity: 0.04; font-size: 85px; font-weight: 900; letter-spacing: 10px; text-transform: uppercase; color: #000000; transform: rotate(-30deg); z-index: -1000; }
        header { position: fixed; top: -85px; left: 0px; right: 0px; height: 65px; border-bottom: 2px solid #0056b3; padding-bottom: 8px; }
        .header-title { font-size: 18px; font-weight: bold; color: #003366; text-transform: uppercase; letter-spacing: 1px; margin: 0; }
        .header-subtitle { font-size: 10px; color: #7f8c8d; margin: 3px 0 0 0; }
        .brand-badge { float: right; font-size: 14px; font-weight: bold; color: #004488; letter-spacing: 2px; margin-top: 10px; }
        footer { position: fixed; bottom: -45px; left: 0px; right: 0px; height: 30px; text-align: center; font-size: 9px; color: #bdc3c7; border-top: 1px solid #ecf0f1; padding-top: 8px; }
        .page-number:after { content: counter(page); }
        h2 { font-size: 14px; color: #003366; border-left: 4px solid #0056b3; padding-left: 8px; margin-top: 25px; margin-bottom: 12px; text-transform: uppercase; }
        .summary-box { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-box td { width: 33.33%; padding: 12px; background: #f4f7fa; border: 1px solid #dbe3eb; text-align: center; }
        .summary-box .metric { font-size: 20px; font-weight: bold; color: #0056b3; display: block; }
        .summary-box .label { font-size: 10px; color: #7f8c8d; text-transform: uppercase; margin-top: 4px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th { background-color: #004488; color: #ffffff; text-align: left; padding: 8px 10px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid #003366; }
        table.data-table td { padding: 7px 10px; border: 1px solid #e2e8f0; }
        table.data-table tr:nth-child(even) { background-color: #f8fafc; }
        .text-right { text-align: right; }
        .highlight { font-weight: bold; color: #0056b3; }
        tr { page-break-inside: avoid; }
    </style>
</head>
<body>

    <div class="watermark">DEVLINKED</div>

    <header>
        <span class="brand-badge">DEVLINKED</span>
        <h1 class="header-title">Sistemas de Información de Portafolios</h1>
        <p class="header-subtitle">
            Reporte Analítico del Portafolio: <strong>{{ $portafolio->nombre ?? $portafolio->slug }}</strong> | 
            Mes Evaluado: {{ $fechaInicio->translatedFormat('F Y') }} ({{ $fechaInicio->format('d/m/Y') }} al {{ $fechaFin->format('d/m/Y') }})
        </p>
    </header>
    <div style="clear: both;"></div>

    <footer>
        Devlinked Platform - Documento de Analíticas Internas - Página <span class="page-number"></span>
    </footer>

    {{-- 1. SECCIÓN VISTAS GENERALES --}}
    @if($filtros['vistas'])
        <h2>Resumen General de Tráfico (Vistas del Mes)</h2>
        <table class="summary-box">
            <tr>
                <td>
                    <span class="metric">{{ number_format($visitantes->total_visitantes ?? 0) }}</span>
                    <span class="label">Total Visitantes</span>
                </td>
                <td>
                    <span class="metric">{{ number_format($visitantes->visitantes_nuevos ?? 0) }}</span>
                    <span class="label">Usuarios Nuevos</span>
                </td>
                <td>
                    <span class="metric">{{ number_format($visitantes->visitantes_recurrentes ?? 0) }}</span>
                    <span class="label">Usuarios Recurrentes</span>
                </td>
            </tr>
        </table>

        <p style="font-size: 11px; color:#555; margin-bottom: 25px;">
            * <strong>Última actividad registrada en este período:</strong> {{ $visitantes->ultima_visita ? date('d/m/Y H:i', strtotime($visitantes->ultima_visita)) : 'Sin registros en el mes' }}
        </p>
    @endif

    {{-- 2. SECCIÓN INTERACCIONES DETALLADAS (Opcional según Filtro) --}}
    @if($filtros['perfil'])
        <h2>Interacciones Detalladas del Perfil</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Elemento de Interacción</th>
                    <th class="text-right">Total Eventos / Clics</th>
                    <th class="text-right">Tiempo Total de Retención (Hover)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Fotografía de Perfil</strong></td>
                    <td class="text-right highlight">{{ number_format($perfil->clic_foto_perfil ?? 0) }}</td>
                    <td class="text-right">{{ number_format(($perfil->hover_foto_ms ?? 0) / 1000, 2) }} s ({{ number_format($perfil->hover_foto_count ?? 0) }} hovers)</td>
                </tr>
                
                @if($filtros['mensajes'])
                <tr>
                    <td><strong>Botón de Acción "Contactar" (Mensajes)</strong></td>
                    <td class="text-right highlight">{{ number_format($perfil->clic_contactar ?? 0) }}</td>
                    <td class="text-right" style="color: #ccc;">N/A</td>
                </tr>
                @endif

                <tr>
                    <td><strong>Enlace de Correo Electrónico</strong></td>
                    <td class="text-right highlight">{{ number_format($perfil->clic_correo ?? 0) }}</td>
                    <td class="text-right">{{ number_format(($perfil->hover_correo_ms ?? 0) / 1000, 2) }} s ({{ number_format($perfil->hover_correo_count ?? 0) }} hovers)</td>
                </tr>
                <tr>
                    <td><strong>Perfil Profesional LinkedIn</strong></td>
                    <td class="text-right highlight">{{ number_format($perfil->clic_linkedin ?? 0) }}</td>
                    <td class="text-right" style="color: #ccc;">N/A</td>
                </tr>
                <tr>
                    <td><strong>Repositorio GitHub</strong></td>
                    <td class="text-right highlight">{{ number_format($perfil->clic_github ?? 0) }}</td>
                    <td class="text-right" style="color: #ccc;">N/A</td>
                </tr>

                @if($filtros['cv'])
                <tr>
                    <td><strong>Descarga de Currículum Vitae (CV)</strong></td>
                    <td class="text-right highlight">{{ number_format($perfil->clic_descargar_cv ?? 0) }}</td>
                    <td class="text-right" style="color: #ccc;">N/A</td>
                </tr>
                @endif
            </tbody>
        </table>
    @endif

    {{-- 3. HISTORIAL DE TRÁFICO --}}
    @if($filtros['vistas'])
        <h2>Historial de Visitas de Este Mes</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Métrica de Acceso del Período</th>
                    <th class="text-right">Volumen de Tráfico (Visitas Únicas)</th>
                    <th class="text-right">Porcentaje de Impacto</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = $visitantes->total_visitantes ?? 0;
                    $pctNuevos = $total > 0 ? (($visitantes->visitantes_nuevos ?? 0) / $total) * 100 : 0;
                    $pctRecurrentes = $total > 0 ? (($visitantes->visitantes_recurrentes ?? 0) / $total) * 100 : 0;
                @endphp
                <tr>
                    <td><strong>Usuarios Nuevos</strong> (Primera sesión registrada en este mes)</td>
                    <td class="text-right highlight">{{ number_format($visitantes->visitantes_nuevos ?? 0) }}</td>
                    <td class="text-right">{{ number_format($pctNuevos, 2) }}%</td>
                </tr>
                <tr>
                    <td><strong>Usuarios Recurrentes</strong> (Visitas de usuarios con interacciones previas)</td>
                    <td class="text-right highlight">{{ number_format($visitantes->visitantes_recurrentes ?? 0) }}</td>
                    <td class="text-right">{{ number_format($pctRecurrentes, 2) }}%</td>
                </tr>
                <tr style="background-color: #f1f5f9; font-weight: bold;">
                    <td>Total Volumen Consolidado</td>
                    <td class="text-right highlight" style="color: #004488;">{{ number_format($total) }}</td>
                    <td class="text-right" style="color: #004488;">100.00%</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- 4. SECCIÓN PROYECTOS Y ZONAS CALIENTES --}}
    @if($filtros['proyectos'] || $filtros['perfil'])
        <h2>Análisis de Competencias y Zonas Calientes</h2>
        
        @if($filtros['proyectos'])
            <table class="data-table" style="margin-bottom: 10px;">
                <thead>
                    <tr>
                        <th>Acción en Habilidad Técnica</th>
                        <th class="text-right">Número Total de Clics</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Despliegues / Detalles Expandidos</td>
                        <td class="text-right highlight">{{ number_format($tecnicas->clic_expandir ?? 0) }}</td>
                    </tr>
                    <tr>
                        <td>Secciones Cerradas / Contraídas</td>
                        <td class="text-right highlight">{{ number_format($tecnicas->clic_cerrar ?? 0) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        <table style="width: 100%; margin-top: 15px;">
            <tr>
                {{-- Subtabla Perfil (Muestra solo si está activo perfil) --}}
                <td style="width: 48%; vertical-align: top; padding: 0;">
                    @if($filtros['perfil'])
                        <h3 style="font-size: 11px; color:#003366; margin: 0 0 5px 0;">Top Clics Coordenadas Perfil</h3>
                        <table class="data-table" style="font-size: 11px;">
                            @forelse($clicsPerfil as $cp)
                                <tr>
                                    <td>{{ $cp->campo }}</td>
                                    <td class="text-right highlight" style="width: 35%;">{{ $cp->intensidad }} clics</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" style="color:#aaa;">Sin clics en coordenadas este mes.</td></tr>
                            @endforelse
                        </table>
                    @endif
                </td>
                
                <td style="width: 4%;"></td>
                
                {{-- Subtabla Proyectos (Muestra solo si está activo proyectos) --}}
                <td style="width: 48%; vertical-align: top; padding: 0;">
                    @if($filtros['proyectos'])
                        <h3 style="font-size: 11px; color:#003366; margin: 0 0 5px 0;">Top Clics Coordenadas Proyectos</h3>
                        <table class="data-table" style="font-size: 11px;">
                            @forelse($clicsProyectos as $cpp)
                                <tr>
                                    <td>{{ $cpp->campo }}</td>
                                    <td class="text-right highlight" style="width: 35%;">{{ $cpp->intensidad }} clics</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" style="color:#aaa;">Sin clics en coordenadas este mes.</td></tr>
                            @endforelse
                        </table>
                    @endif
                </td>
            </tr>
        </table>
    @endif

</body>
</html>