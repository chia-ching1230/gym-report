<?php require __DIR__ . '/includes/init.php';?>
<?php
$title ="訂單管理";
$pageName="orders";

$order_id = empty($_GET['order_id'])? 0 : intval($_GET['order_id']);
// if(empty($order_id)){
//   header('Location: order.php');
//   exit;
// }

$allsql="SELECT * FROM orders WHERE order_id = $order_id";
$r = $pdo->query($allsql)->fetch();
// if(empty($r)){
//   header('Location: order.php');
//   exit;
// }



$perPage = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: order.php'); 
  exit; 
}

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$where =" WHERE 1 ";
if($keyword){
  $keyword_ = $pdo->quote("%{$keyword}%"); 
  echo $keyword_;
  $where .= " AND (order_id LIKE $keyword_ OR total_amount LIKE $keyword_)";
}

$t_sql = "SELECT count(*) FROM orders $where";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; 


if($totalRows>0){
  // if($page > $totalPages){
  //     header('Location:?page='.$totalPages);
  //     exit;
  // }
  $sql = sprintf("SELECT * FROM `orders` %s
  LIMIT %s, %s", $where,
  ($page -1) * $perPage,
  $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}

$totalPages = ceil($totalRows/$perPage);

$all_sql="SELECT * FROM orders WHERE order_id = $order_id";
$r = $pdo->query($all_sql)->fetch();
// if(empty($r)){
//     header('Location: order.php');
//     exit;
// }
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
      <h4 class="card-header">訂單管理</h4>
    </div>
    <div class="col-2 card-header d-flex align-items-center justify-content-center">
      <a href="order-add.php" class="nav-link">
        <span class="d-none d-sm-block"> 
        <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增訂單</span>
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
          <th>訂單號碼</th>
          <th>會員號碼</th>
          <th>總金額</th>
          <th>訂單狀態</th>
          <th>自取門市</th>
          <th>付款方式</th>
          <th>創建時間</th>
          <th>更新時間</th>
          <th>編輯</th>
          <th>刪除</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <?php foreach($rows as $v):?>
        <tr>
          <td><button type="button" class="btn rounded-pill btn-icon btn-outline-secondary" data-bs-toggle="modal"  data-bs-target="#exLargeModal"  data-order-id="<?=$v['order_id']?>" id="viewBtn">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button></td>
          <td title="<?=$v['order_id']?>"><?=$v['order_id']?></td>
          <td style="max-width: 200px" title="<?=$v['member_id']?>"><?=$v['member_id']?></td>
          <td style="max-width: 150px" title="<?=htmlentities($v['total_amount'])?>">
            <?=htmlentities($v['total_amount'])?></td>
          <td title="<?=$v['status']?>"><?=$v['status']?></td>
          <td style="max-width: 150px" title="<?=$v['self_pickup_store']?>"><?=$v['self_pickup_store']?></td>
          <td style="max-width: 150px" title="<?=$v['payment_method']?>"><?=$v['payment_method']?></td>
          <td style="max-width: 150px" title="<?=$v['created_at']?>"><?=$v['created_at']?></td>
          <td style="max-width: 150px" title="<?=$v['updated_at']?>"><?=$v['updated_at']?></td>
          
          <td><a class="dropdown-item" href="order-edit.php?order_id=<?=$v['order_id']?>">
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
                <h5 class="modal-title" id="exampleModalLabel4">文章詳情</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-order_id">文章ID</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-order_id" name="order_id" value="" disabled >
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-title">標題</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-title" placeholder="title" name="title" value="" disabled>
                    <div id="titleError" class="color-danger my-2"></div>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-author">作者ID</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control " id="basic-default-author" name="author_id" placeholder="ID" min=1  value="" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-content">文章內容</label>
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./order.php" class="nav-link">
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
          const orderId = this.getAttribute('data-order-id'); 
          fetch(`order-details-api.php?order_id=${orderId}`)
              .then(r => r.json())
              .then(data => {
                  if (data.success) {
                      document.getElementById('basic-default-order_id').value = data.order.order_id;
                      document.getElementById('basic-default-member_id').value = data.order.member_id;
                      document.getElementById('basic-default-total_amount').value = data.order.total_amount;
                      
                      //order.self_pickup_store==4?'健身房A':'健身房B':'健身房C':'健身房D':'健身房E');
                      /*document.getElementById('basic-default-uploadStatus').value = (data.order.uploadStatus==1?'發布':'未發布');*/
                      document.getElementById('basic-default-self_pickup_store').value = 
    (data === 4 ? '健身房A' : 
    (data === 3 ? '健身房B' : 
    (data === 2 ? '健身房C' : 
    (data === 1 ? '健身房D' : '健身房E'))));

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

    const deleteOne = e=>{
        e.preventDefault();
        const tr = e.target.closest('tr')
        const [,td_order_id,td_title,] = tr.querySelectorAll('td');
        const orderid = td_order_id.innerHTML
        const title = td_title.innerHTML
        const delModal = new bootstrap.Modal('#delete-modal')
        delModal.show()
        document.querySelector('#exampleModalLabel2').innerHTML=`是否要刪除編號為${orderid}，標題為${title}的文章`
        document.querySelector('#yesgo').addEventListener('click',function(){
          location.href=`order-del-api.php?order_id=${orderid}`
        })
    }
    
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>