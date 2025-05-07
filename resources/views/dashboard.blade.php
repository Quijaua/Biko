@extends('layouts.app')

@section('content')

<style>
body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}
#chart-dia {
  width: 800px;
  height: 350px;
}

#chart-mes {
  width: 400px;
  height: 400px;
}

#chart-genero {
  width: 400px;
  height: 200px;
}

#chart-raca {
  width: 400px;
  height: 200px;
}

#chart-soube {
  width: 400px;
  height: 200px;
}

#chart-etaria {
  width: 400px;
  height: 200px;
}

#chart-escola {
  width: 520px;
  height: 200px;
}

#chart-ecivil {
  width: 400px;
  height: 200px;
}

#chart-nucleo {
  width: 900px;
  height: 500px;
}


</style>

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>


<link href="https://unpkg.com/tabulator-tables@4.5.3/dist/css/tabulator.min.css" rel="stylesheet">
<script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.5.3/dist/js/tabulator.min.js"></script>

    <div class="container">
       <div class="row">
       <div class="container-fluid">
    @php
    $cadastros = DB::select('select count(*) as qtd, DATE_FORMAT(created_at,"%Y-%m-%d") as dia FROM users GROUP BY dia');
    $meses = DB::select('select count(*) as qtd, DATE_FORMAT(created_at,"%Y-%m") as mes FROM users GROUP BY mes');
    $racas = DB::select('select count(*) as qtd, IF(Raca IS NULL or Raca = "", "Outros", Raca) as raca FROM alunos GROUP BY raca');
    $generos = DB::select('select count(*) as qtd, IF(Genero IS NULL or Genero = "", "Outros", Genero) as genero FROM alunos GROUP BY genero');
    $soubes = DB::select('select count(*) as qtd, IF(ComoSoube IS NULL or ComoSoube = "", "Outros", ComoSoube) as csoube from alunos group by csoube');
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
    $pornucleos = DB::select('select count(*) as qtd, NomeNucleo from alunos group by NomeNucleo order by qtd');
    $ecivis = DB::select('select count(*) as qtd, IF(EstadoCivil IS NULL or EstadoCivil = "", "Outros", EstadoCivil) as ecivil from alunos group by ecivil');
    $escolas = DB::select('SELECT CASE WHEN EnsFundamental = "[\"particular sem bolsa\"]" THEN "Particular sem bolsa" WHEN EnsFundamental = "[\"rede publica\",\"particular sem bolsa\"]" THEN "Rede pública e particular sem bolsa" WHEN EnsFundamental = "[\"rede publica\"]" THEN "Rede Pública" ELSE "Outros" END AS EnsFundamental, COUNT(*) AS qtd FROM alunos GROUP BY EnsFundamental');
    @endphp


  <div class="row">
    <div class="col" style="text-align: center">
      <div class="form-group">
        <h1><?php echo $alunos; ?></h1> Estudantes
        <p><strong><?php echo $alunos1 ?></strong> Ativos / <strong><?php echo $alunos0 ?></strong> Inativos</p>
      </div>
    </div>

    <div class="col" style="text-align: center">
      <div class="form-group">
        <h1><?php echo $alunosoff; ?></h1> Lista de espera
      </div>
    </div>

    <div class="col" style="text-align: center">
      <div class="form-group">
        <h1><?php echo $professores; ?></h1> Professores
      </div>
    </div>
    <div class="col" style="text-align: center">
      <div class="form-group">
        <h1><?php echo $coordenadores; ?></h1>Coordenadores
      </div>
    </div>
    <div class="col" style="text-align: center">
      <div class="form-group">
        <h1><?php echo $nucleos; ?></h1>Núcleos
        <p><strong><?php echo $nucleosoff ?></strong> Inativos</p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col" style="text-align: center">
      <h1>Cadastros por dia</h1>
      <div id="chart-dia"></div>
    </div>
  </div>

  <div class="row" style="margin-top:40px">
    <div class="col">
      <h2>Por mês</h2>
      <div id="chart-mes"></div>
    </div>
    <div class="col">
      <h2>Por teste</h2>
      <div id="chart-nucleo2"></div>
    </div>
  </div>

<div class="row" style="margin-top:40px">
  <div class="col">
    <h2>Por núcleo</h2>
    <div id="chart-nucleo"></div>
  </div>
</div>


