@extends('layouts.app')

@section('content')

<style>
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  }
</style>

<div class="page-header d-print-none">
	<div class="container-xl">
		<div class="row g-2 align-items-center">
			<div class="col">
				<div class="page-pretitle">
					Visão geral
				</div>
				<h2 class="page-title">
					Dashboard
				</h2>
			</div>
    </div>
	</div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      @php
        $cadastros = DB::select('select count(*) as qtd, DATE_FORMAT(created_at,"%Y-%m-%d") as dia FROM users GROUP BY dia');
        $meses = DB::select('select count(*) as qtd, DATE_FORMAT(created_at,"%Y-%m") as mes FROM users GROUP BY mes');
        $racas = DB::select('select count(*) as qtd, IF(Raca IS NULL or Raca = "" or Raca = "Selecione", "Outros", Raca) as raca FROM alunos GROUP BY raca');
        $generos = DB::select('select count(*) as qtd, IF(Genero IS NULL or Genero = "" or Genero = "Selecione", "Outros", Genero) as genero FROM alunos GROUP BY genero');
        $soubes = DB::select('select count(*) as qtd, IF(ComoSoube IS NULL or ComoSoube = "" or ComoSoube = "Selecione", "Outros", ComoSoube) as csoube from alunos group by csoube');
        $alunos = DB::table('alunos')->count();
        $alunos0 = DB::table('alunos')->where('Status', '0')->count();
        $alunos1 = DB::table('alunos')->where('Status', '1')->count();
        $alunosoff = DB::table('alunos')->where('ListaEspera', 'Sim')->count();
        $professores = DB::table('professores')->count();
        $coordenadores = DB::table('coordenadores')->count();
        $nucleos = DB::table('nucleos')->where('Status', '1')->count();
        $nucleosoff = DB::table('nucleos')->where('Status', '0')->count();
        $faixas = DB::select("SELECT t.age_group, COUNT(*) AS age_count FROM ( SELECT CASE WHEN TIMESTAMPDIFF(YEAR, Nascimento, CURDATE()) BETWEEN 20 AND 25 THEN '20-25' WHEN TIMESTAMPDIFF(YEAR, Nascimento, CURDATE()) BETWEEN 26 AND 35 THEN '26-35'  WHEN TIMESTAMPDIFF(YEAR, Nascimento, CURDATE()) BETWEEN 36 AND 45 THEN '36-45' WHEN TIMESTAMPDIFF(YEAR, Nascimento, CURDATE()) BETWEEN 46 AND 55 THEN '46-55' WHEN TIMESTAMPDIFF(YEAR, Nascimento, CURDATE()) > 55 THEN '46-55' ELSE 'Outros' END AS age_group FROM alunos ) t GROUP BY t.age_group");
        $curso1s = DB::select('select count(*) as qtd, IF(OpcoesVestibular1 IS NULL or OpcoesVestibular1 = "", "Outros", OpcoesVestibular1) as OpcoesVestibular1 from alunos group by OpcoesVestibular1');
        $curso2s = DB::select('select count(*) as qtd, IF(OpcoesVestibular2 IS NULL or OpcoesVestibular2 = "", "Outros", OpcoesVestibular2) as OpcoesVestibular2 from alunos group by OpcoesVestibular2');
        $ufsNucleo1 = DB::select('SELECT IF(Estado IS NULL OR Estado = "" or Estado = "Selecione", "Não informado", Estado) AS uf, COUNT(*) AS qtd FROM alunos WHERE id_nucleo = 1 GROUP BY uf ORDER BY qtd DESC');
        $pornucleos = DB::select('select count(*) as qtd, NomeNucleo from alunos group by NomeNucleo order by qtd');
        $ecivis = DB::select('select count(*) as qtd, IF(EstadoCivil IS NULL or EstadoCivil = "" or EstadoCivil = "Selecione", "Outros", EstadoCivil) as ecivil from alunos group by ecivil');
        $escolas = DB::select('SELECT CASE WHEN EnsFundamental = "[\"particular sem bolsa\"]" THEN "Particular sem bolsa" WHEN EnsFundamental = "[\"rede publica\",\"particular sem bolsa\"]" THEN "Rede pública e particular sem bolsa" WHEN EnsFundamental = "[\"rede publica\"]" THEN "Rede Pública" ELSE "Outros" END AS EnsFundamental, COUNT(*) AS qtd FROM alunos GROUP BY EnsFundamental');
      @endphp

      <div class="row row-cards">
        <!-- Estudantes -->
        <div class="col">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-primary text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="font-weight-medium"><?php echo $alunos; ?> Estudantes</div>
                  <div class="text-secondary"><?php echo $alunos1 ?> Ativos / <?php echo $alunos0 ?> Inativos</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Lista de espera -->
        <div class="col">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-yellow text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="font-weight-medium"><?php echo $alunosoff; ?> Lista de espera</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Professores -->
        <div class="col">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-green text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-screen"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.03 17.818a3 3 0 0 0 1.97 -2.818v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8c0 1.317 .85 2.436 2.03 2.84" /><path d="M10 14a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" /></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="font-weight-medium"><?php echo $professores; ?> Professores</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coordenadores -->
        <div class="col">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-purple text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-message-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 18l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" /><path d="M19 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M22 22a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2" /></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="font-weight-medium"><?php echo $coordenadores; ?> Coordenadores</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Núcleos -->
        <div class="col">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-teal text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-affiliate"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5.931 6.936l1.275 4.249m5.607 5.609l4.251 1.275" /><path d="M11.683 12.317l5.759 -5.759" /><path d="M5.5 5.5m-1.5 0a1.5 1.5 0 1 0 3 0a1.5 1.5 0 1 0 -3 0" /><path d="M18.5 5.5m-1.5 0a1.5 1.5 0 1 0 3 0a1.5 1.5 0 1 0 -3 0" /><path d="M18.5 18.5m-1.5 0a1.5 1.5 0 1 0 3 0a1.5 1.5 0 1 0 -3 0" /><path d="M8.5 15.5m-4.5 0a4.5 4.5 0 1 0 9 0a4.5 4.5 0 1 0 -9 0" /></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="font-weight-medium"><?php echo $nucleos; ?> Núcleos</div>
                  <div class="text-secondary"><?php echo $nucleosoff ?> Inativos</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12 col-xl-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex mb-3">
                <h3 class="card-title">Cadastros por dia</h3>
                <div class="ms-auto">
                  <div class="dropdown">
                    <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="filtro-cadastros-label">
                      Últimos 7 dias
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item active" href="#" data-range="7">Últimos 7 dias</a>
                      <a class="dropdown-item" href="#" data-range="30">Últimos 30 dias</a>
                      <a class="dropdown-item" href="#" data-range="90">Últimos 3 meses</a>
                      <a class="dropdown-item" href="#" data-range="365">Último 1 ano</a>
                      <a class="dropdown-item" href="#" data-range="all">Total</a>
                    </div>
                  </div>
                </div>
              </div>
              <div id="chart-dia" style="height: 350px;"></div>
            </div>
          </div>
        </div>

        <script>
          // Por dia
          document.addEventListener("DOMContentLoaded", function () {
            const chartDiaEl = document.getElementById('chart-dia');
            const dropdownItems = document.querySelectorAll('.dropdown-menu a[data-range]');
            const label = document.getElementById('filtro-cadastros-label');
            let chartDia;

            function filtrarCadastros(dias) {
              fetch(`/dashboard/cadastros-json/${dias}`)
                .then(res => res.json())
                .then(json => {
                  const seriesData = json.map(item => [item.date, item.count]);
                  chartDia.updateSeries([{ name: "Cadastros", data: seriesData }]);
                });
            }

            chartDia = new ApexCharts(chartDiaEl, {
              chart: {
                type: "area",
                fontFamily: 'inherit',
                height: 350,
                parentHeightOffset: 0,
                toolbar: { show: false },
                animations: { enabled: true }
              },
              dataLabels: { enabled: false },
              fill: { opacity: 0.2, type: 'solid' },
              stroke: { width: 2, curve: "smooth" },
              series: [{ name: "Cadastros", data: [] }],
              tooltip: {
                theme: 'dark',
                x: { format: 'dd/MM/yyyy' }
              },
              grid: {
                padding: { top: -10, right: 0, left: -4, bottom: -4 },
                strokeDashArray: 4
              },
              xaxis: {
                type: 'datetime',
                labels: { format: 'dd/MM', rotate: -45 },
                tooltip: { enabled: false },
                axisBorder: { show: false }
              },
              yaxis: { labels: { padding: 4 } },
              colors: [tabler.getColor("primary")],
              legend: { show: false }
            });

            chartDia.render();

            // Dropdown: atualiza texto e ativa item
            dropdownItems.forEach(item => {
              item.addEventListener('click', function (e) {
                e.preventDefault();
                dropdownItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                const dias = this.getAttribute('data-range');
                label.innerText = this.innerText;
                filtrarCadastros(dias);
              });
            });

            // Inicialmente: últimos 7 dias
            filtrarCadastros(7);
          });
        </script>

        <div class="col-lg-6 col-xl-5 d-grid">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Por mês</h3>
              <div id="chart-mes"></div>
            </div>
          </div>
        </div>

        <script>
          // Por mês
          document.addEventListener("DOMContentLoaded", function () {
            const mesesOriginais = [
              <?php foreach ($meses as $mes): ?>
                "<?= $mes->mes ?>",
              <?php endforeach; ?>
            ];
            const mesesData = [
              <?php foreach ($meses as $mes): ?>
                <?= $mes->qtd ?>,
              <?php endforeach; ?>
            ];

            const mesesLabels = mesesOriginais.map(m => {
              const [ano, mes] = m.split('-');
              return mes && ano ? `${mes}/${ano}` : 'Indefinido';
            });

            window.ApexCharts && (new ApexCharts(
              document.getElementById('chart-mes'),
              {
                chart: {
                  type: "bar",
                  fontFamily: 'inherit',
                  height: 320,
                  parentHeightOffset: 0,
                  toolbar: { show: false },
                  animations: { enabled: false }
                },
                plotOptions: {
                  bar: { columnWidth: '50%' }
                },
                dataLabels: { enabled: false },
                fill: { opacity: 1 },
                series: [{
                  name: "Cadastros",
                  data: mesesData
                }],
                tooltip: {
                  theme: 'dark'
                },
                grid: {
                  padding: { top: -20, right: 0, left: -4, bottom: -4 },
                  strokeDashArray: 4
                },
                xaxis: {
                  type: 'category',
                  categories: mesesLabels,
                  labels: {
                    rotate: -45,
                    padding: 0
                  },
                  axisBorder: { show: false },
                  tooltip: { enabled: false }
                },
                yaxis: {
                  labels: { padding: 4 }
                },
                colors: [tabler.getColor("primary")],
                legend: { show: false }
              }
            )).render();
          });
        </script>

        <div class="col-lg-12 col-xl-7">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Estudantes do Núcleo Virtual por Estado</h3>
              <div id="chart-uf-nucleo1"></div>
            </div>
          </div>
        </div>

        <script>
          document.addEventListener("DOMContentLoaded", function () {
            // Estudantes por UF (Núcleo 1)
            const ufLabels = [
              <?php foreach ($ufsNucleo1 as $uf): ?>"<?= addslashes($uf->uf ?: 'Não informado') ?>",<?php endforeach; ?>
            ];
            const ufData = [
              <?php foreach ($ufsNucleo1 as $uf): ?><?= $uf->qtd ?>,<?php endforeach; ?>
            ];

            new ApexCharts(document.getElementById('chart-uf-nucleo1'), {
              chart: {
                type: "bar",
                fontFamily: 'inherit',
                height: 320,
                parentHeightOffset: 0,
                toolbar: { show: false },
                animations: { enabled: false }
              },
              plotOptions: {
                bar: {
                  horizontal: true,
                  barHeight: '50%'
                }
              },
              dataLabels: { enabled: false },
              fill: { opacity: 1 },
              series: [{
                name: "Estudantes",
                data: ufData
              }],
              tooltip: { theme: 'dark' },
              grid: {
                padding: { top: -20, right: 0, left: -4, bottom: -4 },
                strokeDashArray: 4
              },
              xaxis: {
                categories: ufLabels,
                labels: {
                  style: { fontSize: '12px' },
                  maxHeight: 120
                },
                axisBorder: { show: false }
              },
              yaxis: {
                labels: { padding: 4 }
              },
              colors: [ tabler.getColor("blue") ],
              legend: { show: false }
            }).render();
          });
        </script>

        <div class="col-lg-12 col-xl-12">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Alunos por núcleo</h3>
              <div style="overflow-x: auto;">
                <div id="chart-nucleo" style="height: 500px;"></div>
              </div>
            </div>
          </div>
        </div>

        <script>
          document.addEventListener("DOMContentLoaded", function () {
            // Recebe dados do PHP
            const nucLabels = [
              <?php foreach($pornucleos as $pornucleo): ?>
                "<?= addslashes($pornucleo->NomeNucleo) ?>",
              <?php endforeach; ?>
            ];
            const nucData = [
              <?php foreach($pornucleos as $pornucleo): ?>
                <?= $pornucleo->qtd ?>,
              <?php endforeach; ?>
            ];

            if (!window.ApexCharts) return;

            new ApexCharts(
              document.getElementById('chart-nucleo'),
              {
                chart: {
                  type: "bar",
                  fontFamily: 'inherit',
                  height: 500,
                  toolbar: { show: false },
                  animations: { enabled: false }
                },
                plotOptions: {
                  bar: {
                    columnWidth: '50%',
                    borderRadius: 4,
                    distributed: true
                  }
                },
                dataLabels: { enabled: false },
                series: [{
                  name: "Alunos",
                  data: nucData
                }],
                tooltip: {
                  theme: 'dark'
                },
                grid: {
                  padding: { top: -20, right: 0, left: -4, bottom: 4 },
                  strokeDashArray: 4
                },
                xaxis: {
                  type: 'category',
                  categories: nucLabels,
                  labels: {
                    rotate: 270,
                    style: { fontSize: '12px' },
                    trim: false
                  },
                  axisBorder: { show: false },
                  tooltip: { enabled: false }
                },
                yaxis: {
                  labels: { padding: 4 }
                },
                colors: [
                  tabler.getColor("primary"),
                  tabler.getColor("secondary"),
                  tabler.getColor("success"),
                  tabler.getColor("warning"),
                  tabler.getColor("danger")
                ],
                legend: { show: false }
              }
            ).render();
          });
        </script>


        <div class="col-lg-6 col-xl-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center">Por Raça</h3>
              <div id="chart-raca" style="height: 240px;"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xl-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center">Por Gênero</h3>
              <div id="chart-genero" style="height: 240px;"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xl-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center">Faixa etária</h3>
              <div id="chart-etaria" style="height: 240px;"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xl-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center">Como Soube</h3>
              <div id="chart-soube" style="height: 240px;"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xl-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center">Escola Pública ou Privada</h3>
              <div id="chart-escola" style="height: 240px;"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xl-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center">Por Estado Civil</h3>
              <div id="chart-ecivil" style="height: 240px;"></div>
            </div>
          </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function () {
          if (!window.ApexCharts) return;

          // Função única de tradução de labels
          function traduzirLabel(tipo, valor) {
            if (valor.toLowerCase() === 'Selecione') {
              return 'Outros';
            }

            const mapas = {
              raca: {
                negra: 'Preta',
                branca: 'Branca',
                parda: 'Parda',
                amarela: 'Amarela',
                indigena: 'Indígena'
              },
              genero: {
                homem: 'Homem (Cis/Trans)',
                homem_trans_cis: 'Homem (Cis/Trans)',
                mulher: 'Mulher (Cis/Trans)',
                mulher_trans_cis: 'Mulher (Cis/Trans)',
                nao_binarie: 'Não Binárie'
              },
              como_soube: {
                internet: 'Internet',
                panfleto: 'Panfleto',
                amigos: 'Amigos',
                jornal: 'Jornal',
                outros: 'Outros'
              },
              estado_civil: {
                solteiro_a: 'Solteiro(a)',
                casado_a: 'Casado(a)',
                uniao_estavel: 'União Estável',
                divorciado_a: 'Divorciado(a)',
                viuvo_a: 'Viúvo(a)',
                Selecione: 'Selecione'
              }
            };

            return (mapas[tipo] && mapas[tipo][valor]) ||
              (valor.charAt(0).toUpperCase() + valor.slice(1).replace(/_/g, ' '));
          }

          // --- POR RAÇA ---
          const rawRaca = [
            <?php foreach ($racas as $r): ?>
              "<?= addslashes($r->raca) ?>",
            <?php endforeach; ?>
          ];
          const racaData = [
            <?php foreach ($racas as $r): ?><?= $r->qtd ?>,<?php endforeach; ?>
          ];
          const racaLabels = rawRaca.map(l => traduzirLabel('raca', l));

          new ApexCharts(document.getElementById('chart-raca'), {
            chart: { type: "donut", height: 240, sparkline: { enabled: true }, animations: { enabled: false } },
            series: racaData,
            labels: racaLabels,
            tooltip: { theme: 'dark', fillSeriesColor: false },
            grid: { strokeDashArray: 4 },
            fill: { opacity: 1 },
            colors: [
              tabler.getColor("primary"),
              tabler.getColor("primary", 0.8),
              tabler.getColor("primary", 0.6),
              tabler.getColor("gray-300")
            ],
            legend: { show: true, position: 'bottom', offsetY: 12, markers: { width:10, height:10, radius:100 }, itemMargin:{horizontal:8, vertical:8} }
          }).render();

          // --- GÊNERO ---
          const rawGenero = [
            <?php foreach ($generos as $g): ?>
              { genero: "<?= addslashes($g->genero) ?>", count: <?= $g->qtd ?> },
            <?php endforeach; ?>
          ];
          const gruposGenero = rawGenero.reduce((acc, { genero, count }) => {
            const key = genero.startsWith('homem') ? 'homem_trans_cis'
                      : genero.startsWith('mulher') ? 'mulher_trans_cis'
                      : genero;
            acc[key] = (acc[key] || 0) + count;
            return acc;
          }, {});
          const generoLabels = Object.keys(gruposGenero).map(l => traduzirLabel('genero', l));
          const generoData   = Object.values(gruposGenero);

          new ApexCharts(document.getElementById('chart-genero'), {
            chart: { type: "donut", height: 240, sparkline: { enabled: true }, animations: { enabled: false } },
            series: generoData,
            labels: generoLabels,
            tooltip: { theme: 'dark', fillSeriesColor: false },
            grid: { strokeDashArray: 4 },
            fill: { opacity: 1 },
            colors: [
              tabler.getColor("primary"),
              tabler.getColor("primary", 0.8),
              tabler.getColor("primary", 0.6),
              tabler.getColor("gray-300")
            ],
            legend: { show: true, position: 'bottom', offsetY: 12, markers: { width:10, height:10, radius:100 }, itemMargin:{horizontal:8, vertical:8} }
          }).render();

          // --- FAIXA ETÁRIA ---
          const etariaLabels = [
            <?php foreach ($faixas as $f): ?>"<?= addslashes($f->age_group) ?>",<?php endforeach; ?>
          ];
          const etariaData = [
            <?php foreach ($faixas as $f): ?><?= $f->age_count ?>,<?php endforeach; ?>
          ];
          new ApexCharts(document.getElementById('chart-etaria'), {
            chart: { type: "donut", height: 240, sparkline: { enabled: true }, animations: { enabled: false } },
            series: etariaData,
            labels: etariaLabels,
            tooltip: { theme: 'dark', fillSeriesColor: false },
            grid: { strokeDashArray: 4 },
            fill: { opacity: 1 },
            colors: [
              tabler.getColor("success"),
              tabler.getColor("success", 0.8),
              tabler.getColor("success", 0.6),
              tabler.getColor("gray-300")
            ],
            legend: { show: true, position: 'bottom', offsetY: 12, markers: { width:10, height:10, radius:100 }, itemMargin:{horizontal:8, vertical:8} }
          }).render();

          // --- COMO SOUBE ---
          const rawSoube = [
            <?php foreach ($soubes as $s): ?>
              "<?= addslashes($s->csoube) ?>",
            <?php endforeach; ?>
          ];
          const soubeData = [
            <?php foreach ($soubes as $s): ?><?= $s->qtd ?>,<?php endforeach; ?>
          ];
          const soubeLabels = rawSoube.map(l => traduzirLabel('como_soube', l));
          new ApexCharts(document.getElementById('chart-soube'), {
            chart: { type: "donut", height: 240, sparkline: { enabled: true }, animations: { enabled: false } },
            series: soubeData,
            labels: soubeLabels,
            tooltip: { theme: 'dark', fillSeriesColor: false },
            grid: { strokeDashArray: 4 },
            fill: { opacity: 1 },
            colors: [
              tabler.getColor("warning"),
              tabler.getColor("warning", 0.8),
              tabler.getColor("warning", 0.6),
              tabler.getColor("gray-300")
            ],
            legend: { show: true, position: 'bottom', offsetY: 12, markers: { width:10, height:10, radius:100 }, itemMargin:{horizontal:8, vertical:8} }
          }).render();

          // --- ESCOLA ---
          const escolaLabels = [
            <?php foreach ($escolas as $e): ?>"<?= addslashes($e->EnsFundamental) ?>",<?php endforeach; ?>
          ];
          const escolaData = [
            <?php foreach ($escolas as $e): ?><?= $e->qtd ?>,<?php endforeach; ?>
          ];
          new ApexCharts(document.getElementById('chart-escola'), {
            chart: { type: "donut", height: 240, sparkline: { enabled: true }, animations: { enabled: false } },
            series: escolaData,
            labels: escolaLabels,
            tooltip: { theme: 'dark', fillSeriesColor: false },
            grid: { strokeDashArray: 4 },
            fill: { opacity: 1 },
            colors: [
              tabler.getColor("info"),
              tabler.getColor("info", 0.8),
              tabler.getColor("info", 0.6),
              tabler.getColor("gray-300")
            ],
            legend: { show: true, position: 'bottom', offsetY: 12, markers: { width:10, height:10, radius:100 }, itemMargin:{horizontal:8, vertical:8} }
          }).render();

          // --- ESTADO CIVIL ---
          const rawEcivil = [
            <?php foreach ($ecivis as $e): ?>
              "<?= addslashes($e->ecivil) ?>",
            <?php endforeach; ?>
          ];
          const ecivilData = [
            <?php foreach ($ecivis as $e): ?><?= $e->qtd ?>,<?php endforeach; ?>
          ];
          const ecivilLabels = rawEcivil.map(l => traduzirLabel('estado_civil', l));
          new ApexCharts(document.getElementById('chart-ecivil'), {
            chart: { type: "donut", height: 240, sparkline: { enabled: true }, animations: { enabled: false } },
            series: ecivilData,
            labels: ecivilLabels,
            tooltip: { theme: 'dark', fillSeriesColor: false },
            grid: { strokeDashArray: 4 },
            fill: { opacity: 1 },
            colors: [
              tabler.getColor("danger"),
              tabler.getColor("danger", 0.8),
              tabler.getColor("danger", 0.6),
              tabler.getColor("gray-300")
            ],
            legend: { show: true, position: 'bottom', offsetY: 12, markers: { width:10, height:10, radius:100 }, itemMargin:{horizontal:8, vertical:8} }
          }).render();
        });
        </script>


      </div>
    </div>
  </div>
