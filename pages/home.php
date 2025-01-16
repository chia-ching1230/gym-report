<?php require __DIR__ . '/includes/init.php';?>
<?php
$title ="GYM管系統";
$pageName="home";
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<style>
        body {
            background: #f8f9fa;
        }
        .dashboard-container {
            padding: 3rem 0;
        }
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
    </style>
<?php include __DIR__ . '/includes/html-sidebar-1.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<body>
    <div class="dashboard-container">
        <div class="container">
            <h1 class="text-center mb-5">GYM管系統</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-center">會員管理</h3>
                        <p class="text-center">輕鬆管理會員資料</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <h3 class="text-center">課程排程</h3>
                        <p class="text-center">靈活安排課程時間與教練配置</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3 class="text-center">商品租借</h3>
                        <p class="text-center">便捷的運動器材租借與管理系統</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>


<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<?php include __DIR__ . '/includes/html-footer.php'; ?>