<div class="container" style="margin-top:100px">
  <div class="row">
    <div class="col">
      <h2 style="text-align: center">Por Raça</h2>
      <div id="chart-raca"></div> 
    </div>
    <div class="col">
      <h2 style="text-align: center">Por Gênero</h2>
      <div id="chart-genero"></div>
    </div>
  </div>
  <div class="row" style="margin-top:100px">
    <div class="col">
      <h2 style="text-align: center">Faxa etária</h2>
      <div id="chart-etaria"></div>
    </div>
    <div class="col">
      <h2 style="text-align: center">Como Soube</h2>
      <div id="chart-soube"></div>
    </div>
  </div>

  <div class="row" style="margin-top:100px">
    <div class="col">
      <h2 style="text-align: center">Escola Públicas ou Privada</h2>
      <div id="chart-escola"></div>
    </div>
    <div class="col">
      <h2 style="text-align: center">Por estado civil</h2>
      <div id="chart-ecivil"></div>
    </div>
  </div>


<h2 style="margin-top:100px;text-align:center">Para qual (quais) curso(s) pretende prestar vestibular?</h2>
<div class="row" style="margin-top:40px">
  
    <div class="col">
    <h3 style="text-align: center">Primeira Opção</h3>
    <div id="cursos1"></div>
    </div>
    <div class="col">
    <h3 style="text-align: center">Segunda Opção</h3>
    <div id="cursos2"></div>
    </div>
</div>    


<script>
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chart-dia", am4charts.XYChart);

// Add data
chart.data = [
            <?php
            foreach($cadastros as $cadastro){
		echo "{'date':'" . $cadastro->dia . "','value':'" . $cadastro->qtd . "'},";
            };
            ?>

];

// Set input format for the dates
chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "date";
series.tooltipText = "{value}";
series.strokeWidth = 2;
series.minBulletDistance = 15;

// Drop-shaped tooltips
series.tooltip.background.cornerRadius = 20;
series.tooltip.background.strokeOpacity = 0;
series.tooltip.pointerOrientation = "vertical";
series.tooltip.label.minWidth = 40;
series.tooltip.label.minHeight = 40;
series.tooltip.label.textAlign = "middle";
series.tooltip.label.textValign = "middle";

// Make bullets grow on hover
var bullet = series.bullets.push(new am4charts.CircleBullet());
bullet.circle.strokeWidth = 2;
bullet.circle.radius = 4;
bullet.circle.fill = am4core.color("#fff");

var bullethover = bullet.states.create("hover");
bullethover.properties.scale = 1.3;

// Make a panning cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.behavior = "panXY";
chart.cursor.xAxis = dateAxis;
chart.cursor.snapToSeries = series;

// Create vertical scrollbar and place it before the value axis
chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarY.parent = chart.leftAxesContainer;
chart.scrollbarY.toBack();

// Create a horizontal scrollbar with previe and place it underneath the date axis
chart.scrollbarX = new am4charts.XYChartScrollbar();
chart.scrollbarX.series.push(series);
chart.scrollbarX.parent = chart.bottomAxesContainer;

dateAxis.start = 0.79;
dateAxis.keepSelection = true;

chart.exporting.menu = new am4core.ExportMenu();
 </script>


<script>
// POR MES
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chart-mes", am4charts.XYChart);
chart.data = [
            <?php
            foreach($meses as $mes){ 
                echo "{'year':'" . $mes->mes . "','value':'" . $mes->qtd . "'},";
            };
            ?>

];

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "year";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "value";
series.dataFields.categoryX = "year";
series.name = "Visits";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

chart.exporting.menu = new am4core.ExportMenu();

</script>


<script>
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chart-raca", am4charts.PieChart);

var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "qtd";
pieSeries.dataFields.category = "raca";

chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
.cursorOverStyle = [
{
  "property": "cursor",
  "value": "pointer" }];

//chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();

chart.data = [
            <?php
            foreach($racas as $raca){
                echo "{'raca':'" . $raca->raca . "','qtd':'" . $raca->qtd . "'},";
            };
            ?>
];
  </script>



<script>  
// GENERO
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chart-genero", am4charts.PieChart);

var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "qtd";
pieSeries.dataFields.category = "genero";

chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
.cursorOverStyle = [
{
  "property": "cursor",
  "value": "pointer" }];

//chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();

chart.data = [
            <?php
            foreach($generos as $genero){
                echo "{'genero':'" . $genero->genero . "','qtd':'" . $genero->qtd . "'},";
            };
            ?>
            ];
  </script>



<script>
// COMO SOUBE
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chart-soube", am4charts.PieChart);

var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "qtd";
pieSeries.dataFields.category = "tipo";

chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
.cursorOverStyle = [
{
  "property": "cursor",
  "value": "pointer" }];

//chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();

chart.data = [
            <?php
            foreach($soubes as $soube){
                echo "{'tipo':'" . $soube->csoube . "','qtd':'" . $soube->qtd . "'},";
            };
            ?>
];
  </script>



