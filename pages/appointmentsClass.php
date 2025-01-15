<?php
require __DIR__ . '/includes/init.php';
$title = "預約列表";
$pageName = "appointmentsClass";
$perPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$params = [];
$where = " WHERE 1=1";
$status = isset($_GET['status']) ? $_GET['status'] : '';
if (!empty($status)) {
    $where .= " AND a.status = :status";
    $params[':status'] = $status;
}
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if (!empty($keyword)) {
    $where .= " AND (m.member_name LIKE :keyword 
                OR co.name LIKE :keyword 
                OR c.course_name LIKE :keyword)";
    $params[':keyword'] = '%' . $keyword . '%';
}

$t_sql = "SELECT COUNT(1) FROM appointments a
          JOIN member_basic m ON a.member_id = m.member_id
          JOIN courses c ON a.course_id = c.course_id
          JOIN coaches co ON c.coach_id = co.coach_id" . $where;

$stmt = $pdo->prepare($t_sql);
$stmt->execute($params);
$totalRows = $stmt->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);

$rows = [];
if ($totalRows > 0) {
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT a.*, m.member_name, c.course_name,
                   c.course_date, c.course_time, co.name as coach_name
                   FROM appointments a
                   JOIN member_basic m ON a.member_id = m.member_id
                   JOIN courses c ON a.course_id = c.course_id
                   JOIN coaches co ON c.coach_id = co.coach_id
                   %s
                   ORDER BY c.course_date DESC, c.course_time DESC
                   LIMIT %s, %s",
        $where,
        ($page - 1) * $perPage,
        $perPage
    );

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
}
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>


<div class="card">
    <div class="row">
        <div class="col-10">
            <h4 class="card-header">課程預約列表</h4>
        </div>
        <div class="col-2 card-header d-flex align-items-center justify-content-center">
            <a href="appointmentsClass-add.php" class="nav-link">
                <span class="d-none d-sm-block">
                    <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增預約</span>
            </a>
        </div>
    </div>
    <div class="row">
        <!-- 分頁 -->
        <div class="col-lg-7 mx-5 ">
            <button type="button" class="btn btn-sm btn-primary ms-2" onclick="batchConfirm()">
                全部預約確認
            </button>
            <button type="button" class="btn btn-sm btn-danger ms-2" onclick="batchCancel()">
                全部取消
            </button>
        </div>
        <!-- 篩選按鈕 -->
        <div class="col-lg-1 d-flex align-items-center justify-content-end p-0">
            <div class="btn-group " role="group" aria-label="Basic example">
                <button type="button" class="btn btn-sm btn-outline-white p-0" id="filter-published">
                    <span class="badge bg-label-primary  me-1 " data-status='confirmed'>預約成功</span>
                </button>
                <button type="button" class="btn btn-sm btn-outline-white p-0" id="filter-unpublished">
                    <span class="badge bg-label-secondary me-1" data-status='pending'>審核中</span>
                </button>

            </div>
        </div>
        <div class="col-lg-3 mb-2 d-flex align-items-center justify-content-end">
            <form class="d-flex" action="appointmentsClass.php">
                <div class="input-group">
                    <button type="submit" class="input-group-text">
                        <i class="tf-icons bx bx-search"></i>
                    </button>
                    <input type="search" class="form-control" placeholder="Search..." name="keyword"
                        value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>">
                    <?php if (!empty($_GET['keyword'])): ?>
                        <a href="appointmentsClass.php" class="input-group-text" title="清除搜尋">
                            <i class="tf-icons bx bx-x"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" class="form-check-input" id="selectAll"></th>
                    <!-- 其他欄位 -->
                    <th><i class="fa-solid fa-ban"></i></th>
                    <th>預約編號</th>
                    <th>會員姓名</th>
                    <th>課程名稱</th>
                    <th>教練姓名</th>
                    <th>課程日期</th>
                    <th>課程時間</th>
                    <th>預約狀態</th>
                    <th>建立時間</th>
                    <th><i class="fa-solid fa-pen-to-square"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><input type="checkbox" class="form-check-input row-checkbox"
                                value="<?= $r['appointment_id'] ?>"></td>
                        <td>
                            <a href="javascript:" onclick="cancelAppointment(event)">
                                <i class="fa-solid fa-ban"></i>
                            </a>
                        </td>
                        <td><?= $r['appointment_id'] ?></td>
                        <td><?= htmlentities($r['member_name']) ?></td>
                        <td><?= htmlentities($r['course_name']) ?></td>
                        <td><?= htmlentities($r['coach_name']) ?></td>
                        <td><?= $r['course_date'] ?></td>
                        <td><?= $r['course_time'] ?></td>
                        <td>
                            <?php if ($r['status'] == 'pending'): ?>
                                <span class="badge bg-label-secondary  me-1">審核中</span>
                            <?php elseif ($r['status'] == 'confirmed'): ?>
                                <span class="badge bg-label-primary me-1">預約成功</span>
                            <?php elseif ($r['status'] == 'cancelled'): ?>
                                <span class="badge bg-label-danger me-1">已取消</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $r['created_at'] ?></td>
                        <td>
                            <a href="appointmentsClass-edit.php?id=<?= $r['appointment_id'] ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="col-lg-7 mx-5 ">
            <div class="demo-inline-spacing">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=1">
                                <i class="fa-solid fa-angles-left"></i>
                            </a>
                        </li>
                        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </li>

                        <?php for ($i = $page - 5; $i <= $page + 5; $i++):
                            if ($i >= 1 and $i <= $totalPages):
                                ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endif;
                        endfor; ?>

                        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>">
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $totalPages ?>">
                                <i class="fa-solid fa-angles-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
    </div>
</div>


<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
    // 確保 DOM 完全載入後再綁定事件
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('#filter-published').addEventListener('click', function () {
            toggleFilter("confirmed");
        });

        document.querySelector('#filter-unpublished').addEventListener('click', function () {
            toggleFilter("pending");
        });
    });
    function toggleFilter(status) {
        try {
            const searchParams = new URLSearchParams(window.location.search);
            if (searchParams.get('status') === String(status)) {
                searchParams.delete('status');
            } else {
                searchParams.set('status', status);
            }
            window.location.search = searchParams.toString();
        } catch (error) {
            console.error('切換狀態時發生錯誤:', error);
        }
    }
    const cancelAppointment = e => {
        e.preventDefault();
        const tr = e.target.closest('tr');
        const [, td_id, td_name] = tr.querySelectorAll('td');
        const id = td_id.innerHTML;
        const name = td_name.innerHTML;

        if (confirm(`是否要取消預約編號 ${id} 會員姓名為 ${name} 的預約?`)) {
            location.href = `appointmentsClass-update-status.php?id=${id}&status=cancelled`;
        }
    }
    // 全選功能
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // 批量確認
    function batchConfirm() {
        batchUpdateStatus('confirmed');
    }

    // 批量取消
    function batchCancel() {
        batchUpdateStatus('cancelled');
    }

    // 批量更新狀態
    function batchUpdateStatus(status) {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const ids = Array.from(checkboxes).map(cb => cb.value);

        if (ids.length === 0) {
            alert('請先選擇預約項目');
            return;
        }

        if (confirm(`確定要全部${status === 'confirmed' ? '確認' : '取消'}選取的 ${ids.length} 筆預約嗎？`)) {
            location.href = `appointmentsClass-batch-update-status.php?ids=${ids.join(',')}&status=${status}`;
        }
    }
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>