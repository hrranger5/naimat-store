<?php
include 'db.php';
if(!isset($_SESSION['admin'])) {
    header('location:index.php');
    exit;
}

// Stats
$total_bills = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM bills"));
$total_amount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(total_amount) AS total FROM bills")
)['total'] ?? 0;

$today_bills = mysqli_num_rows(
    mysqli_query($conn, "SELECT id FROM bills WHERE DATE(created_at)=CURDATE()")
);

// Handle delete
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM bill_items WHERE bill_id=$id");
    mysqli_query($conn, "DELETE FROM bills WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ur" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ڈیش بورڈ | نعمت کریانہ سٹور</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    font-family:'Noto Nastaliq Urdu', serif;
    background:#f4f6fb;
}

/* Sidebar */
.sidebar{
    position:fixed;
    top:0;
    right:0;
    width:230px;
    height:100vh;
    background:linear-gradient(180deg,#4e54c8,#8f94fb);
    color:#fff;
    padding-top:20px;
}

.sidebar h4{
    text-align:center;
    margin-bottom:20px;
}

.sidebar a{
    color:#fff;
    text-decoration:none;
    padding:12px 20px;
    display:block;
    font-size:15px;
}

.sidebar a:hover,
.sidebar a.active{
    background:rgba(255,255,255,0.2);
}

/* Content */
.content{
    margin-right:230px;
    padding:25px;
}

.stat-card{
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    text-align:center;
}

.stat-card i{
    font-size:28px;
    color:#4e54c8;
}

.stat-number{
    font-size:26px;
    margin-top:10px;
    font-weight:bold;
}

.table thead{
    background:#4e54c8;
    color:#fff;
}

.table td, .table th{
    vertical-align:middle;
}

/* Responsive */
@media(max-width:768px){
    .sidebar{
        position:relative;
        width:100%;
        height:auto;
    }
    .content{
        margin-right:0;
    }
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>نعمت کریانہ سٹور</h4>

    <a href="dashboard.php" class="active">
        <i class="bi bi-speedometer2"></i> ڈیش بورڈ
    </a>

    <a href="bill.php">
        <i class="bi bi-receipt"></i> نیا بل بنائیں
    </a>

    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i> لاگ آؤٹ
    </a>
</div>

<!-- Main Content -->
<div class="content">

    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0">ڈیش بورڈ</h3>
        <span>خوش آمدید، <b><?=$_SESSION['admin']?></b></span>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-receipt"></i>
                <div class="stat-number"><?=$total_bills?></div>
                <div>کل بلز</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-cash-stack"></i>
                <div class="stat-number">Rs. <?=number_format($total_amount)?></div>
                <div>کل آمدنی</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-calendar-day"></i>
                <div class="stat-number"><?=$today_bills?></div>
                <div>آج کے بلز</div>
            </div>
        </div>
    </div>

    <!-- Bills Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">
                <i class="bi bi-list-ul"></i> تمام بلز
            </h5>

            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>بل نمبر</th>
                        <th>کسٹمر کا نام</th>
                        <th>کل رقم</th>
                        <th>تاریخ / وقت</th>
                        <th>تفصیل</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $q = mysqli_query($conn,"SELECT * FROM bills ORDER BY id DESC");
                while($r = mysqli_fetch_assoc($q)){
                    echo "<tr>
                        <td>{$r['bill_no']}</td>
                        <td>{$r['customer_name']}</td>
                        <td>Rs. ".number_format($r['total_amount'])."</td>
                        <td>{$r['created_at']}</td>
                        <td>
                            <a href='bill_view.php?id={$r['id']}' class='btn btn-sm btn-outline-primary'>
                                <i class='bi bi-eye'></i> دیکھیں
                            </a>
                            <a href='dashboard.php?delete={$r['id']}' class='btn btn-sm btn-outline-danger ms-1' onclick='return confirm(\"کیا آپ واقعی اس بل کو حذف کرنا چاہتے ہیں؟\")'>
                                <i class='bi bi-trash'></i> حذف کریں
                            </a>
                        </td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
