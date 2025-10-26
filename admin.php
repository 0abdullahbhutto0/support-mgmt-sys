<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Admin</title>
    <link rel='stylesheet' href='admin_styles.css'>
    <script src="https://kit.fontawesome.com/37d0d17982.js" crossorigin="anonymous"></script>
</head>

<body>

</body>

</html>

<?php
include("database.php");

function ticket_table($open_tickets)
{
    echo "<div class='ticket-container'><table>
            <tr>
                <th>
                    Ticket ID
                </th>
                <th>
                    Created By
                </th>
                <th>
                    Subject
                </th>
                <th>
                    Status
                </th>
                <th>
                    Created At
                </th>
                <th>
                    Updated At
                </th>
                <th>
                    Thread
                </th>
            </tr>
        
        ";
    foreach ($open_tickets as $row) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['username']}</td>";
        echo "<td>{$row['subject']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "<td>{$row['created_at']}</td>";
        echo "<td>{$row['updated_at']}</td>";
        echo "<td> <a href='thread.php?id={$row['id']}'>Open Thread</a></td>";
        echo "</tr>";
    }
    echo "</table></div>";
}

function ticket_info()
{
    include("database.php");
    $sql = "SELECT status FROM tickets";
    $result = mysqli_query($conn, $sql);
    $total_tickets = mysqli_num_rows($result);
    $num_sent = 0;
    $num_receive = 0;
    $num_inprog = 0;
    $num_resolved = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] == 'Sent') {
            $num_sent++;
        }
        if ($row['status'] == 'Received by Admin') {
            $num_receive++;
        }
        if ($row['status'] == 'In Progress') {
            $num_inprog++;
        }
        if ($row['status'] == 'Resolved') {
            $num_resolved++;
        }
    }
    echo
    "<div class='num-container'>
        <div style='background: #dbeafe; border-color: #93c5fd; color: #1e40af;'>
           Total Tickets: {$total_tickets}
        </div>
        <div style='background: #fef3c7; border-color: #fcd34d; color: #b45309;'>
            Pending: {$num_sent}
        </div>
        <div style='background: #cffafe; border-color: #67e8f9; color: #0e7490;'>
            Received: {$num_receive}
        </div>
        <div style='background: #e9d5ff; border-color: #c084fc; color: #7e22ce;'>
            In Progress: {$num_inprog}
        </div>
        <div style='background: #d1fae5; border-color: #6ee7b7; color: #047857;'>
            Resolved: {$num_resolved}
        </div>
    
    </div>";
}
if ($_SESSION['logged_in'] == 'true') {
    if ($_SESSION['role'] == 'admin') {
        echo "<nav>";
        echo "<h2>LiveSupport</h2>";
        echo "<h2>Hello Admin: {$_SESSION['name']}</h2>";
        echo "<form action='admin.php' method='post'>
            <input type='submit' name='logout' value='Logout'>
        </form>";
        echo "</nav>";
        echo "<h2 class='resolved-head'>Ticket Info</h2>";
        ticket_info();
        $sql = "SELECT t.*, u.name, u.username FROM tickets t INNER JOIN users u ON t.user_id = u.id";
        $result = mysqli_query($conn, $sql);
        $resolved_tickets = [];
        $open_tickets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['status'] == 'Resolved') {
                $resolved_tickets[] = $row;
            } else {
                $open_tickets[] = $row;
            }
        }

        if (isset($_POST['logout'])) {
            session_destroy();
            header("Location: index.php");
            exit();
        }

        echo
        "<form action='admin.php' method='post'>
            <div class='searchbar-container'>
                <input type='text' name='searchbar' placeholder='Search for tickets...'>
                <input type='submit' name='search' value='Search'>
            </div>
        </form>";
        if(count($open_tickets)==0){
            echo "<h2>You dont have any open tickets right now.</h2>";
        }else{
        if (isset($_POST['search'])) {
            if (!empty($_POST['searchbar'])) {
                $search_term = $_POST['searchbar'];
                $sql = "SELECT t.*, u.name, u.username FROM tickets t INNER JOIN users u ON t.user_id = u.id WHERE t.id LIKE '%{$search_term}%' OR u.name LIKE '%{$search_term}%' OR u.username LIKE '%{$search_term}%' OR t.subject LIKE '%{$search_term}%' OR t.status LIKE '%{$search_term}%'";
                $result = mysqli_query($conn, $sql);
                echo "<div class='ticket-container'><table>
                        <tr>
                            <th>
                                Ticket ID
                            </th>
                            <th>
                                Created By
                            </th>
                            <th>
                                Subject
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Created At
                            </th>
                            <th>
                                Updated At
                            </th>
                            <th>
                                Thread
                            </th>
                        </tr>
        
                ";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['subject']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>{$row['created_at']}</td>";
                    echo "<td>{$row['updated_at']}</td>";
                    echo "<td> <a href='thread.php?id={$row['id']}'>Open Thread</a></td>";
                    echo "</tr>";
                }
                echo "</table></div>";
            } else {
                ticket_table($open_tickets);
            }
        }
        if (!isset($_POST['search'])) {
            ticket_table($open_tickets);
        }
    }
        echo "
        <h2 class='resolved-head'>Resolved Tickets</h2>
         <div class='resolved-section'>

        ";
        foreach ($resolved_tickets as $row) {
            echo "
            <div class='resolved-card'>
                <h4> {$row['subject']}</h4>
                <p><strong>By:</strong>  {$row['username']}</p>
                <p><strong>Resolved:</strong> {$row['updated_at']}</p>
                <a href='thread.php?id={$row['id']}'>View Thread</a>
            </div>
                
                ";
        }
        echo "</div>";
    } else {
        echo "User doesnt have admin privileges";
        echo "<br><a href='user.php'>Go back to User Page</a>";
    }
} else {
    header("Location: index.php");
    exit();
}



?>