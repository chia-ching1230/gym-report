<?php require __DIR__ . '/includes/init.php';
$title = "課程列表";
$pageName = "class";

$perPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$params = [];
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$where = "WHERE co.status = 'active'";

if (!empty($keyword)) {
    $where .= " AND (co.name LIKE :keyword OR c.course_name LIKE :keyword)";
    $params[':keyword'] = '%' . $keyword . '%';
}

$t_sql = "SELECT COUNT(1) FROM courses c JOIN coaches co ON c.coach_id = co.coach_id $where";
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

    $sql = sprintf("SELECT c.*, co.name AS coaches_name 
                   FROM courses c 
                   JOIN coaches co ON c.coach_id = co.coach_id 
                   $where 
                   ORDER BY c.course_id DESC 
                   LIMIT %s, %s", 
        ($page - 1) * $perPage, $perPage
    );
    
    $stmt = $pdo->prepare($sql);
    foreach($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $rows = $stmt->fetchAll();
}
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>


<div class="card">
  <div class="row">
    <div class="col-10">
      <h4 class="card-header">課程列表</h4>
    </div>
    <div class="col-2 card-header d-flex align-items-center justify-content-center">
      <a href="class-add.php" class="nav-link">
        <span class="d-none d-sm-block">
          <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增課程</span>
      </a>
    </div>
  </div>
  <div class="row">
    <!-- 分頁 -->
    <div class="col-lg-8 mx-5 ">
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
    <div class="col-lg-3 me-5 d-flex align-items-center justify-content-end">
      <form class="d-flex" action="class.php">
        <div class="input-group">
          <button type="submit" class="input-group-text">
            <i class="tf-icons bx bx-search"></i>
          </button>
          <input type="search" class="form-control" placeholder="Search..." name="keyword"
            value="<?= empty($_GET['keyword']) ? '' : htmlentities($_GET['keyword']) ?>">
          <?php if (!empty($_GET['keyword'])): ?>
            <a href="class.php" class="input-group-text" title="清除搜尋">
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
          <th>課程id</th>
          <th>課程名稱</th>
          <th>課程描述</th>
          <th>教練姓名</th>
          <th>課程日期</th>
          <th>課程時間</th>
          <th><i class="fa-solid fa-pen-to-square"></i></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><a href="javascript:" onclick="deleteOne(event)">
                <i class="fa-solid fa-trash"></i>
              </a></td>
            <td><?= $r['course_id'] ?></td>
            <td><?= htmlentities($r['course_name']) ?></td>
            <td><?= htmlentities($r['course_description']) ?></td>
            <td><?= $r['coaches_name'] ?></td>
            <td><?= $r['course_date'] ?></td>
            <td><?= $r['course_time'] ?></td>
            <td><a href="class-edit.php?course_id=<?= $r['course_id'] ?>">
                <i class="fa-solid fa-pen-to-square"></i>
              </a></td>


          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>



<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
  const deleteOne = e => {
    e.preventDefault(); // 沒有要連到某處
    const tr = e.target.closest('tr');
    const [, td_course_id, td_course_name] = tr.querySelectorAll('td');
    const course_id = td_course_id.innerHTML;
    const course_name = td_course_name.innerHTML;
    console.log([td_course_id.innerHTML, td_course_name.innerHTML]);
    if (confirm(`是否要刪除編號為 ${course_id} 課程名稱為 ${course_name} 的資料?`)) {
      // 使用 JS 做跳轉頁面
      location.href = `class-del.php?course_id=${course_id}`;
    }
  }

</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>