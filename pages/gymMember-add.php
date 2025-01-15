<?php require __DIR__ . '/includes/init.php'; ?>
<?php
$title = "新增會員";
$pageName = "gymMember-add";
?>

<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="col-xxl">
    <div class="card mb-6">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">新增會員</h5>
            <small class="text-muted float-end"> <a href="./gymMember.php" class="nav-link">回到會員列表</a>
            </small>
        </div>
        <div class="card-body">
            <form onsubmit="sendData(event)">
                <h6 class="mb-2">建立帳號</h6>
                <div class="container py-5 mb-6 border border-info-subtle rounded">
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
                            <input type="password" class="form-control" id="basic-default-password" placeholder="請輸入密碼，密碼須包含數字、大小英文字母及特殊字元!@#$%^&*" name="member_password" require>
                            <div id="passwordError" class="color-danger my-2 "></div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-confirm-password">確認密碼</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="basic-default-confirm-password" placeholder="請再次輸入密碼" name="confirm-password" >
                            <div id="confirmPassError" class="color-danger my-2 "></div>
                        </div>
                    </div>
                </div>
                <h6 class="mb-2">基本資料</h6>
                <div class="container py-5 mb-6 border border-info-subtle rounded">
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="請輸入姓名" name="member_name" require>
                            <div id="nameError" class="color-danger my-2"></div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-birth">生日</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="basic-default-birth" name="birthday" value="1995-01-01"
                                min="1945-01-01"
                                max="2017-12-31">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-gender">性別</label>
                        <div class="col-sm-10 ">
                            <div class="form-check mb-2 col-lg-6">
                                <input type="radio" id="basic-default-radio-male" name="gender" value="male" class="form-check-input"  checked />
                                <label class="form-check-label" for="basic-default-radio-male">Male</label>
                            </div>
                            <div class="form-check col-lg-6">
                                <input type="radio" id="basic-default-radio-female" name="gender" value="female" class="form-check-input"  />
                                <label class="form-check-label" for="basic-default-radio-female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-tel">聯絡電話</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control " id="basic-default-tel" name="phone" placeholder="0913426748" maxlength="10" require>
                            <div id="telError" class="color-danger my-2"></div>
                        </div>
                    </div>
                    <div class="row ">
                        <label class="col-sm-2 col-form-label" for="basic-default-address">地址</label>
                        <div class="col-sm-10">
                            <textarea id="basic-default-address" class="form-control" placeholder="xx市xx區xxx" aria-describedby="basic-icon-default-message2" rows="2" name="address"></textarea>
                            <div id="addressError" class="color-danger my-2"></div>
                        </div>
                    </div>
                </div>
                <h6 class="mb-2">GYM身資料</h6>
                <div class="container py-5 mb-6 border border-info-subtle rounded">
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-height">身高</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control " id="basic-default-height" name="height" value="167">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-2 col-form-label" for="basic-default-weight">體重</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control " id="basic-default-weight" name="weight" value="65" step="5">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-goal">健身目標</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="增肌" name="fitness_goals[]" checked>
                                <label class="form-check-label" for="inlineCheckbox1">增肌</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="減脂" name="fitness_goals[]" checked>
                                <label class="form-check-label" for="inlineCheckbox2">減脂</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="提高耐力" name="fitness_goals[]">
                                <label class="form-check-label" for="inlineCheckbox3">提高耐力</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="增強體能" name="fitness_goals[]">
                                <label class="form-check-label" for="inlineCheckbox4">增強體能</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="健康維持" name="fitness_goals[]">
                                <label class="form-check-label" for="inlineCheckbox5">健康維持</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="提高核心能量" name="fitness_goals[]">
                                <label class="form-check-label" for="inlineCheckbox6">提高核心能量</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-2 col-form-label" for="basic-default-bio">自我簡介</label>
                        <div class="col-sm-10">
                            <textarea id="basic-default-bio" class="form-control" placeholder="跑步和冥想是我的日常，享受健康的生活方式。" aria-label="跑步和冥想是我的日常，享受健康的生活方式。" aria-describedby="basic-icon-default-message2" rows="9" name="bio"></textarea>
                            <div id="contentError"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted float-end" id="textCount">0 個字</small>
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
                <a href="./gymMember.php" class="nav-link">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const email = document.querySelector("#basic-default-email")
    const memberPass = document.querySelector("#basic-default-password")
    const memberConfirmPass = document.querySelector("#basic-default-confirm-password")
    const name = document.querySelector('#basic-default-name')
    const birth = document.querySelector("#basic-default-birth")

    const tel = document.querySelector("#basic-default-tel")
    const address = document.querySelector('#basic-default-address')

    const fitnessGaol = document.querySelectorAll('input[name="fitness_goals[]"]:checked')

    const confirmPassError = document.querySelector("#confirmPassError");
    const passwordError = document.querySelector("#passwordError")

    const content = document.querySelector('#basic-default-bio')
    const textCount = document.querySelector('#textCount')

    content.addEventListener('input', () => {
        textCount.innerHTML = `${content.value.length} 個字`;
    })



    const sendData = e => {
        e.preventDefault();
        email.classList.remove('btn-outline-danger')
        memberPass.classList.remove('btn-outline-danger')
        memberConfirmPass.classList.remove('btn-outline-danger')
        name.classList.remove("btn-outline-danger")
        tel.classList.remove("btn-outline-danger")
        address.classList.remove('btn-outline-danger')
        textCount.classList.remove('btn-outline-danger')

        function validateEmail(email) {
            const mailpattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return mailpattern.test(email)
        }

        // function validatePassword(memberPass) {
        //     const passPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //     return passPattern.test(memberPass)
        // }

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
        // if (!validatePassword(memberPass.value)) {
        //     isPass = false;
        //     // document.querySelector('#passwordError').innerHTML = '密碼格式錯誤，請重新輸入'
        //     // email.classList.add('btn-outline-danger')
        // }
        // if (!validateconfirmPassword(memberConfirmPass.value)) {
        //     isPass = false;
        //     // document.querySelector('#passwordError').innerHTML = '密碼格式錯誤，請重新輸入'
        //     // email.classList.add('btn-outline-danger')
        // }

        if (name.value.length < 1) {
            isPass = false;
            document.querySelector('#nameError').innerHTML = '名字不能小於2個字'
            name.classList.add('btn-outline-danger')
        }
        if (address.value.length <= 10) {
            isPass = false;
            document.querySelector('#addressError').innerHTML = '地址不能小於10個字'
            address.classList.add('btn-outline-danger')
        }

        if (content.value.length <= 10) {
            isPass = false;
            document.querySelector('#contentError').innerHTML = '內文不能小於10個字'
            content.classList.add('btn-outline-danger')
        }
        if (fitnessGaol.length === 0) {
            isPass = false;
            alert('請選擇至少一個目標');
        }

        if (isPass) {
            const fd = new FormData(document.forms[0]);
            const myModal = new bootstrap.Modal('#success-modal')
            fetch(`gymMember-add-api.php`, {
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


    memberPass.addEventListener("blur", () => {
        const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W+).{6,30}$/;
        const password = memberPass.value;
        if (!passwordPattern.test(password)) {
            passwordError.innerHTML = '密碼格式錯誤，請重新輸入'
            memberPass.classList.add('btn-outline-danger')
        } else {
            passwordError.innerHTML = ''
            memberPass.classList.remove('btn-outline-danger')
        }
    })
    memberConfirmPass.addEventListener("blur", () => {
        const password = memberPass.value;
        const confirmPassword = memberConfirmPass.value;
        if (password !== confirmPassword) {
            confirmPassError.innerHTML = '密碼不一致'
            memberConfirmPass.classList.add('btn-outline-danger')
        } else {
            confirmPassError.innerHTML = ''
            memberConfirmPass.classList.remove('btn-outline-danger')
        }
    })
</script>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<?php include __DIR__ . '/includes/html-footer.php'; ?>