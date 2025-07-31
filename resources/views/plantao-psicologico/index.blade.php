@extends('layouts.app')

@section('content')
<div class="page-wrapper">
  <div class="container-xl">
    <div class="page-header d-print-none">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h1 class="fs-1">Agendar Plantão Psicológico</h1>
        </div>
      </div>
    </div>

    @if(session()->has('success'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-success text-center">
                {!! session('success') !!}
            </div>
        </div>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="row mt-2">
        <div class="col-6 m-auto">
            <div class="alert alert-danger text-center">
                {!! session('error') !!}
            </div>
        </div>
    </div>
    @endif

    @if ($errors->any())
        <div class="row mt-2">
            <div class="col-6 m-auto">
                <div class="alert alert-danger text-center">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
      <div class="card-body">
        <!-- Step 1: Selecionar Psicólogo -->
        <div id="step-1">
          <h4 class="card-title">1. Escolha o Psicólogo</h4>
          <div class="row gx-2 gy-2">
            @foreach($psicologos as $psicologo)
              <div class="col-6 col-md-3">
                <button type="button" class="btn btn-default w-100 text-start select-psico" data-id="{{ $psicologo->user_id }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="7" r="4" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                  </svg>
                  {{ $psicologo->nome }}
                </button>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Step 2: Selecionar Data -->
        <div id="step-2" class="d-none">
          <h4 class="card-title">2. Escolha a Data</h4>
          <div id='calendar'></div>
        </div>

        <!-- Step 3: Selecionar Horário -->
        <div id="step-3" class="d-none mt-4">
          <h4 class="card-title">3. Escolha o Horário</h4>
          <div id="times-container" class="row gx-2 gy-2">
            {{-- Horários serão carregados via JS --}}
          </div>
        </div>

        <!-- Step 4: Resumo e Confirmar -->
        <div id="step-4" class="d-none">
          <h4 class="card-title">4. Confirme seu Agendamento</h4>
          <dl class="row">
            <dt class="col-sm-3">Psicólogo</dt>
            <dd class="col-sm-9" id="summary-psico"></dd>

            <dt class="col-sm-3">Data</dt>
            <dd class="col-sm-9" id="summary-date"></dd>

            <dt class="col-sm-3">Horário</dt>
            <dd class="col-sm-9" id="summary-time"></dd>
          </dl>
          <button id="confirm-btn" class="btn btn-primary">Confirmar Agendamento</button>
          <a class="btn btn-default ms-3" href="{{ route('plantao-psicologico.index') }}">Resetar</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js"></script>
<script>
  let selectedPsico = null;
  let selectedDate = null;
  let selectedTime = null;
  let calendar;

  document.querySelectorAll('.select-psico').forEach(btn => {
    btn.addEventListener('click', () => {
      selectedPsico = {
        id: btn.dataset.id,
        name: btn.textContent.trim()
      };

      document.getElementById('step-1').classList.add('d-none');
      document.getElementById('step-2').classList.remove('d-none');

      initCalendar();
    });
  });

  function initCalendar() {
    if (calendar) {
      calendar.destroy();
    }

    const calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        height: 500,
        selectable: true,
        validRange: {
        start: new Date().toISOString().split('T')[0]
        },
        events: async function(info, successCallback, failureCallback) {
            const res = await fetch(`/api/psicologos/${selectedPsico.id}/datas`);
            const datas = await res.json();
            const events = datas.map(date => ({ title: 'Disponível', start: date, allDay: true }));
            successCallback(events);
        },
        dateClick: function(info) {
            selectedDate = info.dateStr;
            document.getElementById('step-3').classList.remove('d-none');
            loadTimes(selectedDate);
        },
        eventClick: function(info) {
            // info.event.start é a data do evento clicado
            selectedDate = info.event.startStr; // string no formato 'YYYY-MM-DD'
            document.getElementById('step-3').classList.remove('d-none');
            loadTimes(selectedDate);
        }
    });

    calendar.render();
  }

  function loadTimes(date) {
    fetch(`/api/psicologos/${selectedPsico.id}/horarios?date=${date}`)
      .then(res => res.json())
      .then(times => {
        const container = document.getElementById('times-container');
        container.innerHTML = '';
        times.forEach(time => {
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'btn btn-outline-secondary';
          btn.textContent = time;
          btn.addEventListener('click', () => selectTime(time));
          container.appendChild(btn);
        });
      });
  }

    function formatDateToBR(dateStr) {
        const [year, month, day] = dateStr.split('-');
        return `${day}/${month}/${year}`;
    }

    function selectTime(time) {
        selectedTime = time;
        document.getElementById('summary-psico').textContent = selectedPsico.name;
        document.getElementById('summary-date').textContent = formatDateToBR(selectedDate);
        document.getElementById('summary-time').textContent = selectedTime;

        document.getElementById('step-2').classList.add('d-none');
        document.getElementById('step-3').classList.add('d-none');
        document.getElementById('step-4').classList.remove('d-none');
    }

  document.getElementById('confirm-btn').addEventListener('click', () => {
    const payload = {
        psicologo_id: selectedPsico.id,
        data: selectedDate,
        horario: selectedTime
    };

    fetch('{{ route('plantao-psicologico.agendar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify(payload)
    })
    .then(async res => {
        const data = await res.json();

        if (data.success) {
            console.log('Agendamento realizado com sucesso!');
            window.location.reload();
        } else {
            console.error(data);
            console.error('Erro ao agendar: ' + (data.message || 'verifique os dados.'));
        }
    })
    .catch(err => {
        console.error(err);
        console.error('Erro inesperado: ' + err.message);
    });
});
</script>
@endsection