
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Rendimento Acadêmico</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 1rem 1.5rem;
            margin-right: 0.5rem;
            border-radius: 10px 10px 0 0;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        
        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
        }
        
        .badge-performance {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .performance-a {
            background-color: #28a745;
            color: white;
        }
        
        .performance-b {
            background-color: #17a2b8;
            color: white;
        }
        
        .performance-c {
            background-color: #ffc107;
            color: #212529;
        }
        
        .performance-d {
            background-color: #dc3545;
            color: white;
        }
        
        .test-name {
            font-weight: 500;
            color: #495057;
        }
        
        .semester-info {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0"><i class="fas fa-chart-line me-3"></i>Programa Esperança Garcia</h1>
                    <p class="mb-0 mt-2 opacity-75">Acompanhamento de desempenho por semestre</p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-graduation-cap" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-body p-0">
                <ul class="nav nav-tabs" id="semesterTabs" role="tablist">
                    @foreach($eads as $index => $ead)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($index == 0) active @endif" id="sem-{{ $ead->semestre }}-tab" data-bs-toggle="tab" data-bs-target="#sem-{{ $ead->semestre }}" type="button" role="tab">
                            <i class="fas fa-calendar-alt me-2"></i>Semestre {{ $ead->semestre }}
                        </button>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content p-4" id="semesterTabContent">
                    @foreach($eads as $index => $ead)
                    <div class="tab-pane fade @if($index == 0) active show @endif" id="sem-{{ $ead->semestre }}" role="tabpanel">
                        <div class="semester-info">
                            @php
                                // Defina os períodos conforme necessário
                                $periodos = [
                                    '02/2024' => [
                                            'semestre' => 'Segundo Semestre 2024',
                                            'periodo' => 'Agosto - Dezembro 2024'
                                    ],
                                    '01/2025' => [
                                            'semestre' => 'Primeiro Semestre 2025',
                                            'periodo' => 'Janeiro - Julho 2025'
                                    ],
                                    '02/2025' => [
                                            'semestre' => 'Segundo Semestre 2025',
                                            'periodo' => 'Agosto - Dezembro 2025'
                                    ],
                                    '01/2026' => [
                                            'semestre' => 'Primeiro Semestre 2026',
                                            'periodo' => 'Janeiro - Julho 2026'
                                    ],
                                    '02/2026' => [
                                            'semestre' => 'Segundo Semestre 2026',
                                            'periodo' => 'Agosto - Dezembro 2026'
                                    ],
                                    // Adicione mais períodos conforme necessário
                                ];
                                $periodo_texto = isset($periodos[$ead->semestre]) ? $periodos[$ead->semestre] : ['semestre' => 'Não informado', 'periodo' => 'Não informado'];
                            @endphp
                            <h4><i class="fas fa-calendar me-2"></i>{{  $periodo_texto['semestre']  }}</h4>
                            <p class="mb-0">Período: {{ $periodo_texto['periodo'] }}</p>
                        </div>
                        

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome da Pessoa</th>
                                        <th scope="col">Palestras</th>
                                        <th scope="col">Encontros Pedagógicos</th>
                                        <th scope="col">Encontros GARCIA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ead->inscritos as $index => $inscrito)
                                    <tr>
                                        <td>{{ $index }}</td>
                                        <td class="test-name">{{  $inscrito->name }}</td>
                                        <td>{{ isset($counters_participantes[$inscrito->id]['participation']['Palestras']) ? $counters_participantes[$inscrito->id]['participation']['Palestras'] : 0 }}
                                            /
                                            {{ isset($counters_tipo['Palestras']) ? $counters_tipo['Palestras'] : 0 }}
                                            @php
                                                // Cálculo de porcentagem pode ser ajustado conforme necessário
                                                $participation = isset($counters_participantes[$inscrito->id]['participation']['Palestras']) ? $counters_participantes[$inscrito->id]['participation']['Palestras'] : 0;
                                                $total = isset($counters_tipo['Palestras']) ? $counters_tipo['Palestras'] : 0;
                                                $percentage = $total > 0 ? ($participation / $total) * 100 : 0;
                                            @endphp
                                             <span class="badge badge-performance
                                                @if($percentage < 50) performance-d @endif
                                                @if($percentage >= 50 && $percentage < 75) performance-b @endif
                                                @if($percentage >= 75) performance-a @endif
                                            ">
                                                ({{ round($percentage) }}%)
                                            </span>
                                        </td>
                                        <td>{{ isset($counters_participantes[$inscrito->id]['participation']['Encontros pedagógicos']) ? $counters_participantes[$inscrito->id]['participation']['Encontros pedagógicos'] : 0 }}
                                            /
                                            {{ isset($counters_tipo['Encontros pedagógicos']) ? $counters_tipo['Encontros pedagógicos'] : 0 }}
                                            @php
                                                // Cálculo de porcentagem pode ser ajustado conforme necessário
                                                $participation = isset($counters_participantes[$inscrito->id]['participation']['Encontros pedagógicos']) ? $counters_participantes[$inscrito->id]['participation']['Encontros pedagógicos'] : 0;
                                                $total = isset($counters_tipo['Encontros pedagógicos']) ? $counters_tipo['Encontros pedagógicos'] : 0;
                                                $percentage = $total > 0 ? ($participation / $total) * 100 : 0;
                                            @endphp
                                             <span class="badge badge-performance
                                                @if($percentage < 50) performance-d @endif
                                                @if($percentage >= 50 && $percentage < 75) performance-b @endif
                                                @if($percentage >= 75) performance-a @endif
                                             ">
                                                ({{ round($percentage) }}%)
                                            </span>
                                        </td>
                                        <td>{{ isset($counters_participantes[$inscrito->id]['participation']['Encontros GARCIA']) ? $counters_participantes[$inscrito->id]['participation']['Encontros GARCIA'] : 0 }}
                                            /
                                            {{ isset($counters_tipo['Encontros GARCIA']) ? $counters_tipo['Encontros GARCIA'] : 0 }}
                                            @php
                                                // Cálculo de porcentagem pode ser ajustado conforme necessário
                                                $participation = isset($counters_participantes[$inscrito->id]['participation']['Encontros GARCIA']) ? $counters_participantes[$inscrito->id]['participation']['Encontros GARCIA'] : 0;
                                                $total = isset($counters_tipo['Encontros GARCIA']) ? $counters_tipo['Encontros GARCIA'] : 0;
                                                $percentage = $total > 0 ? ($participation / $total) * 100 : 0;
                                            @endphp
                                             <span class="badge badge-performance
                                                @if($percentage < 50) performance-d @endif
                                                @if($percentage >= 50 && $percentage < 75) performance-b @endif
                                                @if($percentage >= 75) performance-a @endif
                                             ">
                                                ({{ round($percentage) }}%)
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-4 bg-light">
        <div class="container text-center">
            <p class="mb-0 text-muted">
                <i class="fas fa-chart-bar me-2"></i>Biko - 2024
            </p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Adiciona funcionalidade de tooltip se necessário
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Animação suave para as tabs
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');
                });
            });
        });

        // Função para atualizar estatísticas dinamicamente (simulação)
        function updateStats() {
            const activeTab = document.querySelector('.tab-pane.active');
            if (activeTab) {
                const statsCards = activeTab.querySelectorAll('.stats-number');
                // Aqui você poderia fazer uma chamada AJAX para buscar dados reais
                console.log('Atualizando estatísticas para:', activeTab.id);
            }
        }

        // Chama a função de atualização quando uma aba é ativada
        document.addEventListener('shown.bs.tab', updateStats);
    </script>
</body>
</html>