<script>
// FAIXA ETARIA
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chart-etaria", am4charts.PieChart);

var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "qtd";
pieSeries.dataFields.category = "tipo";

chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
.cursorOverStyle = [
{
  "property": "cursor",
  "value": "pointer" }];

//chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();

chart.data = [
            <?php
            foreach($faixas as $faixa){
                echo "{'tipo':'" . $faixa->age_group . "','qtd':'" . $faixa->age_count . "'},";
            };
            ?>
];
  </script>

<script>
// ESCOLAS
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chart-escola", am4charts.PieChart);

var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "qtd";
pieSeries.dataFields.category = "tipo";

chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
.cursorOverStyle = [
{
  "property": "cursor",
  "value": "pointer" }];

//chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();

chart.data = [
            <?php
            foreach($escolas as $escola){
                echo "{'tipo':'" . $escola->EnsFundamental . "','qtd':'" . $escola->qtd . "'},";
            };
            ?>
            ];
  </script>


<script>
// ESTADO CIVIL
am4core.useTheme(am4themes_animated);
var chart = am4core.create("chart-ecivil", am4charts.PieChart);

var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "qtd";
pieSeries.dataFields.category = "tipo";

chart.innerRadius = am4core.percent(30);

// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
.cursorOverStyle = [
{
  "property": "cursor",
  "value": "pointer" }];

//chart.legend = new am4charts.Legend();
chart.exporting.menu = new am4core.ExportMenu();

chart.data = [
            <?php
            foreach($ecivis as $ecivil){
                echo "{'tipo':'" . $ecivil->ecivil . "','qtd':'" . $ecivil->qtd . "'},";
            };
            ?>
];
  </script>

<script>
// curso mais desejados 1
var tabledata = [
  <?php
    foreach($curso1s as $curso1){
      echo "{'curso':'" . $curso1->OpcoesVestibular1 . "','qtd':'" . $curso1->qtd . "'},";
    };
  ?>
 ];

var table = new Tabulator("#cursos1", {
	data:tabledata,           //load row data from array
	layout:"fitColumns",      //fit columns to width of table
	responsiveLayout:"hide",  //hide columns that dont fit on the table
	tooltips:true,            //show tool tips on cells
	addRowPos:"top",          //when adding a new row, add it to the top of the table
	history:true,             //allow undo and redo actions on the table
	pagination:"local",       //paginate the data
	paginationSize:7,         //allow 7 rows per page of data
	movableColumns:true,      //allow column order to be changed
	resizableRows:true,       //allow row order to be changed
	initialSort:[             //set the initial sort order of the data
		{column:"qtd", dir:"desc"},
	],
  columns:[ //Define Table Columns
	 	{title:"Curso", field:"curso", width:150},
	 	{title:"Quantidade", field:"qtd", align:"left", formatter:"progress"},

 	],
});
</script>


<script>
// curso mais desejados 2
var tabledata = [
  <?php
    foreach($curso2s as $curso2){
      echo "{'curso':'" . $curso2->OpcoesVestibular2 . "','qtd':'" . $curso2->qtd . "'},";
    };
  ?>
 ];

var table = new Tabulator("#cursos2", {
	data:tabledata,           //load row data from array
	layout:"fitColumns",      //fit columns to width of table
	responsiveLayout:"hide",  //hide columns that dont fit on the table
	tooltips:true,            //show tool tips on cells
	addRowPos:"top",          //when adding a new row, add it to the top of the table
	history:true,             //allow undo and redo actions on the table
	pagination:"local",       //paginate the data
	paginationSize:7,         //allow 7 rows per page of data
	movableColumns:true,      //allow column order to be changed
	resizableRows:true,       //allow row order to be changed
	initialSort:[             //set the initial sort order of the data
		{column:"qtd", dir:"desc"},
	],
  columns:[ //Define Table Columns
	 	{title:"Curso", field:"curso", width:150},
	 	{title:"Quantidade", field:"qtd", align:"left", formatter:"progress"},

 	],
});
</script>


<script>
// ALUNOS POR NÚCLEO
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chart-nucleo", am4charts.XYChart);
chart.scrollbarX = new am4core.Scrollbar();

chart.data = [
            <?php
            foreach($pornucleos as $pornucleo){ 
                echo "{'nucleo':'" . $pornucleo->NomeNucleo . "','value':'" . $pornucleo->qtd . "'},";
            };
            ?>

];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "nucleo";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "value";
series.dataFields.categoryX = "nucleo";
series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;

// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});
// Cursor
chart.cursor = new am4charts.XYCursor();

chart.exporting.menu = new am4core.ExportMenu();

</script>

</div></div>

@endsection
