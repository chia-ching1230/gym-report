<?php require __DIR__ . '/includes/init.php';?>
<?php
$title ="GYM點管理";
$pageName="gymSite";

$perPage = 15;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: gymSite.php'); 
  exit; 
}

$t_sql = "SELECT count(*) FROM gyms";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; 

if($totalRows>0){
   $sql = sprintf("SELECT * FROM gyms
  LIMIT %s, %s",
  ($page -1) * $perPage,
  $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}

$totalPages = ceil($totalRows/$perPage);


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
      <h4 class="card-header">GYM點管理</h4>
    </div>
    <div class="col-2 card-header d-flex align-items-center justify-content-center">
      <a href="gymSite-add.php" class="nav-link">
        <span class="d-none d-sm-block"> 
        <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增GYM點</span>
      </a>
    </div>
  </div>
  
    <div class="row">
      <div class="col-lg-12 mx-5">
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
    </div>
  
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>名稱</th>
          <th>地址</th>
          <th>營業星期</th>
          <th>開門時間</th>
          <th>關門時間</th>
          <th>描述</th>
          <th>聯絡電話</th>
          <th>email</th>
          <th>經理</th>
          <th>圖片</th>
          <th>位置訊息</th>
          <th>創建時間</th>
          <th>編輯</th>
          <th>刪除</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <?php foreach($rows as $v):?>
        <tr>
          <td><button type="button" class="btn rounded-pill btn-icon btn-outline-secondary" data-bs-toggle="modal"  data-bs-target="#exLargeModal" data-gym-id="<?=$v['gym_id']?>" id="viewBtn">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button></td>
          <td><?=$v['gym_id']?></td>
          <td style="max-width: 120px" title="<?=$v['name']?>">
            <?=$v['name']?>
          </td>
          <td style="max-width: 200px" title="<?=htmlentities($v['address'])?>">
            <?=htmlentities($v['address'])?></td>
          <td style="max-width: 150px" title="<?=$v['business_days']?>">
            <?=$v['business_days']?>
          </td>
          <td style="max-width: 150px" title="<?=$v['opening_hours']?>">
            <?=$v['opening_hours']?></td>
          <td style="max-width: 150px" title="<?=$v['closing_hours']?>">
            <?=$v['closing_hours']?>
          </td>
          <td style="max-width: 300px" title="<?=htmlentities($v['description'])?>">
            <?=htmlentities($v['description'])?>
          </td>
          <td title="<?=htmlentities($v['contact_info'])?>">
            <?=htmlentities($v['contact_info'])?>
          </td>
          <td title="<?=htmlentities($v['email'])?>">
            <?=htmlentities($v['email'])?>
          </td>
          <td style="max-width: 120px" title="<?=htmlentities($v['manager'])?>">
            <?=htmlentities($v['manager'])?>
          </td>
          <td style="max-width: 120px" title="<?=htmlentities($v['image_url'])?>">
            <?=htmlentities($v['image_url'])?>
          </td>
          <td style="max-width: 120px" title="<?=htmlentities($v['google_map_link'])?>">
            <?=htmlentities($v['google_map_link'])?>
          </td>
          

          <td style="max-width: 150px" title="<?=$v['created_at']?>">
            <?=$v['created_at']?>
          </td>
          <td><a class="dropdown-item" href="gymSite-edit.php?gym_id=<?=$v['gym_id']?>">
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
                <h5 class="modal-title" id="exampleModalLabel4">健身房據點詳情</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-gym_id">ID</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-gym_id" name="gym_id" value="" disabled >
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-name">名稱</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="basic-default-name" name="name"  disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-address">地址</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-address" name="address" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-business_days">營業星期</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-business_days" name="business_days" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-opening_hours">開門時間</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-opening_hours" name="opening_hours" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-closing_hours">關門時間</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-closing_hours" name="closing_hours" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-description">描述</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-description" name="description" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-contact_info">聯絡電話</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-contact_info" name="contact_info" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-email"> email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-email" name="email" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-manager">經理</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-manager" name="manager" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-image_url">圖片連結</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-image_url" name="image_url" disabled>
                  </div>
                </div>
                <div class="row mb-6">
                  <label class="col-sm-2 col-form-label" for="basic-default-google_map_link">位置訊息</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control " id="basic-default-google_map_link" name="google_map_link" disabled>
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymSite.php" class="nav-link">
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
          const gym_id = this.getAttribute('data-gym-id'); 
          fetch(`gymSite-details-api.php?gym_id=${gym_id}`)
              .then(r => r.json())
              .then(data => {
                  if (data.success) {
                      document.getElementById('basic-default-gym_id').value = data.gyms.gym_id;
                      document.getElementById('basic-default-name').value = data.gyms.name;
                      document.getElementById('basic-default-address').value = data.gyms.address;
                      document.getElementById('basic-default-business_days').value = data.gyms.business_days;
                      document.getElementById('basic-default-opening_hours').value = data.gyms.opening_hours;
                      document.getElementById('basic-default-closing_hours').value = data.gyms.closing_hours;
                      document.getElementById('basic-default-description').value = data.gyms.description;
                      document.getElementById('basic-default-contact_info').value = data.gyms.contact_info;
                      document.getElementById('basic-default-email').value = data.gyms.email;
                      document.getElementById('basic-default-manager').value = data.gyms.manager;
                      document.getElementById('basic-default-image_url').value = data.gyms.image_url;
                      document.getElementById('basic-default-google_map_link').value = data.gyms.google_map_link;
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
        const [,td_gym_id,td_name,] = tr.querySelectorAll('td');
        const gym_id = td_gym_id.innerHTML
        const name = td_name.innerHTML

        const delModal = new bootstrap.Modal('#delete-modal')
        delModal.show()
        document.querySelector('#exampleModalLabel2').innerHTML=`是否要刪除編號為${gym_id}，${name}的據點`
        document.querySelector('#yesgo').addEventListener('click',function(){
          location.href=`gymSite-del-api.php?gym_id=${gym_id}`
        })
    }
    
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>