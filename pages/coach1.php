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
    $where .= " AND (name LIKE $keyword_)";
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
      <h4 class="card-header">文章管理</h4>
    </div>
    <div class="col-2 card-header d-flex align-items-center justify-content-center">
      <a href="article-add.php" class="nav-link">
        <span class="d-none d-sm-block"> 
        <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增文章</span>
      </a>
    </div>
  </div>
    
  <div class="row">
      <!-- 分頁 -->
      <div class="col-lg-8 mx-5 ">
        <div class="demo-inline-spacing">
          <!-- Basic Pagination -->
          <nav aria-label="Page navigation ">
            <ul class="pagination">
              <li class="page-item first" <?=$page==1?'disabled':''?> >
                <a class="page-link" href="?page=1"><i class="tf-icon bx bx-chevrons-left bx-sm"></i></a>
              </li>
              <li class="page-item prev <?=$page==1?'disabled':''?>">
                <a class="page-link" href="?page=<?=$page-1?>">
                  <i class="tf-icon bx bx-chevron-left bx-sm"></i>
                </a>
              </li>

              <?php for($i = 1; $i <= $totalPages; $i++):
                  $qs = array_filter($_GET); 
                  $qs['page']= $i ?>
                <li class="page-item <?=$page == $i?'active':''?> ">
                  <a class="page-link" href="?<?=http_build_query($qs)?>"><?=$i?></a>
                </li>
              <?php endfor;?>

              <li class="page-item next <?=$page==$totalPages?'disabled':''?>" >
                <a class="page-link" href="?page=<?=$page+1?>"><i class="tf-icon bx bx-chevron-right bx-sm"></i></a>
              </li>
              <li class="page-item last" <?=$page==$totalPages?'disabled':''?>>
                <a class="page-link" href="?page=<?=$totalPages?>"><i class="tf-icon bx bx-chevrons-right bx-sm"></i></a>
              </li>
            </ul>
          </nav>
          <!--/ Basic Pagination -->
        </div>
      </div>
      <!-- 篩選按鈕 -->
      <div class="col-lg-1 d-flex align-items-center justify-content-end p-0">
        <div class="btn-group " role="group" aria-label="Basic example">
            <button type="button" class="btn btn-sm btn-outline-white p-0" id="filter-published"> 
              <span class="badge bg-label-primary  me-1 " data-status= 1>已發布</span>
            </button>
            <button type="button" class="btn btn-sm btn-outline-white p-0" id="filter-unpublished"> 
              <span class="badge bg-label-secondary me-1" data-status= 0 >未發布</span>
            </button>
            
        </div>
      </div>
      <!-- 搜尋 -->
      <div class="col-lg-2 me-5  d-flex align-items-center justify-content-end">
        <form class="d-flex  ">
            <div class="input-group">
                  <button class="input-group-text">
                    <i class="tf-icons bx bx-search"></i>
                  </button>
              <input type="search" class="form-control" placeholder="Search..." name="keyword" value="<?=empty($_GET['keyword'])?'':htmlentities($_GET['keyword'])?>">
            </div>
        </form>
      </div>
    </div>
    
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>標題</th>
          <th>內容</th>
          <th>作者</th>
          <th>創建時間</th>
          <th>更新時間</th>
          <th>發布狀態</th>
          <th>編輯</th>
          <th>刪除</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <?php foreach($rows as $v):?>
        <tr>
          <td><button type="button" class="btn rounded-pill btn-icon btn-outline-secondary" data-bs-toggle="modal"  data-bs-target="#exLargeModal"  data-article-id="<?=$v['article_id']?>" id="viewBtn">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button></td>
          <td title="<?=$v['article_id']?>"><?=$v['article_id']?></td>
          <td style="max-width: 120px" title="<?=$v['title']?>"><?=$v['title']?></td>
          <td style="max-width: 300px" title="<?=htmlentities($v['content'])?>">
            <?=htmlentities($v['content'])?></td>
          <td title="<?=$v['author_id']?>"><?=$v['author_id']?></td>
          <td style="max-width: 150px" title="<?=$v['created_at']?>"><?=$v['created_at']?></td>
          <td style="max-width: 150px" title="<?=$v['updated_at']?>"><?=$v['updated_at']?></td>
          <td>
            <?php if ($v['uploadStatus']== 1) :?>
              <span class="badge bg-label-primary  me-1">已發布</span>
            <?php elseif($v['uploadStatus']== 0):?>
              <span class="badge bg-label-secondary me-1">未發布</span>
            <?php else:?>
              <span class="badge bg-label-danger me-1">狀態錯誤</span>
            <?php endif; ?>
          </td>
          <td><a class="dropdown-item" href="article-edit.php?article_id=<?=$v['article_id']?>">
            <i class="bx bx-edit-alt me-1"></i></a>
          </td>
          <td><a class="dropdown-item"  href="javascript:" onclick="deleteOne(event)">
            <i class="bx bx-trash me-1"></i></a>
          </td>
        </tr>
        <?php endforeach;?>
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