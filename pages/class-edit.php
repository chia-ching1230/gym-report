<?php require __DIR__ . '/includes/init.php';
$title = "修改課程";
$pageName = "class-edit";

$course_id = empty($_GET['course_id']) ? 0 : intval($_GET['course_id']);

if (empty($course_id)) {
    header('Location: class.php');
    exit;
}
;

$sql = "SELECT * FROM courses WHERE course_id =$course_id";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    # 如果沒有對應的資料, 就跳走
    header('Location: class.php');
    exit;
}
;


?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="card mb-6">
    <h5 class="card-header">修改課程</h5>
    <div class="card-body">
        <form onsubmit="sendData(event)">
            <input type="hidden" name="course_id" value="<?= $r['course_id'] ?>">
            <div class="mb-4 row">
                <label for="name" class="col-md-2 col-form-label">編號</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" disabled value="<?= $r['course_id'] ?>">
                </div>
            </div>
            <div class="mb-4 row">
                <!-- 課程固定下拉式選單 -->
                <label for="course_name" class="col-md-2 col-form-label">課程名稱</label>
                <div class="col-md-10">
                    <input class="form-control" type="text" value="<?= $r['course_name'] ?>" id="course_name"
                        name="course_name">
                </div>
            </div>
            <div class="mb-4 row">
                <label for="course_description" class="col-md-2 col-form-label">課程描述</label>
                <div class="col-md-10">
                    <textarea class="form-control" id="course_description" name="course_description"
                        rows="3"><?= $r['course_description'] ?></textarea>
                </div>
            </div>
            <!-- 教練下拉式選單 -->
            <div class="mb-4 row">
                <label for="coach_id" class="col-md-2 col-form-label">教練姓名</label>
                <div class="col-md-10">
                    <?php
                    $sql = "SELECT coach_id, name FROM coaches WHERE status = 'active' ORDER BY name";
                    $coaches = $pdo->query($sql)->fetchAll();
                    ?>
                    <select class="form-control" id="coach_id" name="coach_id">
                        <?php foreach ($coaches as $coach): ?>
                            <option value="<?= $coach['coach_id'] ?>" <?= ($r['coach_id'] == $coach['coach_id']) ? 'selected' : '' ?>>
                                <?= htmlentities($coach['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mb-4 row">
                <label for="course_date" class="col-md-2 col-form-label">課程日期</label>
                <div class="col-md-10">
                    <input class="form-control" type="date" id="course_date" name="course_date"
                        value="<?= $r['course_date'] ?>">
                </div>
            </div>


            <div class="mb-4 row">
                <label for="course_time" class="col-md-2 col-form-label">課程時間</label>
                <div class="col-md-10">
                    <select class="form-control" id="course_time" name="course_time">
                        <?php
                        for ($hour = 9; $hour <= 20; $hour++) {
                            $time = sprintf("%02d:00", $hour);
                            echo "<option value=\"{$time}\">{$time}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn rounded-pill btn-primary float-end">修改</button>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">修改結果</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" role="alert">
                        課程修改成功
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" href="class.php">回到課程列表</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
    const myModal = new bootstrap.Modal('#exampleModal');
    const sendData = e => {
        e.preventDefault(); // 不要讓表單以傳統的方式送出
        const fd = new FormData(document.forms[0]);
        fetch(`class-edit-api.php`, {
            method: 'POST',
            body: fd
        }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    myModal.show(); // 呈現 modal
                } else {
                    alert('資料沒有修改')
                }
            })
    };
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>