</div>

<div class="page-header">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title justify-content-center">Para qual (quais) curso(s) pretende prestar vestibular?</h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-lg-12 col-xl-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title text-center">Primeira Opção</h3>
            <div id="chart-curso1" style="height: 240px;"></div>
          </div>
        </div>
      </div>

      <script>
        document.addEventListener("DOMContentLoaded", function () {
          if (!window.ApexCharts) return;

          // Monta arrays de labels e dados vindos do PHP
          const curso1Labels = [
            <?php foreach ($curso1s as $c1): ?>"<?= addslashes($c1->OpcoesVestibular1) ?>",<?php endforeach; ?>
          ];
          const curso1Data = [
            <?php foreach ($curso1s as $c1): ?><?= $c1->qtd ?>,<?php endforeach; ?>
          ];

          new ApexCharts(document.getElementById('chart-curso1'), {
            chart: {
              type: "bar",
              fontFamily: 'inherit',
              height: 240,
              parentHeightOffset: 0,
              toolbar: { show: false },
              animations: { enabled: false }
            },
            plotOptions: {
              bar: {
                horizontal: true,
                barHeight: '50%'
              }
            },
            dataLabels: { enabled: false },
            fill: { opacity: 1 },
            series: [{
              name: "Quantidade",
              data: curso1Data
            }],
            tooltip: { theme: 'dark' },
            grid: {
              padding: { top: -20, right: 0, left: -4, bottom: -4 },
              strokeDashArray: 4
            },
            xaxis: {
              categories: curso1Labels,
              labels: {
                style: { fontSize: '12px' },
                maxHeight: 120
              },
              axisBorder: { show: false }
            },
            yaxis: {
              labels: { padding: 4 }
            },
            colors: [ tabler.getColor("primary") ],
            legend: { show: false }
          }).render();
        });
      </script>

      <div class="col-lg-12 col-xl-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title text-center">Segunda Opção</h3>
            <div id="chart-curso2" style="height: 240px;"></div>
          </div>
        </div>
      </div>

      <script>
        document.addEventListener("DOMContentLoaded", function () {
          if (!window.ApexCharts) return;

          // Monta arrays de labels e dados vindos do PHP
          const curso2Labels = [
            <?php foreach ($curso2s as $c2): ?>"<?= addslashes($c2->OpcoesVestibular2) ?>",<?php endforeach; ?>
          ];
          const curso2Data = [
            <?php foreach ($curso2s as $c2): ?><?= $c2->qtd ?>,<?php endforeach; ?>
          ];

          new ApexCharts(document.getElementById('chart-curso2'), {
            chart: {
              type: "bar",
              fontFamily: 'inherit',
              height: 240,
              parentHeightOffset: 0,
              toolbar: { show: false },
              animations: { enabled: false }
            },
            plotOptions: {
              bar: {
                horizontal: true,
                barHeight: '50%'
              }
            },
            dataLabels: { enabled: false },
            fill: { opacity: 1 },
            series: [{
              name: "Quantidade",
              data: curso2Data
            }],
            tooltip: { theme: 'dark' },
            grid: {
              padding: { top: -20, right: 0, left: -4, bottom: -4 },
              strokeDashArray: 4
            },
            xaxis: {
              categories: curso2Labels,
              labels: {
                style: { fontSize: '12px' },
                maxHeight: 120
              },
              axisBorder: { show: false }
            },
            yaxis: {
              labels: { padding: 4 }
            },
            colors: [ tabler.getColor("secondary") ],
            legend: { show: false }
          }).render();
        });
      </script>
    </div>
  </div>
</div>

<!-- Libs JS -->
<script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js?1738096684') }}" defer></script>

@endsection
