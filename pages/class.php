<?php require __DIR__ . '/includes/init.php';
$title = "課程列表";
$pageName = "class";

$perPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}
$where = ' WHERE 1 ';

$t_sql = "SELECT COUNT(1) FROM courses c 
JOIN coaches co ON c.coach_id = co.coach_id 
WHERE co.status = 'active'";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
# 總頁數
$totalPages = ceil($totalRows / $perPage);
$rows = []; # 設定預設值
if ($totalRows > 0) {
  if ($page > $totalPages) {
    # 用戶要看的頁碼超出範圍, 跳到最後一頁
    header('Location: ?page=' . $totalPages);
    exit;
  }

  # 取第一頁的資料
  $sql = sprintf("SELECT courses.*, coaches.name AS coaches_name
FROM courses
JOIN coaches ON courses.coach_id = coaches.coach_id
WHERE coaches.status = 'active'
ORDER BY course_id
LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
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
      <h5 class="card-header">課程列表</h5>
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