<!-- 讀取資料庫 -->
<?php 
require __DIR__ . '/includes/init.php';
$title = "登入";
$pageName = "login"; 
#TODO :判斷管理者登入，跳到首頁
?>
<!-- html開始 -->
<?php include __DIR__ . '/includes/html-header.php'; ?>
<style>
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 3rem;
            max-width: 400px;
        }
        .login-title {
            color:rgb(12, 13, 13);
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 600;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #e0e0e0;
        }
        .btn-login {
            background: linear-gradient(to right,rgb(67, 86, 252) 0%,rgb(106, 67, 247) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.8rem;
            width: 100%;
            color: white;
            font-weight: 500;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
<?php include __DIR__ . '/includes/html-sidebar-1.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <h2 class="login-title">管理員/教練登入</h2>
                    <form onsubmit="sendData(event)">
                        <div class="mb-3">
                            <label class="form-label">電子郵件</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="請輸入您的電子郵件" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">密碼</label>
                            <input type="password" class="form-control" id="password" 
                                   name="admin_password" placeholder="請輸入密碼" required>
                        </div>
                        <button type="submit" class="btn btn-login">登入系統</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">登入結果</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="alert alert-danger" role="alert">
            帳號或密碼錯誤
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
        </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<!-- 加入Ajax -->
<script>
    const emailField =document.querySelector('#email')
    const myModal = new bootstrap.Modal('#exampleModal')
    // email check
    function validateEmail(email) {
    // 使用 regular expression 檢查 email 格式正不正確
    const pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(email);
    }

    const sendData = e=>{
        e.preventDefault();//不要讓表單以傳統方式送出
        emailField.closest('.mb-3').classList.remove('error')


        let isPass = true //有沒有通過檢查，預設true
        //TODO: 資料欄位檢查
        if(!validateEmail(emailField.value)){
            isPass=false;
            emailField.nextElementSibling.innerHTML ='請填寫正確email'
            emailField.closest('.mb-3').classList.add('error')
        }

        
        if (isPass) {
        const fd = new FormData(document.forms[0]);

        fetch(`login-api.php`, {
            method: 'POST',
            body: fd
            }).then(r => r.json())
            .then(obj => {
            console.log(obj);
            
            if (!obj.success) {
                myModal.show(); // 呈現 modal
            }else{
                location.href="home-admin.php"
            }
            }).catch(console.warn);
        }
    }
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>

