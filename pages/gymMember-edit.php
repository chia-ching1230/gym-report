<?php require __DIR__ . '/includes/init.php'; ?>
<?php
$title = "編輯會員";
$pageName = "gymMember-edit";
$member_id = empty($_GET['member_id']) ? 0 : intval($_GET['member_id']);

if (empty($member_id)) {
    header('Location: gymMember.php');
    exit;
}

$sql = "SELECT * FROM member_basic 
JOIN member_auth ON member_basic.member_id = member_auth.member_id 
JOIN member_profile ON member_basic.member_id = member_profile.member_id WHERE member_basic.member_id = $member_id";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: gymMember.php');
    exit;
}

?>

<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="col-xxl">
    <div class="card mb-6">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">編輯會員</h5>
            <small class="text-muted float-end"> <a href="./gymMember.php" class="nav-link">回到會員列表</a>
            </small>
        </div>
        <div class="card-body">
            <form onsubmit="sendData(event)">
                <input type="hidden" class="form-control" name="member_id" value="<?= $r['member_id'] ?>">
                <h6 class="mb-2">帳號</h6>

                <div class="container py-5 mb-6 border border-info-subtle rounded">
                    <div class="row ">
                        <label class="col-sm-2 col-form-label" for="basic-default-email">郵件</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="basic-default-email" placeholder="XXX@XX.XX" name="email" value="<?= $r['email'] ?>" disabled>
                        </div>
                    </div>
                </div>
                <h6 class="mb-2">基本資料</h6>
                <div class="container py-5 mb-6 border border-info-subtle rounded">
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="請輸入姓名" name="member_name" value="<?= $r['member_name'] ?>" require>
                            <div id="nameError" class="color-danger my-2"></div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-birth">生日</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="basic-default-birth" name="birthday" value="<?= $r['birthday'] ?>"
                                disabled
                                min="1945-01-01"
                                max="2017-12-31">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-gender">性別</label>
                        <div class="col-sm-10 ">
                            <div class="form-check mb-2 col-lg-6">
                                <input type="radio" id="basic-default-radio-male" name="gender" value="<?= $r['gender'] ?>"
                                    disabled
                                    class="form-check-input" checked />
                                <label class="form-check-label" for="basic-default-radio-male">Male</label>
                            </div>
                            <div class="form-check col-lg-6">
                                <input type="radio" id="basic-default-radio-female" name="gender" value="<?= $r['gender'] ?>"
                                    disabled
                                    class="form-check-input" />
                                <label class="form-check-label" for="basic-default-radio-female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-tel">聯絡電話</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control " id="basic-default-tel" name="phone" placeholder="0913426748" maxlength="10" value="<?= $r['phone'] ?>">
                            <div id="telError" class="color-danger my-2"></div>
                        </div>
                    </div>
                    <div class="row ">
                        <label class="col-sm-2 col-form-label" for="basic-default-address">地址</label>
                        <div class="col-sm-10">
                            <textarea id="basic-default-address" class="form-control" placeholder="xx市xx區xxx" aria-describedby="basic-icon-default-message2" rows="2" name="address"><?= $r['address'] ?></textarea>
                            <div id="addressError" class="color-danger my-2"></div>
                        </div>
                    </div>
                </div>
                <h6 class="mb-2">GYM身資料</h6>
                <div class="container py-5 mb-6 border border-info-subtle rounded">
                    <div class="row mb-6">
                        <label class="col-sm-2 col-form-label" for="basic-default-height">身高</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control " id="basic-default-height" name="height" value="<?= $r['height'] ?>">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-2 col-form-label" for="basic-default-weight">體重</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control " id="basic-default-weight" name="weight" value="<?= $r['weight'] ?>">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <?php
                        $fitness_goals = explode(",", str_replace(' ', '', $r['fitness_goals']));
                        ?>
                        <label class="col-sm-2 col-form-label" for="basic-default-goal">健身目標</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="增肌" name="fitness_goals[]" <?= in_array("增肌", $fitness_goals)? 'checked' : '' ?>>
                                <label class="form-check-label" for="inlineCheckbox1">增肌</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="減脂" name="fitness_goals[]" <?= in_array("減脂", $fitness_goals) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="inlineCheckbox2">減脂</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="提高耐力" name="fitness_goals[]"
                                    <?= in_array("提高耐力", $fitness_goals) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="inlineCheckbox3">提高耐力</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="增強體能" name="fitness_goals[]"
                                    <?= in_array("增強體能", $fitness_goals) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="inlineCheckbox4">增強體能</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="健康維持" name="fitness_goals[]"
                                    <?= in_array("健康維持", $fitness_goals) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="inlineCheckbox5">健康維持</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="提高核心能量" name="fitness_goals[]"
                                    <?= in_array("提高核心能量", $fitness_goals) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="inlineCheckbox6">提高核心能量</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-2 col-form-label" for="basic-default-bio">自我簡介</label>
                        <div class="col-sm-10">
                            <textarea id="basic-default-bio" class="form-control" placeholder="跑步和冥想是我的日常，享受健康的生活方式。" aria-label="跑步和冥想是我的日常，享受健康的生活方式。" aria-describedby="basic-icon-default-message2" rows="9" name="bio"><?= $r['bio'] ?></textarea>
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
                <h4 class="modal-title" id="exampleModalLabel2">編輯結果</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- alert -->
                <div class="alert alert-primary" role="alert">
                    成功!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymMember.php" class="nav-link">
                        <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- modal no-edit -->
<div class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true" id="no-edit-modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel2">編輯結果</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- alert -->
                <div class="alert alert-secondary" role="alert">
                    資料沒有修改!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymMember.php" class="nav-link">
                        <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
    const myModal = new bootstrap.Modal('#success-modal')
    const noEditModal = new bootstrap.Modal('#no-edit-modal')
    const email = document.querySelector("#basic-default-email")
    // const memberPass = document.querySelector("#basic-default-password")
    // const memberConfirmPass = document.querySelector("#basic-default-confirm-password")
    const name = document.querySelector('#basic-default-name')
    // const birth = document.querySelector("#basic-default-birth")

    const tel = document.querySelector("#basic-default-tel")
    const address = document.querySelector('#basic-default-address')

    const fitnessGaol = document.querySelectorAll('input[name="fitness_goals[]"]:checked')

    // const confirmPassError = document.querySelector("#confirmPassError");
    // const passwordError = document.querySelector("#passwordError")

    const content = document.querySelector('#basic-default-bio')
    const textCount = document.querySelector('#textCount')

    content.addEventListener('input', () => {
        textCount.innerHTML = `${content.value.length} 個字`;
    })



    const sendData = e => {
        e.preventDefault();
        email.classList.remove('btn-outline-danger')
        // memberPass.classList.remove('btn-outline-danger')
        // memberConfirmPass.classList.remove('btn-outline-danger')
        name.classList.remove("btn-outline-danger")
        tel.classList.remove("btn-outline-danger")
        address.classList.remove('btn-outline-danger')
        textCount.classList.remove('btn-outline-danger')


        let isPass = true

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
            fetch(`gymMember-edit-api.php`, {
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
                    } else {
                        noEditModal.show()
                    }
                }).catch(console.warn);
        }
    }
</script>

<?php include __DIR__ . '/includes/html-footer.php'; ?>