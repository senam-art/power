<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();



require "../db/senam_config.php";
echo "Connected";

//Check if user is logged in
if(!isset($_SESSION['username'])){
    //redirect to login page
    header("Location: AdminLogin.php");
    exit();
}

//Fetch user data from session
$userName = $_SESSION['username'];

//Fetch Total sales 
$salesQuery = "SELECT SUM(Amount) AS total_sales FROM mimosami_sales";
$salesResult = $conn -> query($salesQuery);
$totalSales = $salesResult -> fetch_assoc()['total_sales'];

//Fetch total customers
$customerQuery = "SELECT COUNT(CustomerID) AS customer_count FROM mimosami_customer";
$customerResult = $conn -> query($customerQuery);
$customerCount = $customerResult -> fetch_assoc()['customer_count'];


?>

<!DOCTYPE html>
<html>
<head>
	<meta name='viewport' content="width=device-width inital-scale=1.0">
	<title>Dashboard</title>
	<link rel="icon" type="image/x-icon" href="xxx">
    <link rel="stylesheet" href="../assets/css/MimosamiStyle2.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body>

    <div class="grid-container-webpage-setup">
        
        <div class="item1">
            <div class="grid-container-2-columns">
                <div class="grid-item">
                    <h1 style="text-align:left">Dashboard</h1>
                    <p style="text-align:left">Welcome to your Dashboard!</p>
                </div>
                <div class="grid-item" style="text-align: right;">
                    <input type="text" placeholder="Search..">
                    <img src="../assets/images/profile.png" alt="Profile" style="width:100%;max-width:50px">
                </div>
            </div>
        </div>

        <div class="item2b">
            <img src="../assets/logo/MimosamiLogo.png" alt="MimosamiLogo" style="width:100%;max-width:100px">
        </div>

        <div class="item2">
            <div class="menu-container">
            <button class="menu selected">Sales</button><br>
            <button class="menu">Order</button><br>
            <button class="menu">Inventory</button>
            </div>
        </div>
 
        <div class="item3">
            <div class="grid-container-4-columns">
                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Sales</p>
                    <p style="font-weight:600;font-size:20px;color:#855363">GHC <?php echo number_format($totalSales,2);?></p>
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Total Customers</p>  
                    <p style="font-weight:600;font-size:20px;color:#855363">150</p>                  
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Monthly Sales</p>
                    <p style="font-weight:600;font-size:20px;color:#855363">GHC 500</p>                   
                </div>

                <div class="grid-item" id="card">
                    <p style="font-size:13px">Monthly Customers</p>  
                    <p style="font-weight:600;font-size:20px;color:#855363">50</p>                    
                </div>

            </div>

            <div class="grid-container-2-columns">
                <div class="grid-item"  id="card">
                    <h2>Monthly Sales</h2>
                    <canvas id="monthly-sales"></canvas>
                </div>

                <div class="grid-item"  id="card">
                    <h2>Top Sellers</h2>
                    <div style="background-color:#F1A1A5;border-radius:20px;padding:2px;margin:5px">
                        <p style="font-weight:500; color:#fdfdfd">1. Red Velvet Brownies</p>
                    </div>
                    <div style="background-color:#F1A1A5;border-radius:20px;padding:2px;margin:5px">
                        <p style="font-weight:500; color:#fdfdfd">1. Red Velvet Brownies</p>
                    </div>
                    <div style="background-color:#F1A1A5;border-radius:20px;padding:2px;margin:5px">
                        <p style="font-weight:500; color:#fdfdfd">1. Red Velvet Brownies</p>
                    </div>

                </div>
                
                <div class="grid-item"  id="card">
                    <h2>Sales by Product</h2>
                    <canvas id="product-sales"></canvas>
                </div>
                
                <div class="grid-item"  id="card">
                    <h2>Customers</h2>
                    <canvas id="customers"></canvas>
                </div> 
            </div>
        </div>  
        
        <div class="item4">
            <p></p>
        <div>

    </div>

</body>

<script>
    // Monthly Sales Bar Graph
    const monthlySalesCtx = document.getElementById('monthly-sales');
    const monthlySalesChart = new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: ['April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Monthly Sales',
                data: [50, 40, 20, 30],
                backgroundColor: '#855363',  
                borderColor: '#855363', 
                fill:false,    
            }]
        },

    });

    // Product Sales Bar Graph
    const productSalesCtx = document.getElementById('product-sales');
    const productSalesChart = new Chart(productSalesCtx, {
        type: 'bar',
        data: {
            labels: ['Cakes', 'Brownies', 'Cookies'], 
            datasets: [{
                label: 'Sales by Product',
                data: [50, 30, 80], 
                backgroundColor: ['#CFE6FC', '#F1A1A5', '#855363'], 
                borderColor: ['#CFE6FC', '#F1A1A5', '#855363'],
                borderWidth: 1
            }]
        },

    });

    // Customer Gender Pie Chart
    const customersCtx = document.getElementById('customers');
    const customersChart = new Chart(customersCtx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female', 'Other'],
            datasets: [{
                label: 'Customer Gender',
                data: [55, 35, 10], 
                backgroundColor: ['#CFE6FC', '#F1A1A5', '#855363'],
                hoverOffset: 4
            }]
        }
    });
</script>


</html>