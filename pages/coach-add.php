<?php require __DIR__ . '/includes/init.php';
$title = "增加教練資料";
$pageName = "coach-add";

// 取得目前最大的教練編號
$sql = "SELECT MAX(CAST(SUBSTRING(coach_number, 2) AS UNSIGNED)) as max_num FROM coaches";
$result = $pdo->query($sql)->fetch();
$next_num = str_pad(($result['max_num'] + 1), 5, '0', STR_PAD_LEFT);
$next_number = 'C' . $next_num;

?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<style>
    form .mb-4 .form-text {
        display: none;
        /* color: red; */
    }

    form .mb-4.error input.form-control {
        border: 2px solid red;
    }

    form .mb-4.error .form-text {
        display: block;
        color: red;
    }
</style>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="card mb-6">
    <h5 class="card-header">新增教練資料</h5>
    <div class="card-body">
        <form onsubmit="sendData(event)">
            <div class="mb-4 row">
                <label for="name" class="col-md-2 col-form-label">教練姓名</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="name" name="name">
                    <div class="form-text"></div>
                </div>
            </div>
            <div class="mb-4 row">
                <label for="coach_number" class="col-md-2 col-form-label">教練員工編號</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="coach_number" name="coach_number" readonly>
                </div>
            </div>
            <div class="mb-4 row">
                <label for="specialty" class="col-md-2 col-form-label">教練專長</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="specialty" name="specialty">
                </div>
            </div>
            <div class="mb-4 row">
                <label for="email" class="col-md-2 col-form-label">電子郵件</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="email" name="email">
                    <div class="form-text"></div>
                </div>
            </div>
            <div class="mb-4 row">
                <label for="phone" class="col-md-2 col-form-label">手機</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="phone" name="phone">
                </div>
            </div>
            <div class="mb-4 row">
                <label for="profile_image" class="col-md-2 col-form-label">教練大頭貼</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="profile_image" name="profile_image">
                </div>
            </div>
            <div class="mb-4 row">
                <label for="bio" class="col-md-2 col-form-label">教練簡介</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" id="bio" name="bio">
                </div>
            </div>
            <button type="submit" class="btn rounded-pill btn-primary float-end">新增</button>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" role="alert">
                        教練資料新增成功
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                    <a class="btn btn-primary" href="coach.php">回到教練列表</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Email 重複提醒</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        此 Email 已經被註冊使用，請使用其他 Email！
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
    <script>
        const coachNumberField = document.querySelector('#coach_number');
        const nameField = document.querySelector('#name');
        const emailField = document.querySelector('#email');
        const myModal = new bootstrap.Modal('#exampleModal');

        function validateEmail(email) {
            // 使用 regular expression 檢查 email 格式正不正確
            const pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(email);
        }

        // 在頁面載入時設定教練編號
        document.addEventListener('DOMContentLoaded', function () {
            coachNumberField.value = '<?= $next_number ?>';
        });

        // 前端 JavaScript
        const sendData = e => {
            e.preventDefault();
            nameField.closest('.mb-4').classList.remove('error');
            emailField.closest('.mb-4').classList.remove('error');
            let isPass = true;

            if (nameField.value.length < 2) {
                isPass = false;
                nameField.nextElementSibling.innerHTML = "請填寫正確的姓名";
                nameField.closest('.mb-4').classList.add('error');
            }

            if (!validateEmail(emailField.value)) {
                isPass = false;
                emailField.nextElementSibling.innerHTML = "請填寫正確的 Email";
                emailField.closest('.mb-4').classList.add('error');
            }

            if (isPass) {
                const fd = new FormData(document.forms[0]);
                fetch('coach-add-api.php', {
                    method: 'POST',
                    body: fd
                })
                    .then(r => r.json())
                    // 修改 fetch 的 then 部分
                    .then(obj => {
                        console.log(obj);
                        if (obj.success) {
                            const successModal = new bootstrap.Modal('#exampleModal');
                            successModal.show();
                        } else {
                            if (obj.error === 'duplicate_email') {
                                emailField.closest('.mb-4').classList.add('error');
                                emailField.nextElementSibling.innerHTML = "此 Email 已被使用";
                                const emailModal = new bootstrap.Modal('#emailModal');
                                emailModal.show();
                            } else {
                                alert('資料新增失敗');
                            }
                        }
                    })
            };
        }
    </script>
    <?php include __DIR__ . '/includes/html-footer.php'; ?>