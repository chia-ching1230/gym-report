<?php require __DIR__ . '/includes/init.php';?>
<?php
$title ="影片管理";
$pageName="videos";

$videos_id = empty($_GET['videos_id'])? 0 : intval($_GET['videos_id']);


$allsql="SELECT * FROM Videos WHERE videos_id = $videos_id";
$r = $pdo->query($allsql)->fetch();




$perPage = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: videos.php'); 
  exit; 
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$where =" WHERE 1 ";
if($keyword){
  $keyword_ = $pdo->quote("%{$keyword}%"); 
  $where .= " AND (title LIKE $keyword_ OR description LIKE $keyword_)";
}

$t_sql = "SELECT count(*) FROM Videos $where";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; 

$rows = []; # 設定預設值
// if ($totalRows > 0) {
//   if ($page > $totalPages) {
//     // ob_clean();
//     # 用戶要看的頁碼超出範圍, 跳到最後一頁
//     header('Location: ?page=' . $totalPages);
//     exit;
//   }}

if($totalRows>0){
  
  $sql = sprintf("SELECT * FROM `Videos` %s
  LIMIT %s, %s", $where,
  ($page -1) * $perPage,
  $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}

$totalPages = ceil($totalRows/$perPage);

$all_sql="SELECT * FROM Videos WHERE videos_id = $videos_id";
$r = $pdo->query($all_sql)->fetch();

?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<style>
  td {
    overflow: hidden; /* 隱藏超出內容 */
    text-overflow: ellipsis; /* 用省略號顯示溢出內容 */
    white-space: nowrap; /* 防止內容換行 */
  }
</style>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>
<div class="card">
  <div class="row">
    <div class="col-10">
      <h4 class="card-header">影片管理</h4>
    </div>
    <div class="col-2 card-header d-flex align-items-center justify-content-center">
      <a href="videos-add.php" class="nav-link">
        <span class="d-none d-sm-block"> 
        <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增影片</span>
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
      <!-- 搜尋 -->
      <div class="col-lg-3 me-5  d-flex align-items-center justify-content-end">
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
          <th>描述</th>
          <th>影片連結</th>
          <th>分類</th>
          <th>發布狀態</th>
          <th>編輯</th>
          <th>刪除</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <?php foreach($rows as $v):?>
        <tr>
          <td>
            <button type="button" class="btn rounded-pill btn-icon btn-outline-secondary" 
            data-bs-toggle="modal"  data-bs-target="#exLargeModal"  data-videos-id="<?=$v['videos_id']?>" id="viewBtn">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </td>
          <td title="<?=$v['videos_id']?>"><?=$v['videos_id']?></td>
          <td  title="<?=$v['title']?>"><?=$v['title']?></td>
          <td  title="<?=htmlentities($v['description'])?>">
            <?=htmlentities($v['description'])?></td>
          <td  title="<?=htmlentities($v['video_url'])?>">
            <?=htmlentities($v['video_url'])?></td>
          <td title="<?=htmlentities($v['category'])?>">
            <?=htmlentities($v['category'])?></td>
          <td>
            <?php if ($v['status']== 1) :?>
              <span class="badge bg-label-primary  me-1">已發布</span>
            <?php elseif($v['status']== 0):?>
              <span class="badge bg-label-secondary me-1">未發布</span>
            <?php else:?>
              <span class="badge bg-label-danger me-1">狀態錯誤</span>
            <?php endif; ?>
          </td>
          <td><a class="dropdown-item" href="videos-edit.php?videos_id=<?=$v['videos_id']?>">
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

<!-- modal -->
<div class="modal fade" id="exLargeModal" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">影片詳情</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-videos_id">影片ID</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-videos_id" name="videos_id" value="" disabled >
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-title">標題</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-title" placeholder="title" name="title" value="" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-description">影片描述</label>
                  <div class="col-sm-10">
                    <textarea id="basic-default-description" class="form-control" rows="5" name="description" disabled></textarea>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-video_url">影片網址</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-video_url"  name="video_url" value="" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-category">影片分類</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-category"  name="category" value="" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-status">發布狀態</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-status" name="status" value="" disabled>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<!-- modal delete -->
<div class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true" id="delete-modal">
    <div class="modal-dialog modal-lg" role="document" >
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./article.php" class="nav-link">
            <i class="fa-solid fa-circle-xmark me-3"></i>否</a>
            </button>
        </div>
    </div>
    </div>
</div>
<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>

<script>
    const viewButtons = document.querySelectorAll('#viewBtn');
  viewButtons.forEach(button => {
      button.addEventListener('click', function() {
          const videos_id = this.getAttribute('data-videos-id'); 
          fetch(`videos-details-api.php?videos_id=${videos_id}`)
              .then(r => r.json())
              .then(data => {
                  if (data.success) {
                      document.getElementById('basic-default-videos_id').value = data.Video.videos_id;
                      document.getElementById('basic-default-title').value = data.Video.title;
                      document.getElementById('basic-default-description').value = data.Video.description;
                      document.getElementById('basic-default-video_url').value = data.Video.video_url;
                      document.getElementById('basic-default-category').value = data.Video.category;
                      
                      document.getElementById('basic-default-status').value = (data.Video.status==1?'發布':'未發布');
                  } else {
                      alert(data.error || '無法加載影片內容');
                  }
              })
              .catch(error => {
                  console.warn;
                  alert('發生錯誤，請稍後再試');
              });
      });
  });

    const deleteOne = e=>{
        e.preventDefault();
        const tr = e.target.closest('tr')
        const [,td_videos_id,td_title,] = tr.querySelectorAll('td');
        const videoid = td_videos_id.innerHTML
        const title = td_title.innerHTML
        const delModal = new bootstrap.Modal('#delete-modal')
        delModal.show()
        document.querySelector('#exampleModalLabel2').innerHTML=`是否要刪除編號為${videoid}，標題為${title}的文章`
        document.querySelector('#yesgo').addEventListener('click',function(){
          location.href=`videos-del-api.php?videos_id=${videoid}`
        })
    }
    
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>