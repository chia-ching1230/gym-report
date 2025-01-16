<?php require __DIR__ . '/includes/init.php'; ?>
<?php
$title = "編輯管理員";
$pageName = "gymAdmin-edit";
$admin_id = empty($_GET['admin_id']) ? 0 : intval($_GET['admin_id']);

if (empty($admin_id)) {
    header('Location: gymAdmin.php');
    exit;
}

$sql = "SELECT * FROM gym_admin WHERE admin_id = $admin_id";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: gymAdmin.php');
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
            <h5 class="mb-0">管理員-<?= $r['admin_name'] ?></h5>
            <button class="btn btn-primary me-3"><a href="./gymAdmin-edit.php?admin_id=<?= $r['admin_id'] ?>" class="nav-link"><i class="bx bx-edit-alt me-1"></i></a></button>
        </div>
        <div class="card-body">
            <form">
                <input type="hidden" class="form-control" name="admin_id" value="<?= $r['admin_id'] ?>">
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">郵件</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="basic-default-email" placeholder="XXX@XX.XX" name="email" value="<?= $r['email'] ?>" disabled>
                        <div id="emailError" class="color-danger my-2"></div>
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">名稱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="basic-default-name" placeholder="請輸入名稱" name="admin_name" value="<?= $r['admin_name'] ?>" disabled>
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
                                <?= ($r['admin_role'] == 1) ? 'checked' : ''; ?> disabled />
                            <label class="form-check-label" for="basic-default-radio-role-1">超級管理員</label>
                        </div>
                        <div class="form-check  mb-0 col-lg-6">
                            <input type="radio" id="basic-default-radio-role-2" name="admin_role" value="2"
                                <?= ($r['admin_role'] ==  2) ? 'checked' : ''; ?>
                                class="form-check-input" disabled />
                            <label class="form-check-label" for="basic-default-radio-role-2">檢視者</label>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <button class="btn btn-primary"><a href="./gymAdmin.php" class="nav-link">回到管理員列表</a></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>


<?php include __DIR__ . '/includes/html-script.php'; ?>
<?php include __DIR__ . '/includes/html-footer.php'; ?>
</script>