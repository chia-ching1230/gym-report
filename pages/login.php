<!-- 讀取資料庫 -->
<?php 
require __DIR__ . '/includes/init.php';
$title = "登入";
$pageName = "login"; 
#TODO :判斷管理者登入，跳到首頁
?>
<!-- html開始 -->
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

    <div class="row  m-5 d-flex justify-content-center">
        <div class="col-4">
            <div class="card "style="height: 300px;" >
                <div class="card-body d-flex justify-content-center ">
                    <h5 class="card-title " >歡迎登入</h5>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card"style="height: 300px;" >
                <div class="card-body">
                    <h5 class="card-title">管理員/教練登入</h5>
                    <hr>
                    <form onsubmit="sendData(event)" >
                    <div class="mb-3">
                        <label for="email" class="form-label" required>電子郵件</label>
                        <input type="email" class="form-control" id="email" name="email" >
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">密碼</label>
                        <input type="text" class="form-control" id="password" name="member_password">
                        <div class="form-text"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">登入</button>
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
                location.href="index_.php"
            }
            }).catch(console.warn);
        }
    }
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>

