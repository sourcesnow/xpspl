<?php
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

function makeChart($name, $data) {
    $js_array = str_replace(" ", "", $name);
    echo sprintf('var %s = [["Time", "%s"]];'.PHP_EOL,
        $js_array, $name
    );
    push_to_array($data, $js_array);
    echo sprintf(
        'var %s_graph = google.visualization.arrayToDataTable(%s);'.PHP_EOL,
        $js_array, $js_array
    );
    echo sprintf(
        'var %s_chart = new google.visualization.LineChart(document.getElementById("%s"));'.PHP_EOL,
        $js_array, $js_array
    );
    echo sprintf(
        '%s_chart.draw(%s_graph, {title: "%s"});'.PHP_EOL,
        $js_array, $js_array, $name
    );
}
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart(){
    <?php
    foreach ($results as $_name => $_data) {
        makeChart($_name, $_data);
    }
    ?>
    }
    </script>
  </head>
  <body>
    <?php
    foreach ($results as $_name => $_data) {
        echo '<div id="'.str_replace(" ", "", $_name).'" style="width: 450px; height: 250px; float:left;"></div>';
    }
    ?>
  </body>
</html>