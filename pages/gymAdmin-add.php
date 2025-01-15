<?php require __DIR__ . '/includes/init.php'; ?>
<?php
$title = "新增管理員";
$pageName = "gymAdmin-add";
?>

<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>


<div class="col-xxl">
    <div class="card mb-6">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">新增管理員</h5>
            <small class="text-muted float-end"> <a href="./gymAdmin.php" class="nav-link">回到管理員列表</a>
            </small>
        </div>
        <div class="card-body">
            <form onsubmit="sendData(event)">
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">郵件</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="basic-default-email" placeholder="XXX@XX.XX" name="email" require>
                        <div id="emailError" class="color-danger my-2"></div>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-password">密碼</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="basic-default-password" placeholder="請輸入密碼，密碼須包含數字、大小英文字母及特殊字元!@#$%^&*" name="admin_password" require>
                        <div id="passwordError" class="color-danger my-2 "></div>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-confirm-password">確認密碼</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="basic-default-confirm-password" placeholder="請再次輸入密碼" name="confirm-password">
                        <div id="confirmPassError" class="color-danger my-2 "></div>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">名稱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name" placeholder="請輸入名稱" name="admin_name" require>
                        <div id="nameError" class="color-danger my-2"></div>
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="basic-default-code" name="admin_code">
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-role">權限</label>
                    <div class="col-sm-10 d-flex justify-content-start align-items-center">
                        <div class="form-check mb-0 col-lg-6 ">
                            <input type="radio" id="basic-default-radio-role-1" name="admin_role" value="1" class="form-check-input " checked />
                            <label class="form-check-label" for="basic-default-radio-role-1">超級管理員</label>
                        </div>
                        <div class="form-check  mb-0 col-lg-6">
                            <input type="radio" id="basic-default-radio-role-2" name="admin_role" value="2" class="form-check-input" />
                            <label class="form-check-label" for="basic-default-radio-role-2">檢視者</label>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary me-3">確定</button>
                    <button type="reset" class="btn btn-outline-secondary">重設</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>

<!-- modal success -->
<div class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true" id="success-modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel2">新增結果</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- alert -->
                <div class="alert alert-primary" role="alert">
                    成功!
                </div>
            </div>
            <div class="modal-footer">
                <a href="./gymAdmin.php" class="nav-link">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    const email = document.querySelector("#basic-default-email")
    const adminPass = document.querySelector("#basic-default-password")
    const adminConfirmPass = document.querySelector("#basic-default-confirm-password")
    const name = document.querySelector('#basic-default-name')
    const confirmPassError = document.querySelector("#confirmPassError")
    const passwordError = document.querySelector("#passwordError")

    const sendData = e => {
        e.preventDefault();
        email.classList.remove('btn-outline-danger')
        adminPass.classList.remove('btn-outline-danger')
        adminConfirmPass.classList.remove('btn-outline-danger')
        name.classList.remove("btn-outline-danger")

        function validateEmail(email) {
            const mailpattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return mailpattern.test(email)
        }

        function validatePassword(adminPass) {
            const passPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{6,30}$/;
            return passPattern.test(adminPass)
        }

        // function validateconfirmPassword(memberConfirmPass) {
        //     const passPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //     return passPattern.test(memberConfirmPass)
        // }



        let isPass = true

        if (!validateEmail(email.value)) {
            isPass = false;
            document.querySelector('#emailError').innerHTML = '請填寫正確email'
            email.classList.add('btn-outline-danger')
        }
        if (!validatePassword(adminPass.value)) {
            isPass = false;
            document.querySelector('#passwordError').innerHTML = '密碼格式錯誤，請重新輸入'
            adminPass.classList.add('btn-outline-danger')
        }

        if (adminPass.value !== adminConfirmPass.value) {
            isPass = false;
            confirmPassError.classList.add('text-danger').innerHTML = '密碼不一致'
            adminConfirmPass.classList.add('btn-outline-danger ')
        }
        if (name.value.length < 3) {
            isPass = false;
            document.querySelector('#nameError').innerHTML = '名字不能小於3個字'
            name.classList.add('btn-outline-danger')
        }



        if (isPass) {
            const fd = new FormData(document.forms[0]);
            const myModal = new bootstrap.Modal('#success-modal')
            fetch(`gymAdmin-add-api.php`, {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (!obj.success && obj.error) {
                        alert(obj.error)
                    }
                    if (obj.success) {
                        myModal.show()
                    }
                }).catch(console.warn);
        }
    }


    adminPass.addEventListener("blur", () => {
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{6,30}$/;
        const password = adminPass.value;
        if (!passwordPattern.test(password)) {
            passwordError.innerHTML = '密碼格式錯誤，請重新輸入'
            adminPass.classList.add('btn-outline-danger')
        } else {
            passwordError.innerHTML = ''
            adminPass.classList.remove('btn-outline-danger')
        }
    })
    adminConfirmPass.addEventListener("blur", () => {
        const password = adminPass.value;
        const confirmPassword = adminConfirmPass.value;
        if (password !== confirmPassword) {
            confirmPassError.innerHTML = '密碼不一致'
            adminConfirmPass.classList.add('btn-outline-danger')
        } else {
            confirmPassError.innerHTML = ''
            adminConfirmPass.classList.remove('btn-outline-danger')
        }
    })
</script>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<?php include __DIR__ . '/includes/html-footer.php'; ?>
</script>