<?php
require __DIR__ . '/includes/init.php';
$title = "編輯預約";
$pageName = "appointmentClass-edit";

// 取得預約資料
$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$appointment_id) {
    header('Location: appointmentsClass.php');
    exit;
}

// 取得課程列表與教練資訊
$courses_sql = "SELECT c.course_id, c.course_name, c.course_date, c.course_time, 
                co.name as coach_name 
                FROM courses c
                JOIN coaches co ON c.coach_id = co.coach_id
                WHERE co.status = 'active'
                ORDER BY c.course_date DESC, c.course_time DESC";
$courses = $pdo->query($courses_sql)->fetchAll();

// 取得會員列表
$members_sql = "SELECT member_id, member_name FROM member_basic";
$members = $pdo->query($members_sql)->fetchAll();

// 取得當前預約資料
$sql = "SELECT a.*, m.member_name, c.course_name,
        c.course_date, c.course_time, co.name as coach_name
        FROM appointments a
        JOIN member_basic m ON a.member_id = m.member_id
        JOIN courses c ON a.course_id = c.course_id
        JOIN coaches co ON c.coach_id = co.coach_id
        WHERE a.appointment_id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$appointment_id]);
$row = $stmt->fetch();



if (empty($row)){
        header('Location: appointmentsClass.php');
        exit;
    }

?>

<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="container">
    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <h5 class="card-header">編輯預約</h5>
                <div class="card-body">
                    <form name="form1" method="post" onsubmit="sendData(event)">
                    <input type="hidden" class="form-control" name="appointment_id" value="<?=$row['appointment_id'] ?>" > 

                        <div class="mb-3">
                            <label for="member_id" class="form-label">會員名稱</label>
                            <select class="form-select" name="member_id" id="member_id" required>
                                <option value="">-- 請選擇會員 --</option>
                                <?php foreach ($members as $m): ?>
                                    <option value="<?= $m['member_id'] ?>" <?= $row['member_id'] == $m['member_id'] ? 'selected' : '' ?>>
                                        <?= htmlentities($m['member_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="course_id" class="form-label">課程選擇</label>
                            <select class="form-select" name="course_id" id="course_id" required>
                                <option value="">-- 請選擇課程時段 --</option>
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?= $c['course_id'] ?>" <?= $row['course_id'] == $c['course_id'] ? 'selected' : '' ?>>
                                        <?= htmlentities($c['course_name']) ?> -
                                        <?= htmlentities($c['coach_name']) ?> -
                                        <?= $c['course_date'] ?>
                                        <?= $c['course_time'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">預約狀態</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>審核中</option>
                                <option value="confirmed" <?= $row['status'] == 'confirmed' ? 'selected' : '' ?>>預約成功
                                </option>
                                <option value="cancelled" <?= $row['status'] == 'cancelled' ? 'selected' : '' ?>>已取消
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">修改預約</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">修改結果</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    預約修改成功
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                <a class="btn btn-primary" href="appointmentsClass.php">回到預約列表</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
    const myModal = new bootstrap.Modal('#exampleModal');

    function sendData(e) {
        e.preventDefault();

        const fd = new FormData(e.target);

        fetch('appointmentsClass-edit-api.php', {
            method: 'POST',
            body: fd
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    myModal.show();
                } else {
                    alert(data.error || '預約失敗')
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('系統錯誤，請稍後再試');
            });
    }
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>