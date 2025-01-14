<?php
require __DIR__ . '/includes/init.php';
$title = "教練列表";
$pageName = "coach";
$perPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;



$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$where = " WHERE status = 'active' ";
if ($keyword) {
    $keyword_ = $pdo->quote("%{$keyword}%");
    $where .= " AND (name LIKE $keyword_ OR coach_number LIKE $keyword_)";
}

$t_sql = "SELECT COUNT(1) FROM coaches $where";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);
$rows = []; # 設定預設值

if ($totalRows > 0) {
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf("SELECT *
    FROM coaches
    %s
    ORDER BY coach_id
    LIMIT %s, %s", $where, ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}
?>

<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>



<!-- 教練列表 -->
<div class="card">
    <div class="row">
        <div class="col-10">
            <h4 class="card-header">教練列表</h4>
        </div>
        <div class="col-2 card-header d-flex align-items-center justify-content-center">
            <a href="coach-add.php" class="nav-link">
                <span class="d-none d-sm-block">
                    <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增教練</span>
            </a>
        </div>
    </div>
    <div class="row">
        <!-- 分頁 -->
        <div class="col-lg-8 mx-5 "> <div class="demo-inline-spacing">
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
        <div class="col-lg-3 me-5 d-flex align-items-center justify-content-end">
                <form class="d-flex" action="coach.php">
                    <div class="input-group">
                        <button type="submit" class="input-group-text">
                            <i class="tf-icons bx bx-search"></i>
                        </button>
                        <input type="search" class="form-control" placeholder="Search..." name="keyword"
                            value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>">
                        <?php if (!empty($_GET['keyword'])): ?>
                            <a href="coach.php" class="input-group-text" title="清除搜尋">
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
                    <th><i class="fa-solid fa-trash"></i></th>
                    <th>教練id</th>
                    <th>教練員工編號</th>
                    <th>教練姓名</th>
                    <th>教練專長</th>
                    <th>電子郵件</th>
                    <th>手機</th>
                    <th>教練大頭貼</th>
                    <th>教練簡介</th>
                    <th><i class="fa-solid fa-pen-to-square"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <tr>
                        <td>
                            <a href="javascript: void(0)" class="delete-btn" data-id="<?= $r['coach_id'] ?>">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                        <td><?= $r['coach_id'] ?></td>
                        <td><?= $r['coach_number'] ?></td>
                        <td><?= htmlentities($r['name']) ?></td>
                        <td><?= $r['specialty'] ?></td>
                        <td><?= $r['email'] ?></td>
                        <td><?= $r['phone'] ?></td>
                        <td><?= $r['profile_image'] ?></td>
                        <td><?= $r['bio'] ?></td>
                        <td>
                            <a href="coach-edit.php?coach_id=<?= $r['coach_id'] ?>">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- 確認 Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">確認更改教練狀態</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                確定要將此教練標記為離職狀態嗎？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-danger" id="confirmInactive">確定</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>

<script>
    const updateStatus = (coach_id) => {
        const fd = new FormData();
        fd.append('coach_id', coach_id);

        fetch('coach-update-status-api.php', {
            method: 'POST',
            body: fd
        })
            .then(r => r.json())
            .then(obj => {
                if (obj.success) {
                    location.reload();
                } else {
                    alert(obj.error || '狀態更新失敗');
                }
            });
    };

    // 當點擊刪除按鈕時
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const coach_id = this.dataset.id;
            const modal = new bootstrap.Modal('#confirmModal');
            modal.show();

            document.querySelector('#confirmInactive').onclick = () => {
                updateStatus(coach_id);
                modal.hide();
            };
        });
    });
</script>

<?php include __DIR__ . '/includes/html-footer.php'; ?>