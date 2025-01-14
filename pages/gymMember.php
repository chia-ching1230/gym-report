<?php require __DIR__ . "/includes/init.php"; ?>
<?php
$title = "會員管理";
$pageName = "gymMember";

$perPage = 10;
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
if ($page < 1) {
    header("Location:gymMember.php");
    exit;
}


$t_sql = "SELECT count(*) FROM member_basic ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

if ($totalRows > 0) {
    $sql = sprintf("SELECT member_basic.*, member_auth.email
FROM member_basic LEFT JOIN member_auth ON member_basic.member_id =member_auth.member_id LIMIT %s,%s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
};

$totalPages = ceil($totalRows / $perPage);

?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<style>
    td {
        overflow: hidden;
        /* 隱藏超出內容 */
        text-overflow: ellipsis;
        /* 用省略號顯示溢出內容 */
        white-space: nowrap;
        /* 防止內容換行 */
    }
</style>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>
<div class="card">
    <div class="row">
        <div class="col-10">
            <h4 class="card-header">會員管理</h4>
        </div>
        <div class="col-2 card-header d-flex align-items-center justify-content-center">
            <a href="gymMember-add.php" class="nav-link">
                <span class="d-none d-sm-block">
                    <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增會員</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mx-5">
            <div class="demo-inline-spacing">
                <!-- Basic Pagination -->
                <nav aria-label="Page navigation ">
                    <ul class="pagination">
                        <li class="page-item first" <?= $page == 1 ? 'disabled' : '' ?>>
                            <a class="page-link" href="?page=1"><i class="tf-icon bx bx-chevrons-left bx-sm"></i></a>
                        </li>
                        <li class="page-item prev <?= $page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="tf-icon bx bx-chevron-left bx-sm"></i>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++):
                            $qs = array_filter($_GET);
                            $qs['page'] = $i ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?> ">
                                <a class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item next <?= $page == $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="tf-icon bx bx-chevron-right bx-sm"></i></a>
                        </li>
                        <li class="page-item last" <?= $page == $totalPages ? 'disabled' : '' ?>>
                            <a class="page-link" href="?page=<?= $totalPages ?>"><i class="tf-icon bx bx-chevrons-right bx-sm"></i></a>
                        </li>
                    </ul>
                </nav>
                <!--/ Basic Pagination -->
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>生日</th>
                    <th>email</th>
                    <th>電話</th>
                    <th>地址</th>
                    <th>創建時間</th>
                    <th>更新時間</th>
                    <th>編輯</th>
                    <th>刪除</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php foreach ($rows as $v): ?>
                    <tr>
                        <td><?= $v['member_id'] ?></td>
                        <td style="max-width: 120px" title="<?= $v['member_name'] ?>">
                            <?= $v['member_name'] ?>
                        </td>
                        <td style="max-width: 120px" title="<?= $v['birthday'] ?>">
                            <?= $v['birthday'] ?>
                        </td>
                        <td title="<?= htmlentities($v['email']) ?>">
                            <?= htmlentities($v['email']) ?>
                        </td>
                        <td style="max-width: 150px" title="<?= $v['phone'] ?>">
                            <?= $v['phone'] ?>
                        </td>
                        <td style="max-width: 200px" title="<?= htmlentities($v['address']) ?>">
                            <?= htmlentities($v['address']) ?>
                        </td>
                        <td style="max-width: 150px" title="<?= $v['created_at'] ?>">
                            <?= $v['created_at'] ?></td>
                        <td style="max-width: 150px" title="<?= $v['updated_at'] ?>">
                            <?= $v['updated_at'] ?>
                        </td>

                        <td><a class="dropdown-item" href="gymMember-edit.php?member_id=<?= $v['member_id'] ?>">
                                <i class="bx bx-edit-alt me-1"></i></a>
                        </td>
                        <td><a class="dropdown-item" href="javascript:" onclick="deleteOne(event)">
                                <i class="bx bx-trash me-1"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- modal delete -->
<div class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true" id="delete-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="modal-title" id="exampleModalLabel2">確定是否刪除</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal" id="yesgo">
                    <i class="fa-solid fa-circle-check me-3"></i>是
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymMember.php" class="nav-link">
                        <i class="fa-solid fa-circle-xmark me-3"></i>否</a>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
    const deleteOne = e => {
        e.preventDefault();
        const tr = e.target.closest('tr')
        const [td_member_id, td_member_name, ] = tr.querySelectorAll('td');
        const member_id = td_member_id.innerHTML
        const member_name = td_member_name.innerHTML

        const delModal = new bootstrap.Modal('#delete-modal')
        delModal.show()
        document.querySelector('#exampleModalLabel2').innerHTML = `是否要刪除編號為${member_id}，姓名為${member_name}的會員`
        document.querySelector('#yesgo').addEventListener('click', function() {
            location.href = `gymMember-del-api.php?member_id=${member_id}`
        })
    }
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>