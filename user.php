<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport</title>
    <link rel='stylesheet' href='layout.css'>
    <script
      src="https://kit.fontawesome.com/37d0d17982.js"
      crossorigin="anonymous"
    ></script>
</head>

<body>

</body>

</html>

<?php
session_start();
include("database.php");
function ticket_table($open_tickets)
{
    echo "<div class='ticket-container'><table>
            <tr>
                <th>
                    Ticket ID
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
        echo "<td>{$row['subject']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "<td>{$row['created_at']}</td>";
        echo "<td>{$row['updated_at']}</td>";
        echo "<td> <a href='thread.php?id={$row['id']}'>Open Thread</a></td>";
        echo "</tr>";
    }
    echo "</table></div>";
}

if ($_SESSION['logged_in'] == true) {
    if ($_SESSION['role'] == 'user') {
        $name = $_SESSION['name'];
        $id = $_SESSION['id'];
        echo "<nav>";
        echo "<h2><i class='fa-solid fa-headset'></i>LiveSupport</h2>";
        echo "<h2>Hello, {$name}</h2>";
        echo "<form action='user.php' method='post'>
            <input type='submit' name='logout' value='Logout'>
        </form>";
        echo "</nav>";
        echo "<h3 class='resolved-head'>Facing an issue? Create a Ticket!</h3>";
        echo
        "
        <div class='createticket-container'>
            <form action 'user.php' method='post'>
                <label>Title</label>
                <input type='text' name='subject' placeholder='Enter a subject for the Ticket'><br>
                <label>Description</label><br>
                <textarea name='description' placeholder='Describe your problem'></textarea><br>
                <input type='submit' name='create'>
            </form>
        </div>
        ";
        if (isset($_POST['logout'])) {
            session_destroy();
            header("Location: index.php");
            exit();
        }
        if (isset($_POST['create'])) {
            $subject=mysqli_real_escape_string($conn, $_POST['subject'] );
            $desc=mysqli_real_escape_string($conn,$_POST['description'] );
            if (!empty(trim($subject)) || !empty(trim($desc))) {
                $sql = "INSERT INTO tickets(user_id, subject, description, status) VALUES ('$id', '{$subject}', '{$desc}', 'Sent')";
                mysqli_query($conn, $sql);
                echo "<h2 class='resolved-head'>Ticket Posted!</h2>";
            } else {
                echo "<h2 class='resolved-head'>Please enter all the details!</h2>";
            }
        }
        $sql = "SELECT * FROM tickets WHERE user_id = $id";
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
        echo "<h2 class='resolved-head'>Your Open Tickets</h2>";
        echo
        "<form action='user.php' method='post'>
            <div class='searchbar-container'>
                <input type='text' name='searchbar' placeholder='Search for tickets...'>
                <input type='submit' name='search' value='Search'>
            </div>
        </form>";
        if (count($open_tickets) == 0) {
            echo "<h2 class='resolved-head'>You dont have any open tickets right now.</h2>";
        } else {
            if (isset($_POST['search'])) {
                if (!empty($_POST['searchbar'])) {
                    $search_term = $_POST['searchbar'];
                    $sql = "SELECT * FROM tickets WHERE user_id = $id AND (subject LIKE '%{$search_term}%' OR id LIKE '%{$search_term}%' OR description LIKE '%{$search_term}%' OR status LIKE '%{$search_term}%')";
                    $result = mysqli_query($conn, $sql);
                    echo "<div class='ticket-container'><table>
                        <tr>
                            <th>
                                Ticket ID
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
        if (count($resolved_tickets) == 0) {
            echo "<h2 class='resolved-head'>You dont have any resolved tickets right now.</h2>";
        } else {
            echo "
        <h2 class='resolved-head'>Resolved Tickets</h2>
         <div class='resolved-section'>

        ";
            foreach ($resolved_tickets as $row) {
                echo "
            <div class='resolved-card'>
                <h4> {$row['subject']}</h4>
                <p><strong>Resolved:</strong> {$row['updated_at']}</p>
                <a href='thread.php?id={$row['id']}'>View Thread</a>
            </div>
                
                ";
            }
            echo "</div>";
        }
    }
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}


?>