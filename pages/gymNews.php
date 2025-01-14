<?php require __DIR__ . '/includes/init.php';?>
<?php
$title ="最新消息管理";
$pageName="gymNews";

$news_id = empty($_GET['news_id'])? 0 : intval($_GET['news_id']);

$allsql="SELECT * FROM gym_news WHERE news_id = $news_id";
$r = $pdo->query($allsql)->fetch();

$perPage = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: gymNews.php'); 
  exit; 
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$status = isset($_GET['status']) ? intval($_GET['status']) :null;

$where =" WHERE 1 ";
if($keyword){
  $keyword_ = $pdo->quote("%{$keyword}%"); 
  echo $keyword_;
  $where .= " AND (title LIKE $keyword_ OR content LIKE $keyword_)";
}
if ($status !== null) {
  $where .= " AND uploadStatus = $status"; 
}

$t_sql = "SELECT count(*) FROM gym_news $where";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; 


if($totalRows>0){

  $sql = sprintf("SELECT * FROM `gym_news` %s
  LIMIT %s, %s", $where,
  ($page -1) * $perPage,
  $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}

$totalPages = ceil($totalRows/$perPage);

$all_sql="SELECT * FROM gym_news WHERE news_id = $news_id";
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
      <h4 class="card-header">最新消息</h4>
    </div>
    <div class="col-2 card-header d-flex align-items-center justify-content-center">
      <a href="gymNews-add.php" class="nav-link">
        <span class="d-none d-sm-block"> 
        <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增最新消息</span>
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
  <?php if($totalRows>0):?> 
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>標題</th>
          <th>內容</th>
          <th>發布者</th>
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
          <td><button type="button" class="btn rounded-pill btn-icon btn-outline-secondary" data-bs-toggle="modal"  data-bs-target="#exLargeModal"  data-news-id="<?=$v['news_id']?>" id="viewBtn">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button></td>
          <td title="<?=$v['news_id']?>"><?=$v['news_id']?></td>
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
          <td><a class="dropdown-item" href="gymNews-edit.php?news_id=<?=$v['news_id']?>">
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
  <?php endif?>
</div>

<!-- modal -->
<div class="modal fade" id="exLargeModal" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">最新消息詳情</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-news_id">文章ID</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-news_id" name="news_id" disabled >
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-title">標題</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-title" placeholder="title" name="title" value="請輸入標題" disabled>
                    <div id="titleError" class="color-danger my-2"></div>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-author">發布者</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-author" name="author_id" placeholder="請輸入工號"   value="" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-content">最新消息內容</label>
                  <div class="col-sm-10">
                    <textarea id="basic-default-content" class="form-control" rows="5" name="content" disabled></textarea>
                    <div id="contentError"></div>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-uploadStatus">發布狀態</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-uploadStatus" name="uploadStatus" value="" disabled>
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymNews.php" class="nav-link">
            <i class="fa-solid fa-circle-xmark me-3"></i>否</a>
            </button>
        </div>
    </div>
    </div>
</div>
<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>

<script>
  // 篩選條件
  document.querySelector('#filter-published').addEventListener('click', function() {
      toggleFilter(1); 
  });
  document.querySelector('#filter-unpublished').addEventListener('click', function() {
      toggleFilter(0);
  });
  function toggleFilter(status) {
      const searchParams = new URLSearchParams(location.search);
      if (searchParams.get('status') === String(status)) {
          searchParams.delete('status'); 
      } else {
          searchParams.set('status', status); 
      }
      window.location.search = searchParams.toString();
  }
  // 詳情檢視
  const viewButtons = document.querySelectorAll('#viewBtn');
  viewButtons.forEach(button => {
      button.addEventListener('click', function() {
          const news_id = this.getAttribute('data-news-id'); 
          console.log(news_id);
          
          fetch(`gymNews-details-api.php?news_id=${news_id}`)
              .then(r => r.json())
              .then(data => {
                  if (data.success) {
                      document.getElementById('basic-default-news_id').value = data.gymNews.news_id;
                      document.getElementById('basic-default-title').value = data.gymNews.title;
                      document.getElementById('basic-default-author').value = data.gymNews.author_id;
                      document.getElementById('basic-default-content').value = data.gymNews.content;
                      
                      document.getElementById('basic-default-uploadStatus').value = (data.gymNews.uploadStatus==1?'發布':'未發布');
                  } else {
                      alert(data.error || '無法加載文章');
                  }
              })
              .catch(error => {
                  console.warn;
                  alert('發生錯誤，請稍後再試');
              });
      });
  });
    // 刪除事件
    const deleteOne = e=>{
        e.preventDefault();
        const tr = e.target.closest('tr')
        const [,td_news_id,td_title,] = tr.querySelectorAll('td');
        const newsid = td_news_id.innerHTML
        const title = td_title.innerHTML
        const delModal = new bootstrap.Modal('#delete-modal')
        delModal.show()
        document.querySelector('#exampleModalLabel2').innerHTML=`是否要刪除編號為${newsid}，標題為${title}的最新消息`
        document.querySelector('#yesgo').addEventListener('click',function(){
          location.href=`gymNews-del-api.php?news_id=${newsid}`
        })
    }
    
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>