<?php 
    $title = "Quintile Pyramid Charts";
    // $plotTargets = array (array('id'=>'chart1', 'width'=>600, 'height'=>400));
?>
<?php include "opener.php"; ?>

<!-- Example scripts go here -->

  <link class="include" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/smoothness/jquery-ui.css" rel="Stylesheet" /> 

    <style type="text/css">

        .quintile-outer-container {
            width: 900px;
            margin-bottom: 25px;
        }

        .jqplot-chart {
            width: 500px;
            height: 400px;
        }

        pre.code {
            margin-top: 45px;
            clear: both;
        }

        .quintile-toolbar .ui-icon {
            float: right;
            margin: 3px 5px;
        }

        table.stats-table td, table.highlighted-stats-table td {
            background-color: rgb(230, 230, 230);
            padding: 0.5em;
        }

        col.label {
            width: 14em;
        }

        col.value {
            width: 7em;
        }

        td.quintile-value {
            width: 7em;
            text-align: right;
        }

        table.stats-table td.tooltip-header, table.highlighted-stats-table td.tooltip-header {
            background-color: rgb(200, 200, 200);
        }

        table.stats-table, table.highlighted-stats-table, td.contour-cell {
            font-size: 0.7em;
        }

        td.contour-cell {
            height: 1.5em;
            padding-left: 20px;
            padding-bottom: 1.5em;
        }

        table.highlighted-stats-table {
            margin-top: 15px;
        }

        td.stats-cell {
            padding-left: 20px;
            padding-top: 20px;
            vertical-align: top;

        }

        td.stats-cell div.input {
            font-size: 0.7em;
            margin-top: 1.5em;
        }

        div.overlay-chart-container {
            display: none;
            z-index: 11;
            position: fixed;
            width: 588px;
            left: 50%;
            margin-left: -294px;
            background-color: white;
        }

        div.overlay-chart-container .ui-icon {
            float: right;
            margin: 3px 5px;
        }

        div.overlay-shadow {
            display: none;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.8);
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
        }

        @media print {
            td.stats-cell {
                vertical-align: top;
                padding-top: 35px;
            }

            table.stats-table, table.stats-table td {
                 color: #aaaaaa;
                 border: 1px solid #bbbbbb;
                 border-collapse: collapse;
            }

            table.stats-table tr {
                font-family: Verdana,Arial,sans-serif;
                /*font-size: 0.7em;*/
            }
        }

    </style>

    <div class="overlay-shadow"></div>

    <div class="overlay-chart-container ui-corner-all">
        <div class="overlay-chart-container-header ui-widget-header ui-corner-top">Right click the image to Copy or Save As...<div class="ui-icon ui-icon-closethick"></div></div>
        <div class="overlay-chart-container-content ui-corner-bottom"></div>
    </div>

    <div class="quintile-outer-container ui-widget ui-corner-all">
        <div class="quintile-toolbar ui-widget-header  ui-corner-top">
            <span class="quintile-title">Income Level:  First Quintile</span>
            <div class="quintile-toggle ui-icon ui-icon-arrowthickstop-1-n"></div>
            <div class="ui-icon ui-icon-newwin"></div>
        </div>
        <div class="quintile-content ui-widget-content ui-corner-bottom">
            <table class="quintile-display">
                <tr>
                    <td class="chart-cell" rowspan="2">
                        <div class="jqplot-chart"></div>
                    </td>
                    <td class="stats-cell">
                        <table class="stats-table">
                        <colgroup>
                            <col class="label">
                            <col class="value">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td class="ui-corner-tl">Mean Age:</td>
                                <td class="quintile-value summary-meanAge ui-corner-tr"></td>
                            </tr>
                            <tr>
                                <td>Sex Ratio:</td>
                                <td class="quintile-value summary-sexRatio"></td>
                            </tr>
                            <tr>
                                <td>Age Dependency Ratio:</td>
                                <td class="quintile-value summary-ageDependencyRatio"></td>
                            </tr>
                            <tr>
                                <td>Population, Total:</td>
                                <td class="quintile-value summary-populationTotal"></td>
                            </tr>
                            <tr>
                                <td>Population, Male:</td>
                                <td class="quintile-value summary-populationMale"></td>
                            </tr>
                            <tr>
                                <td class="ui-corner-bl">Population, Female:</td>
                                <td class="quintile-value summary-populationFemale ui-corner-br"></td>
                            </tr>
                        </tbody>
                        </table>
                        <table class="highlighted-stats-table">
                        <colgroup>
                            <col class="label">
                            <col class="value">
                        </colgroup>
                        <tbody>
                            <tr class="tooltip-header">
                                <td class="tooltip-header ui-corner-top" colspan="2">Highlighted Range: <span class="tooltip-item tooltipAge">&nbsp;</span></td>
                            </tr>
                            <tr>
                                <td>Population, Male: </td>
                                <td class="quintile-value"><span class="tooltip-item tooltipMale">&nbsp;</span></td>
                            </tr>
                            <tr>
                                <td>Population, Female: </td>
                                <td class="quintile-value"><span class="tooltip-item tooltipFemale">&nbsp;</span></td>
                            </tr>
                            <tr>
                                <td class="ui-corner-bl">Sex Ratio: </td>
                                <td class="quintile-value ui-corner-br"><span class="tooltip-item tooltipRatio">&nbsp;</span></td>
                            </tr>
                        <tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="contour-cell">
                        <input name="showContour" type="checkbox" /> Use as overlay on other charts?
                    </td>
                </tr>
            </table>
        </div>
    </div> 
  
    <script class="code" type="text/javascript" language="javascript">
    $(document).ready(function(){

        // if browser supports canvas, show additional toolbar icons
        if (!$.jqplot.use_excanvas) {
            $('div.quintile-toolbar').append('<div class="ui-icon ui-icon-image"></div><div class="ui-icon ui-icon-print"></div>');
        }

        var quintHash = {0: 'First Quintile', 1: 'Second Quintile', 2: 'Third Quintile', 3: 'Fourth Quintile', 4: 'Fifth Quintile'}

        // Add the needed containers:
        for (var i=1; i<5; i++) {
            var el = $('div.quintile-outer-container:last')
            var clone = el.clone();
            clone.find('span.quintile-title').html('Income Level:  ' + quintHash[i]);
            clone.insertAfter(el);
        }

        var male;
        var female;
        var summaryTable;
        var sexRatios;
        var quintiles = [ [ [27777522, 13657657, 14119865, 22.96185242727780, 22.92340104876670, 22.99840039165770, 95.15435452471940], 
            [0.16814981778556500, 0.16938884829023600, 0.13029899959403300, 0.08445061806046640, 0.05811840452702920, 0.05631028061504850, 0.06512242137179920, 0.06861163659177230, 0.06020567860988050, 0.04355880225459750, 0.02803499342457000, 0.01912758869230340, 0.01515038483762410, 0.01223701332240520, 0.00869244058559189, 0.00529469386492945, 0.00328609724536106, 0.00194751964322071, 0.00114713861262733, 0.00086662207093871], 
            [0.15777933298339800, 0.15671077815250300, 0.12447815070139100, 0.08939377850853680, 0.07830223837100820, 0.08053563812713150, 0.07682071635522590, 0.06269916689630620, 0.04365876627610810, 0.03084162032257200, 0.02432244409407740, 0.02120157090634930, 0.01791380814933710, 0.01326354596024400, 0.00968643784396050, 0.00633359323592785, 0.00349435421488265, 0.00158514030722019, 0.00062587894057936, 0.00035303965324001], 
            [0.96726540940724300, 1.03084161446685000, 1.04551821911720000, 1.01249668698901000, 0.91377904610163700, 0.71793506186340200, 0.67630912102504800, 0.81996977584158100, 1.05847758500203000, 1.33386431492214000, 1.36610600401065000, 1.11490766666616000, 0.87264547467534200, 0.81805292713174800, 0.89240386671080400, 0.86800712885521700, 0.80860485322858600, 0.90961820179781800, 1.18839220506104000, 1.77284683642290000, 2.37438923518884000] ],
          [ [27749565, 13838477, 13911088, 24.59760821726010, 24.93140692365050, 24.25806641635340, 77.89121151531350], 
            [0.13460476947529500, 0.14372006850062500, 0.12847108657610600, 0.09875785820893480, 0.07155805029015120, 0.06299959058572970, 0.06669930695548060, 0.06620210601954020, 0.05883374707069510, 0.04833706700819440, 0.03521801565126300, 0.02559536412958920, 0.02062306586521670, 0.01576211515574400, 0.01023801649094930, 0.00572503164287636, 0.00307516687772024, 0.00165330051290922, 0.00104697926747485, 0.00087929371550523], 
            [0.13970508453303800, 0.13975442365362800, 0.11681679473806300, 0.09435373241811580, 0.08802952295423720, 0.08580953135424240, 0.07740975573970180, 0.06538018068005290, 0.04960049471620990, 0.03735678030431880, 0.02976493031984740, 0.02384624281925690, 0.01786909883056510, 0.01280223896627530, 0.00854305561048803, 0.00534781144388522, 0.00336845668342047, 0.00201559921183726, 0.00124722944598909, 0.00097903557682698], 
            [0.99478035075329800, 0.95846318148882600, 1.02300804808641000, 1.09402516010135000, 1.04121346671673000, 0.80864396372867400, 0.73034724501018900, 0.85714209189972800, 1.00728620755889000, 1.17996112502462000, 1.28717635944761000, 1.17702912743046000, 1.06774746443199000, 1.14809486978252000, 1.22477345443636000, 1.19214694369792000, 1.06494947429125000, 0.90816533289574900, 0.81597117843348200, 0.83506239070880300, 0.89343444858290900] ],
          [ [27773083, 14068521, 13704562, 26.03124974398200, 26.46223974345070, 25.59233340000260, 66.99286359589060], 
            [0.11075465721807600, 0.12531352270434800, 0.12461977157255700, 0.11125959454297800, 0.08638877858554280, 0.06731675090789110, 0.06187750302195390, 0.06283663484842800, 0.05868334457568110, 0.05026814063111530, 0.04079416969542070, 0.03139012243581270, 0.02388339994025160, 0.01756428234835730, 0.01203845901370310, 0.00701750790134651, 0.00386618590184589, 0.00206610447696370, 0.00117506121489637, 0.00088600846283140], 
            [0.11432537302481000, 0.12667609073231400, 0.11974891524623500, 0.10506132545858400, 0.09301444384053810, 0.08267846594852100, 0.07221670745205490, 0.06493541188927070, 0.05720135869997910, 0.04682451198762990, 0.03485427327295350, 0.02629070404866000, 0.01998999845792230, 0.01428519039077750, 0.00980039073555805, 0.00599266397652053, 0.00331791767499821, 0.00156650907345305, 0.00072094415435746, 0.00049880393486330], 
            [1.02655750690901000, 0.99449511323857500, 1.01551553024478000, 1.06831332671397000, 1.08712098857701000, 0.95343309606544400, 0.83582242597784900, 0.87958614394243600, 0.99337814815975000, 1.05315379343805000, 1.10205392288684000, 1.20150435531963000, 1.22567146812179000, 1.22649751828565000, 1.26219850103057000, 1.26098752647638000, 1.20211569414631000, 1.19619066818704000, 1.35395006440030000, 1.67317801793479000, 1.82343918147671000] ],
          [ [27763227, 14197178, 13566049, 27.18018253648030, 27.20726467467510, 27.15223055717600, 58.62068064918010], 
            [0.09684619409307840, 0.11118728522535100, 0.12478646127724500, 0.11986149426641600, 0.09520840637648180, 0.07266436962641580, 0.06157942773922730, 0.05776990145557140, 0.05595079146694350, 0.05422906155293650, 0.04606394160905190, 0.03460401579477880, 0.02431694855838520, 0.01695117276859440, 0.01211661291564830, 0.00784551008485565, 0.00430794264393258, 0.00206401896375649, 0.00099084255721430, 0.00065560102411584], 
            [0.09693358901304290, 0.10652960384957600, 0.11580433409088400, 0.11321777793810400, 0.09912292067710200, 0.08131783917502760, 0.07048109387720830, 0.06833459006738460, 0.06313644652192900, 0.05255568033191890, 0.03903863379099840, 0.02910689297792140, 0.02269025908501970, 0.01651322011205660, 0.01126491285383100, 0.00657328507941835, 0.00372023325715849, 0.00195236631466226, 0.00099341991698984, 0.00071290106976617], 
            [1.04652268320717000, 1.04557914271650000, 1.09227868937597000, 1.12769408251422000, 1.10793353197135000, 1.00519391705143000, 0.93515656400210500, 0.91434829403035100, 0.88472781091218400, 0.92741634411137500, 1.07984413189527000, 1.23485263418514000, 1.24416877771066000, 1.12154903817441000, 1.07427786276195000, 1.12564654732811000, 1.24907168423899000, 1.21184866195041000, 1.10637161065473000, 1.04380755195023000, 0.96240750921599800] ],
          [ [27754352, 14075999, 13678353, 29.11682279982730, 29.25251358929000, 28.97478042663600, 50.90167162031000], 
            [0.07773301902264660, 0.09756477612918870, 0.11769211568808000, 0.11953094319783700, 0.10070874902748300, 0.07710380627667010, 0.06107481209270700, 0.05557245339785060, 0.05625960991605260, 0.05655944052572760, 0.05050018273054490, 0.03998167380585820, 0.03018284824156070, 0.02178128532719260, 0.01546004923447120, 0.01053184010191340, 0.00618324070639374, 0.00309253762350306, 0.00148564380196157, 0.00100097315235749], 
            [0.07414870947175290, 0.08945795766137910, 0.11321883781048900, 0.11651658562245200, 0.09931926283967810, 0.08029240511352740, 0.07198971835798040, 0.07305219001114050, 0.06968907391161920, 0.06031073521142600, 0.04701710534217110, 0.03436632086919040, 0.02578058253156860, 0.01918327371957260, 0.01236986721101920, 0.00632468067099160, 0.00324813634215291, 0.00173308253350124, 0.00107597562154257, 0.00090549914684498], 
            [1.02907119007676000, 1.07881594924275000, 1.12232721275485000, 1.06972980730035000, 1.05569391096106000, 1.04346799653703000, 0.98820437091643300, 0.87304591541007500, 0.78283773210481600, 0.83076356851850300, 0.96506352588551000, 1.10530588311237000, 1.19721831153422000, 1.20479432618776000, 1.16843941971104000, 1.28614891275391000, 1.71360639234849000, 1.95896791328722000, 1.83628956559048000, 1.42088092397757000, 1.13757438283678000] ] ] 

        $('td.summary-meanAge').each(function(index) {
            $(this).html($.jqplot.sprintf('%5.2f', quintiles[index][0][3]));
        });

        $('td.summary-sexRatio').each(function(index) {
            $(this).html($.jqplot.sprintf('%5.2f', quintiles[index][3][0]));
        });

        $('td.summary-ageDependencyRatio').each(function(index) {
            $(this).html($.jqplot.sprintf('%5.2f', quintiles[index][0][6]));
        });

        $('td.summary-populationTotal').each(function(index) {
            $(this).html($.jqplot.sprintf("%'d", quintiles[index][0][0]));
        });

        $('td.summary-populationMale').each(function(index) {
            $(this).html($.jqplot.sprintf("%'d", quintiles[index][0][1]));
        });

        $('td.summary-populationFemale').each(function(index) {
            $(this).html($.jqplot.sprintf("%'d", quintiles[index][0][2]));
        });
        
        // These two variables should be removed outside of the jqplot.com example environment.
        $.jqplot._noToImageButton = true;
        $.jqplot._noCodeBlock = true;

        // the "x" values from the data will go into the ticks array.  
        // ticks should be strings for this case where we have values like "75+"
        var ticks = ["0-4", "5-9", "10-14", "15-19", "20-24", "25-29", "30-34", "35-39", "40-44", "45-49", "50-54", "55-59", "60-64", "65-69", "70-74", "75-79", "80-84", "85-90", "90-94", "95+"];

        // Custom color arrays are set up for each series to get the look that is desired.
        // Two color arrays are created for the default and optional color which the user can pick.
        var greenColors = ["#526D2C", "#77933C"];

        // These options are common to all plots.
        var plotOptions = {
            // We set up a customized title which acts as labels for the left and right sides of the pyramid.
            title: {
                text: '<span style="position:relative;left:25%;">Male</span><span style="position:relative;left:50%;">Female</span>',
                textAlign: 'left'
            },
            // by default, the series will use the green color scheme.
            seriesColors: greenColors,

            grid: {
                drawBorder: false,
                shadow: false,
                background: "white",
                rendererOptions: {
                    // plotBands is an option of the pyramidGridRenderer.
                    // it will put banding at starting at a specified value
                    // along the y axis with an adjustable interval.
                    plotBands: {
                        show: true,
                        interval: 2,
                        color: 'rgb(250, 240, 225)'
                    }
                }
            },

            // This makes the effective starting value of the axes 0 instead of 1.
            // For display, the y axis will use the ticks we supplied.
            defaultAxisStart: 0,
            seriesDefaults: {
                renderer: $.jqplot.PyramidRenderer,
                rendererOptions: {
                    barPadding: 4,
                    fill: false
                },
                yaxis: "yaxis",
                shadow: false,
                show: false
            },

            // We have 10 series, but only 2 will be shown at a time unless an overlay is turned on.
            // Set up options for all series now, so when turned on they will look right.
            series: [
                // For pyramid plots, the default side is right.
                // We want to override here to put first set of bars
                // on left.
                {
                    rendererOptions:{
                        side: "left"
                    }
                },
                {
                    yaxis: "y2axis"
                },
                {
                    rendererOptions: {
                        side: 'left'
                    }
                },
                {
                    yaxis: 'y2axis'
                },
                {
                    rendererOptions: {
                        side: 'left'
                    }
                },
                {
                    yaxis: 'y2axis'
                },
                {
                    rendererOptions: {
                        side: 'left'
                    }
                },
                {
                    yaxis: 'y2axis'
                },
                {
                    rendererOptions: {
                        side: 'left'
                    }
                },
                {
                    yaxis: 'y2axis'
                }
            ],
            axesDefaults: {
                tickOptions: {
                    showGridline: false
                },
                pad: 0,
                rendererOptions: {
                    baselineWidth: 2
                },
                scaleToHiddenSeries: true
            },

            // Set up all the y axes, since users are allowed to switch between them.
            // The only axis that will show is the one that the series are "attached" to.
            // We need the appropriate options for the others for when the user switches.
            axes: {
                xaxis: {
                    tickOptions: {
                        formatter: $.jqplot.PercentTickFormatter,
                        formatString: '%d%%'
                    }
                },
                yaxis: {
                    label: "Age",
                    // Use canvas label renderer to get rotated labels.
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    // include empty tick options, they will be used
                    // as users set options with plot controls.
                    tickOptions: {},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {
                        category: true
                    }
                },
                y2axis: {
                    label: "Age",
                    // Use canvas label renderer to get rotated labels.
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    // include empty tick options, they will be used
                    // as users set options with plot controls.
                    tickOptions: {},
                    showMinorTicks: true,
                    ticks: ticks,
                    rendererOptions: {
                        category: true
                    }
                }
            }
        };

        // These options are different for each series.
        // sopts are common options for the overlay series in each plot.
        var sopts = {color: '#C57225'};

        // An array of 5 elements, one for each plot.
        var plotOptsArr = [];

        // Options for each individual plot
        plotOptsArr[0] = $.extend(true, {}, plotOptions, {series:[{show: true, rendererOptions:{synchronizeHighlight: 1, fill: true}}, {show: true, rendererOptions: {synchronizeHighlight: 0, fill: true}}, sopts, sopts, sopts, sopts, sopts, sopts, sopts, sopts]});

        plotOptsArr[1] = $.extend(true, {}, plotOptions, {series:[sopts, sopts, {show: true, rendererOptions:{synchronizeHighlight: 3, fill: true}}, {show: true, rendererOptions: {synchronizeHighlight: 2, fill: true}}, sopts, sopts, sopts, sopts, sopts, sopts]});

        plotOptsArr[2] = $.extend(true, {}, plotOptions, {series:[sopts, sopts, sopts, sopts, {show: true, rendererOptions:{synchronizeHighlight: 5, fill: true}}, {show: true, rendererOptions: {synchronizeHighlight: 4, fill: true}}, sopts, sopts, sopts, sopts]});

        plotOptsArr[3] = $.extend(true, {}, plotOptions, {series:[sopts, sopts, sopts, sopts, sopts, sopts, {show: true, rendererOptions:{synchronizeHighlight: 7, fill: true}}, {show: true, rendererOptions: {synchronizeHighlight: 6, fill: true}}, sopts, sopts]});

        plotOptsArr[4] = $.extend(true, {}, plotOptions, {series:[sopts, sopts, sopts, sopts, sopts, sopts, sopts, sopts, {show: true, rendererOptions:{synchronizeHighlight: 9, fill: true}}, {show: true, rendererOptions: {synchronizeHighlight: 8, fill: true}}]});


        // Create all the plots at one time.
        // Use jQuery selecctor syntax to select all the plot targets.  Here, no id's were specified on the targets, so they are auto generated.
        // You can get a reference to the individual plot object by:
        //     var plot = $('div.jqplot-chart').eq(0).data('jqplot');
        //
        $('div.jqplot-chart').jqplot([quintiles[0][1], quintiles[0][2], quintiles[1][1], quintiles[1][2], quintiles[2][1], quintiles[2][2], quintiles[3][1], quintiles[3][2], quintiles[4][1], quintiles[4][2]], plotOptsArr[0], plotOptsArr[1], plotOptsArr[2], plotOptsArr[3], plotOptsArr[4]);

        //////
        // The followng functions use verbose css selectors to make
        // it clear exactly which elements they are binging to/operating on
        //////

        // bind to the data highlighting event to make custom tooltip:
        $(".jqplot-target").each(function(index){
            $(this).bind("jqplotDataHighlight", function(evt, seriesIndex, pointIndex, data) {
                // Here, assume first series is male poulation and second series is female population.
                // Adjust series indices as appropriate.
                var plot = $(this).data('jqplot');
                var malePopulation = Math.abs(plot.series[0].data[pointIndex][1]) * quintiles[index][0][1];
                var femalePopulation = Math.abs(plot.series[1].data[pointIndex][1]) * quintiles[index][0][2];
                var malePopulation = quintiles[index][1][pointIndex] * quintiles[index][0][1];
                var femalePopulation = quintiles[index][2][pointIndex] * quintiles[index][0][2];
                // var ratio = femalePopulation / malePopulation * 100;
                var ratio = quintiles[index][3][pointIndex+1];

                $(this).closest('table').find('.tooltipMale').stop(true, true).fadeIn(350).html($.jqplot.sprintf("%'d", malePopulation));
                $(this).closest('table').find('.tooltipFemale').stop(true, true).fadeIn(350).html($.jqplot.sprintf("%'d", femalePopulation));
                $(this).closest('table').find('.tooltipRatio').stop(true, true).fadeIn(350).html($.jqplot.sprintf('%5.2f', ratio));

                // Since we don't know which axis is rendererd and acive with out a little extra work,
                // just use the supplied ticks array to get the age label.
                $(this).closest('table').find('.tooltipAge').stop(true, true).fadeIn(350).html(ticks[pointIndex]);
            });
        });

        // bind to the data highlighting event to make custom tooltip:
        $(".jqplot-target").each(function() {
            $(this).bind("jqplotDataUnhighlight", function(evt, seriesIndex, pointIndex, data) {
                // clear out all the tooltips.
                $(this).closest('table').find(".tooltip-item").fadeOut(250);
            });
        });

        // Open and close the plot container.
        $('.quintile-toggle').each(function() {
            $(this).click(function(e) {
                if ($(this).hasClass('ui-icon-arrowthickstop-1-n')) {
                    $(this).parent().next('.quintile-content').effect('blind', {mode:'hide'}, 600);
                    // $('.quintile-content').jqplotEffect('blind', {mode: 'hide'}, 600);
                    $(this).removeClass('ui-icon-arrowthickstop-1-n');
                    $(this).addClass('ui-icon-arrowthickstop-1-s');
                }
                else if ($(this).hasClass('ui-icon-arrowthickstop-1-s')) {
                    $(this).parent().next('.quintile-content').effect('blind', {mode:'show'}, 600, function() {
                        $(this).find('div.jqplot-chart').data('jqplot').replot();
                    });
                    // $('.quintile-content').jqplotEffect('blind', {mode: 'show'}, 150);
                    $(this).removeClass('ui-icon-arrowthickstop-1-s');
                    $(this).addClass('ui-icon-arrowthickstop-1-n');
                }
            });
        });

        // Handle each of the checkboxes to display overlays.
        $('input[type=checkbox][name=showContour]').each(function(index) {
            // on load/reload, clear all the check boxes.
            $(this).get(0).checked = false;

            // bind to change event event on the checkbox.
            $(this).change(function(evt){

                // if check box is checked.
                if (this.checked) {
                    // uncheck all other check boxes.
                    $('input[type=checkbox][name=showContour]').each(function(cidx) {
                        if (cidx !== index) {
                            this.checked = false;
                        }
                    });

                    // On each chart, show the checked plot's overlay and
                    // show the original plot.
                    $('div.jqplot-chart').each(function(pidx) {
                        var plot = $(this).data('jqplot');
                        
                        // Set up options to hide all series.
                        var seriesOpts = [{show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}];

                        // Show series for this particular plot (pidx) and for the checked plot (index).
                        seriesOpts[2 * pidx].show = true;
                        seriesOpts[2 * pidx + 1].show = true;
                        seriesOpts[2 * index].show = true;
                        seriesOpts[2 * index + 1].show = true;

                        // replot with the new options.
                        plot.replot({series: seriesOpts});

                    });
                }

                // if check box is not checked.
                else {
                    $('div.jqplot-chart').each(function(pidx) { 
                        // Set up options to hide all series.
                        var seriesOpts = [{show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}, {show: false}];
                        var plot = $(this).data('jqplot');

                        // Here showing only the series for this particular plot (pidx).
                        seriesOpts[2 * pidx].show = true;
                        seriesOpts[2 * pidx + 1].show = true;

                        // replot with the new options.
                        plot.replot({series: seriesOpts});
                    });
                }
            })
        });

        $('.ui-icon-print').click(function(){
            $(this).parent().next().print();
        });


        $('.ui-icon-image').each(function() {
            $(this).bind('click', function(evt) {
                var chart = $(this).closest('div.quintile-outer-container').find('div.jqplot-target');
                var imgelem = chart.jqplotToImageElem();
                var div = $('div.overlay-chart-container-content');
                div.empty();
                div.append(imgelem);
                $('div.overlay-shadow').fadeIn(600);
                div.parent().fadeIn(1000);
                div = null;
            });
        });


        $('.ui-icon-newwin').each(function(index) {
            $(this).bind('click', function(evt) {
                var url = 'kcp_pyramid_by_age.php?qidx='+index;
                window.open(url);
            });
        });

        $('div.overlay-chart-container-header div.ui-icon-closethick').click(function(){
            var div = $('div.overlay-chart-container-content');
            div.parent().fadeOut(600);
            $('div.overlay-shadow').fadeOut(1000);
        });

    });
    </script>

<!-- End example scripts -->

<!-- Don't touch this! -->

<?php include "commonScripts.html" ?>

<!-- End Don't touch this! -->

<!-- Additional plugins go here -->

    <script class="include" type="text/javascript" src="../src/plugins/jqplot.categoryAxisRenderer.js"></script>

    <!-- load the pyramidAxis and Grid renderers in production.  pyramidRenderer will try to load via ajax if not present, but that is not optimal and depends on paths being set. -->
    <script class="include" type="text/javascript" src="../src/plugins/jqplot.pyramidAxisRenderer.js"></script>
    <script class="include" type="text/javascript" src="../src/plugins/jqplot.pyramidGridRenderer.js"></script> 

    <script class="include" type="text/javascript" src="../src/plugins/jqplot.pyramidRenderer.js"></script>
    <script class="include" type="text/javascript" src="../src/plugins/jqplot.canvasTextRenderer.js"></script>
    <script class="include" type="text/javascript" src="../src/plugins/jqplot.canvasAxisLabelRenderer.js"></script>
    <script class="include" type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
    <script class="include" type="text/javascript" src="kcp.print.js"></script>

<!-- End additional plugins -->

<?php include "closer.php"; ?>