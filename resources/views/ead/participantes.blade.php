@extends('layouts.app')

@inject('session', 'Session')

@section('content')

<!-- styles -->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f7fa;
        min-height: 100vh;
        /* padding: 20px; */
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header h1 {
        font-size: 28px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header h1::before {
        content: "👥";
        font-size: 32px;
    }

    .add-btn {
        background: white;
        color: #667eea;
        border: none;
        padding: 12px 24px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .add-btn::before {
        content: "📹";
        font-size: 18px;
    }

    .event-info {
        padding: 35px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .event-title {
        font-size: 20px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .event-title::before {
        content: "📚";
        font-size: 24px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .info-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .info-card:nth-child(2) {
        border-left-color: #f093fb;
    }

    .info-card:nth-child(3) {
        border-left-color: #4facfe;
    }

    .info-card:nth-child(4) {
        border-left-color: #43e97b;
    }

    .info-label {
        font-size: 12px;
        color: #718096;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-value {
        font-size: 18px;
        color: #2d3748;
        font-weight: 600;
    }

    .participants-section {
        padding: 35px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .participant-count {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .search-box {
        position: relative;
        margin-bottom: 20px;
    }

    .search-input {
        width: 100%;
        padding: 14px 20px 14px 48px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-box::before {
        content: "🔍";
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
    }

    .table-container {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }

    tbody tr:hover {
        background: #f8f9fa;
    }

    tbody tr:last-child {
        border-bottom: none;
    }

    td {
        padding: 20px;
        color: #4a5568;
        font-size: 15px;
    }

    .participant-name {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
    }

    .participant-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #2d3748;
    }

    @media (max-width: 768px) {
        .header {
            padding: 20px;
        }

        .header h1 {
            font-size: 22px;
        }

        .event-info {
            padding: 25px 20px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .participants-section {
            padding: 25px 20px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        th, td {
            padding: 12px;
            font-size: 14px;
        }
    }
</style>
<!-- /styles -->

<div class="page-wrapper">

    <div class="container">

        @if(session::has('success'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-success text-center" role="alert">
                    {!! \Session::get('success') !!}
                </div>
            </div>
        </div>
        @endif
        @if(session::has('error'))
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center" role="alert">
                    {!! \Session::get('error') !!}
                </div>
            </div>
        </div>
        @endif

        <div class="header">
            <h1>EAD - Participantes</h1>
            @if(\Auth::user()->role != 'aluno')
            <a class="add-btn" href="{{ route('ead.create') }}">
                Adicionar novo evento
            </a>
            @endif
        </div>

        <div class="event-info">
            <div class="event-title">{{ $eads->titulo }}</div>
            
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-label">📅 Data</div>
                    <div class="info-value">{{ $eads->data->format('d/m/Y') }}</div>
                </div>
                
                <div class="info-card">
                    <div class="info-label">🕐 Hora Início</div>
                    <div class="info-value">{{ $eads->hora_inicio }}</div>
                </div>
                
                <div class="info-card">
                    <div class="info-label">🕙 Hora Fim</div>
                    <div class="info-value">{{ $eads->hora_fim }}</div>
                </div>
                
                <div class="info-card">
                    <div class="info-label">⏱️ Duração</div>
                    <div class="info-value">{{ $eads->duracao }}</div>
                </div>
            </div>
        </div>

        <div class="participants-section">
            <div class="section-header">
                <div class="section-title">
                    Lista de Participantes
                </div>
                <div class="participant-count">{{ $participantes->count() }} participantes</div>
            </div>

            <div class="search-box">
                <input 
                    type="text" 
                    class="search-input" 
                    placeholder="Buscar participante por nome..."
                    id="searchInput"
                    onkeyup="filtrarParticipantes()"
                >
            </div>

            <div class="table-container">
                <table id="participantsTable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Horário de Entrada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participantes as $participante)
                        <tr>
                            <td>
                                <div class="participant-name">
                                    <div class="participant-avatar">A</div>
                                    {{ $participante->name }}
                                </div>
                            </td>
                            <td><span style="color: #48bb78; font-weight: 500;">✓ Presente</span></td>
                            <td>{{  $participante->created_at->format('H:m')  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>

<script>
    function adicionarEvento() {
        alert('Função para adicionar novo evento será implementada aqui! 📹');
    }

    function filtrarParticipantes() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('participantsTable');
        const rows = table.getElementsByTagName('tr');

        let visibleCount = 0;

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[0];
            if (nameCell) {
                const textValue = nameCell.textContent || nameCell.innerText;
                if (textValue.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                    visibleCount++;
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        // Atualizar contador
        const counter = document.querySelector('.participant-count');
        counter.textContent = `${visibleCount} participante${visibleCount !== 1 ? 's' : ''}`;
    }
</script>

@endsection
