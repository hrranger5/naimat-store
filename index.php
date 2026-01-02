<?php
include 'db.php';
$error = "";

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['admin']    = $row['username'];
            $_SESSION['admin_id'] = $row['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "پاس ورڈ درست نہیں";
        }
    } else {
        $error = "یوزر نیم موجود نہیں";
    }
}
?>
<!DOCTYPE html>
<html lang="ur" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ایڈمن لاگ ان</title>

<link rel="stylesheet" href="assets/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body{
    background:linear-gradient(135deg,#4e54c8,#8f94fb);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Noto Nastaliq Urdu', serif;
}

.login-container{
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
    width:100%;
    max-width:360px;
    text-align:center;
}

.login-container h2{
    margin-bottom:8px;
}

.login-container p{
    color:#666;
    margin-bottom:20px;
}

.input-group{
    display:flex;
    align-items:center;
    border:1px solid #ccc;
    border-radius:6px;
    margin-bottom:15px;
    padding:8px;
}

.input-group i{
    color:#666;
    margin-left:8px;
}

.input-group input{
    border:none;
    outline:none;
    width:100%;
    font-size:14px;
    background:transparent;
}

button{
    width:100%;
    padding:10px;
    background:#4e54c8;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:15px;
}

button:hover{
    background:#3b3fc1;
}

.error{
    background:#ffd6d6;
    color:#a70000;
    padding:8px;
    margin-bottom:12px;
    border-radius:6px;
    font-size:14px;
}
</style>

</head>
<body>

<div class="login-container">
    <h2><i class="fas fa-store"></i> ایڈمن لاگ ان</h2>
    <p>نعمت کریانہ سٹور</p>

    <?php if($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off">

        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="یوزر نیم" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="پاس ورڈ" required>
        </div>

        <button name="login">
            <i class="fas fa-sign-in-alt"></i> لاگ ان کریں
        </button>

    </form>
</div>

</body>
</html>
