<?php require __DIR__ . '/includes/init.php'; ?>
<?php
$title = "編輯管理員";
$pageName = "gymAdmin-edit";
$admin_id = empty($_GET['admin_id']) ? 0 : intval($_GET['admin_id']);

if (empty($admin_id)) {
    header('Location: gymAdmin-detail.php');
    exit;
}

$sql = "SELECT * FROM gym_admin WHERE admin_id = $admin_id";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: gymAdmin-detail.php');
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
            <h5 class="mb-0">編輯管理員</h5>
            <small class="text-muted float-end"> <a href="./gymAdmin.php" class="nav-link">回到管理員列表</a>
            </small>
        </div>
        <div class="card-body">
            <form onsubmit="sendData(event)">
                <input type="hidden" class="form-control" name="admin_id" value="<?= $r['admin_id'] ?>">
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">郵件</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="basic-default-email" placeholder="XXX@XX.XX" name="email" value="<?= $r['email'] ?>" require>
                        <div id="emailError" class="color-danger my-2"></div>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">名稱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name" placeholder="請輸入名稱" name="admin_name" value="<?= $r['admin_name'] ?>" require>
                        <div id="nameError" class="color-danger my-2"></div>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-code">編號</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-code" name="admin_code"
                            value="<?= $r['admin_code'] ?>" disabled>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-role">權限</label>
                    <div class="col-sm-10 d-flex justify-content-start align-items-center">
                        <div class="form-check mb-0 col-lg-6 ">
                            <input type="radio" id="basic-default-radio-role-1" name="admin_role" value="1" class="form-check-input "
                                <?= ($r['admin_role'] == 1) ? 'checked' : ''; ?> />
                            <label class="form-check-label" for="basic-default-radio-role-1">超級管理員</label>
                        </div>
                        <div class="form-check  mb-0 col-lg-6">
                            <input type="radio" id="basic-default-radio-role-2" name="admin_role" value="2"
                                <?= ($r['admin_role'] ==  2) ? 'checked' : ''; ?>
                                class="form-check-input" />
                            <label class="form-check-label" for="basic-default-radio-role-2">檢視者</label>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary me-3">確定</button>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymAdmin.php" class="nav-link">
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymAdmin.php" class="nav-link">
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
    const name = document.querySelector('#basic-default-name')
    const sendData = e => {
        e.preventDefault();
        email.classList.remove('btn-outline-danger')
        name.classList.remove("btn-outline-danger")

        function validateEmail(email) {
            const mailpattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return mailpattern.test(email)
        }



        let isPass = true

        if (!validateEmail(email.value)) {
            isPass = false;
            document.querySelector('#emailError').innerHTML = '請填寫正確email'
            email.classList.add('btn-outline-danger')
        }

        if (name.value.length < 3) {
            isPass = false;
            document.querySelector('#nameError').innerHTML = '名字不能小於3個字'
            name.classList.add('btn-outline-danger')
        }



        if (isPass) {
            const fd = new FormData(document.forms[0]);
            fetch(`gymAdmin-edit-api.php`, {
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
<?php include __DIR__ . '/includes/html-script.php'; ?>
<?php include __DIR__ . '/includes/html-footer.php'; ?>
</script>