<!DOCTYPE HTML>
  <html>
    <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="/Tools/CSS/Graf-uni.css">
      <script src="/Tools/JS/js-biblioteker/Jquery/jquery.js"></script>
      <script type="text/javascript">
            window.onload = function () {
              var dataTemp24timer = [];
              var dataFukt24timer = [];
              var dataTempTotalt = [];
              var dataFuktTotalt = [];
              var dataAVGtemp = [];
              var dataAVGfukt = [];
              var chart24timer = new CanvasJS.Chart("chartContainer24timer", {
                animationEnabled: true,
                theme: "light2",
                zoomEnabled: true,
                title: {
                  text: "Temperatur og Fuktighet på server rommet de siste 24 timene."
                },
                axisX:{
                  valueFormatString: "HH:mm",
                  crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                  }
                },
                axisY: {
                  title: "Grader og fuktighet i prosent",
                  crosshair: {
                    enabled: false
                  }
                },
                toolTip:{
                  shared:true
                },
                legend:{
                  cursor:"pointer",
                  verticalAlign: "bottom",
                  horizontalAlign: "left",
                  dockInsidePlotArea: true,
                  itemclick: toogleDataSeries
                },
                data: [{
                  type: "line",
                  showInLegend: true,
                  name: "Temperatur",
                  markerType: "square",
                  color: "#F08080",
                  yValueFormatString: "##.## °C",
                  xValueType: "dateTime",
      	          xValueFormatString: "D MMMM HH:mm",
                  dataPoints: dataTemp24timer
                  }, {
                   type: "line",
                   showInLegend: true,
                   name: "Fuktighet",
                   lineDashType: "dash",
                   color: "#00cc00",
                   yValueFormatString: "##,## %",
                   xValueType: "dateTime",
       	           xValueFormatString: "D MMMM HH:mm",
                   dataPoints: dataFukt24timer
                  }]
               });
               var chartTotalt = new CanvasJS.Chart("chartContainerTotalt", {
                animationEnabled: true,
                theme: "light2",
                zoomEnabled: true,
                title: {
                  text: "Temperatur og Fuktighet på server rommet totalt."
                },
                axisX:{
                  valueFormatString: "YYYY MMMM HH:mm",
                  crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                  }
                },
                axisY: {
                  title: "Grader og fuktighet i prosent",
                  crosshair: {
                    enabled: false
                  }
                },
                toolTip:{
                  shared:true
                },
                legend:{
                  cursor:"pointer",
                  verticalAlign: "bottom",
                  horizontalAlign: "left",
                  dockInsidePlotArea: true,
                  itemclick: toogleDataSeries
                },
                data: [{
                  type: "line",
                  showInLegend: true,
                  name: "Temperatur",
                  markerType: "square",
                  color: "#F08080",
                  yValueFormatString: "##.## °C",
                  xValueType: "dateTime",
      	          xValueFormatString: "YYYY D MMMM HH:mm",
                  dataPoints: dataTempTotalt
                  }, {
                   type: "line",
                   showInLegend: true,
                   name: "Fuktighet",
                   lineDashType: "dash",
                   color: "#00cc00",
                   yValueFormatString: "##,## %",
                   xValueType: "dateTime",
       	           xValueFormatString: "YYYY D MMMM HH:mm",
                   dataPoints: dataFuktTotalt
                  }]
               });
              'changeMeLink24hr'
              //$.getJSON("http://10.12.3.26/Tools/PHP/Scripts-PHP/php-graf-LMTS-0/read-and-convert-24hr.php", parseData24hr);
              //function parseData24hr(result) {
              //  for (var i = 0; i < result.length; i++) {
              //    dataTemp24timer.push({
              //      x: result[i].TidUNIX*1000,
              //      y: result[i].Temperatur
              //    });
              //    dataFukt24timer.push({
              //      x: result[i].TidUNIX*1000,
              //      y: result[i].Fuktighet
              //    });
              //  }
              //  chart24timer.render();
              //}
              //$.getJSON("http://10.12.3.26/Tools/PHP/Scripts-PHP/php-graf-LMTS-0/read-and-convert-totalt.php", parseDataTotalt);
              function parseDataTotalt(result) {
                for (var i = 0; i < result.length; i++) {
                  dataTempTotalt.push({
                    x: result[i].TidUNIX*1000,
                    y: result[i].Temperatur
                  });
                  dataFuktTotalt.push({
                    x: result[i].TidUNIX*1000,
                    y: result[i].Fuktighet
                  });
                }
                chartTotalt.render();
              }
              function toogleDataSeries(e) {
              if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
              }
              else{
                      e.dataSeries.visible = true;
              }
              chart24timer.render();
              chartTotalt.render();
            }
          };
      </script>
    </head>
    <body>
      <div id="top-nav">
        <?php include 'nav-bar-uni-test-2.php'; ?>
      </div>
      <div id="container">
        <div id="graf">
          <div id="chartContainer24timer"></div>
          <div id="chartContainerTotalt"></div>
        </div>
        <div class="csv-nedlast">
            <button id="myButton">Last ned i Excel format</button>
            <script type="text/javascript">
              const objectToCsv = function(data) {
                const csvRows = [];
                const headers = Object.keys(data[0]);
                csvRows.push(headers.join('      \;'));
                for(const row of data) {
                    const values = headers.map(header => {
                    const escaped = (''+row[header]).replace(/"/g, '\\"');
                    return `${escaped}\;`;
                    });
                  csvRows.push(values.join(''));
                }
                return csvRows.join('\n');
              };
              const download = function(csvData) {
                const blob = new Blob([csvData], { type: 'text/csv'});
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.setAttribute('hidden', '');
                a.setAttribute('href', url);
                a.setAttribute('download', 'Sensor-data.csv');
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
              };
              const getReport = async function() {
                'changeMeLinkCSV'

              function parseDataAVG(result) {
                var avgTemp = JSON.parse(JSON.stringify(result).split('"AVG(Temperatur)":').join('"Temperatur":'));
                var avgFukt = JSON.parse(JSON.stringify(result).split('"AVG(Fuktighet)":').join('"Fuktighet":'));
                for (var i = 0; i < avgTemp.length; i++) {
                  tempAVG.push(avgTemp[i].Temperatur);
                }
                for (var i = 0; i < avgFukt.length; i++) {
                  fuktAVG.push(avgFukt[i].Fuktighet);
                }
                var rundOppTemp = Math.round(tempAVG * 100) / 100;
                var rundOppFukt = Math.round(fuktAVG * 100) / 100;
                document.getElementById("tempAVG").innerHTML = rundOppTemp;
                document.getElementById("fuktAVG").innerHTML = rundOppFukt;
              };
            </script>
          </table>
        </div>
      </div>
      <script src="/Tools/JS/js-biblioteker/canvasJS/canvasjs.min.js"></script>
    </body>
  </html>
