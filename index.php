<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch expenses for the logged-in user
$user_id = $_SESSION['user_id'];
$get_expenses_query = "SELECT * FROM expenses WHERE UserID='$user_id'";
$result = $conn->query($get_expenses_query);
$expenses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="signup.html">signup</a>
</header>
    <h1>Money Tracker</h1>
    <div class="input-section">
        <label for="category-select">Categrory</label>
         <select id ="category-select">
         <option value="College Fee">College Fee</option>
         <option value="Rent">Rent</option>
         <option value="Transport">Transport</option>
         <option value="Food">Food</option>
         <option value="Shopping">Shopping</option>
         <option value="Cool Drinks">Cool Drinks</option>
         
         </select>
         <label for="amount-input">Amount:</label>
          <input type="number" id="amount-input">
          <label for="data-input">Date:</label>
          <input type="date" id="date-input">
          <button id="add-btn">Add</button>
    </div>
    <div class="expenses-list">
        <h2>Expense List</h2>
        <table>
         <thead>
         
            <tr>
                <th>Categrory</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Delete</th>



            </tr>
         

         </thead>

<tbody id="expense-table-body">


</tbody>
<tfoot>
    <td>Total:</td>
    <td id="total-amount"></td>
    <td></td>
    <td></td>
</tfoot>
        </table>
    </div>
<script src="script.js"></script>

</body>
</html>