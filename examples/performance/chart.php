<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var sig_inst = [['Time', 'Signals Installed']];
        var sig_emit = [['Time', 'Signals Emitted']];
        <?php
        $data = '';
        function push_to_array($array1, $js_array) {
            $times = [];
            foreach ($array1 as $_num => $_result) {
                $time = 0.0;
                foreach ($_result as $_time) {
                    $time = $time + $_time;
                }
                $average = round(count($_result) / $time, 5);
                echo sprintf('%s.push([%s, %s]);'.PHP_EOL,
                  $js_array, $_time, $_num
                );
            }
        }
        push_to_array($results['Signal Emit'], 'sig_emit');
        push_to_array($results['Signal Installation'], 'sig_inst');
        ?>
        var data_1 = google.visualization.arrayToDataTable(sig_emit);
        var data_2 = google.visualization.arrayToDataTable(sig_inst);
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data_1, {title: 'Signal Emit'});
        var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
        chart.draw(data_2, {title: 'Signal Install'});
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
    <div id="chart_div2" style="width: 900px; height: 500px;"></div>
  </body>
</html>