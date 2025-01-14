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

$t_sql = "SELECT COUNT(1) FROM appointments a 
          JOIN member_basic m ON a.member_id = m.member_id 
          JOIN courses c ON a.course_id = c.course_id
          JOIN coaches co ON c.coach_id = co.coach_id";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
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
                   ORDER BY c.course_date DESC, c.course_time DESC 
                   LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>


<div class="card">
    <div class="container">
        <div class="row mt-4">
            <div class="col">
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
            <h5 class="card-header">預約列表</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa-solid fa-trash"></i></th>
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
                                    <td>
                                        <a href="javascript:" onclick="deleteOne(event)">
                                            <i class="fa-solid fa-trash"></i>
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
                                        <?php else: ?>
                                            <span class="badge bg-label-danger me-1">狀態錯誤</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $r['created_at'] ?></td>
                                    <td>
                                        <a href="edit-appointment.php?id=<?= $r['appointment_id'] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
        <?php include __DIR__ . '/includes/html-script.php'; ?>
        <script>
            const deleteOne = e => {
                e.preventDefault();
                const tr = e.target.closest('tr');
                const [, td_id, td_name] = tr.querySelectorAll('td');
                const id = td_id.innerHTML;
                const name = td_name.innerHTML;
                if (confirm(`是否要刪除預約編號 ${id} 會員姓名為 ${name} 的資料?`)) {
                    location.href = `del-appointment.php?id=${id}`;
                }
            }
        </script>
        <?php include __DIR__ . '/includes/html-footer.php'; ?>