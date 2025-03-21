<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body>
    <div class="search-container">
        <h2>Tìm kiếm người dùng</h2>
        <form action="index.php" method="get">
            <div class="input-group">
                <input type="text" name="id" placeholder="Nhập ID người dùng" required>
            </div>
            <button type="submit" class="btn-search">Tìm Kiếm</button>
        </form>
        <?php
           session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit(); // Dừng chương trình ngay lập tức để tránh lỗi
}

       $host="localhost";
       $user="hado";
       $pass="hado167";
       $db="WEBSQL";

        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("<p class='error'>Kết nối thất bại: " . $conn->connect_error . "</p>");
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        
     // Kiểm tra nếu ID không phải số → chặn lỗi SQL Injection
     if (!is_numeric($id)) {
        echo "<p class='error'>ID không hợp lệ!</p>";
    } else {
        // Dùng Prepared Statements để bảo vệ chống SQL Injection
        $stmt = $conn->prepare("SELECT id, username FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<div class='result-container'>";
        if ($result->num_rows > 0) {
            echo "<h3>Kết quả:</h3>";
            while ($row = $result->fetch_assoc()) {
                echo "<p>ID: <b>" . htmlspecialchars($row["id"]) . "</b> - Username: <b>" . htmlspecialchars($row["username"]) . "</b></p>";
            }
        } else {
            echo "<p class='error'>Không tìm thấy người dùng!</p>";
        }
        echo "</div>";

        $stmt->close();
    }
          
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
