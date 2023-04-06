<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pizza';

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from database
$sql = "SELECT topping, quantity FROM orders";
$result = mysqli_query($conn, $sql);

// Initialize an array to store the data
$data = array();

// Loop through data and add to array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array($row['topping'], (int) $row['quantity']);
}

// Close connection
mysqli_close($conn);
?>

<!-- HTML code for pie chart -->
<html>
<head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows(<?php echo json_encode($data); ?>);

            // Set chart options
            var options = {'title':'Pizza Orders by Topping',
                           'width':400,
                           'height':300};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
</body>
</html>
