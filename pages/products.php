<?php require __DIR__ . '/includes/init.php';?>


<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<style>
  .custom-select {
    /* appearance: none;  */
    /* -moz-appearance: none;  */
    /* -webkit-appearance: none; */
    /* background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"%3E%3Cpath fill="%23696cff" d="M2 0L0 2h4z" /%3E%3C/svg%3E') no-repeat right center; 
    background-size: 12px 12px; */
    border: 0; 
    /* padding-right: 20px;  */
    cursor: pointer; /* 顯示手型游標 */
    width: auto; /* 自適應寬度 */
    background-color: transparent; /* 背景透明 */
  }
  table {
    font-size: 16px; /* 修改整個表格的字體大小 */
  }
  th {
    font-size: 18px; /* 修改表頭的字體大小 */
  }

  /* .table thead tr th{
    text-align:center;
  } */
.pagination .page-link {
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}

/* 縮短表格行高 */
/* .table tbody tr {
  line-height: 1.5;
  font-size: 17px;
} */

/* .table tbody tr td {
  padding: 10px 10px;
} */
</style>


<?php
$perPage = 15; # 每一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); # 跳轉頁面 (後端), 也稱為 redirect (轉向)
  exit; # 離開 (結束) 程式 (以下的程式都不會執行)
}

$keyword = empty($_GET['keyword']) ? '' : $_GET['keyword'];

$where = ' WHERE 1 '; 
if($keyword){
  $keyword_ = $pdo->quote("%{$keyword}%"); 
  $where .= " AND (name LIKE $keyword_ OR base_price LIKE $keyword_)";
}

$category = empty($_GET['category']) ? '' : $_GET['category']; // 新增接收器材種類參數
if ($category) {
  $where .= " AND category_name = " . $pdo->quote($category); // 新增條件篩選
}

$t_sql = "SELECT COUNT(1) FROM `products` $where";
# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
# 總頁數
$totalPages = ceil($totalRows / $perPage);
$rows = []; # 設定預設值

if ($totalRows > 0) {
  if ($page > $totalPages) {
    // ob_clean();
    # 用戶要看的頁碼超出範圍, 跳到最後一頁
    header('Location: ?page=' . $totalPages);
    exit;
  }

  $sort_price = $_GET['sort_price'] ?? ''; // 取得排序方式

  $orderBy = '';
  if ($sort_price === 'asc') {
      $orderBy = 'ORDER BY base_price ASC'; // 價格由低到高
  } elseif ($sort_price === 'desc') {
      $orderBy = 'ORDER BY base_price DESC'; // 價格由高到低
  } elseif ($sort_price === ' ') {
      $orderBy = 'ORDER BY product_id ASC'; // 以 ID 排序
  }  

# 取第一頁的資料
$sql = sprintf(
"SELECT 
    p.id AS product_id, -- 商品 ID
    product_code,            -- 商品號碼  
    p.name,          -- 商品名稱
    p.description, -- 商品描述
    p.category_name,   -- 商品分類名稱
    p.weight,     -- 商品重量 (如果有規格)
    base_price,     -- 商品價格
    p.image_url,    -- 商品圖片
    p.created_at -- 商品建立時間
FROM 
    Products p
%s
%s  
-- ORDER BY 
--     p.id, p.weight 
LIMIT %s, %s", 
$where,
$orderBy,
($page - 1) * $perPage,  
$perPage);
$rows = $pdo->query($sql)->fetchAll(); # 取得該分頁的資料
}
?>

<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="card pb-5">
  <div class="row">
    <div class="col-10">
      <h4 class="card-header fw-bold fs-4">器材列表</h4>
    </div>
    <div class="col-2 card-header d-flex align-items-center justify-content-center fs-5">
      <a href="products_add.php" class="nav-link">
        <span class="d-none d-sm-block  fs-5"> 
        <i class="fa-solid fa-square-plus fa-xl mx-3"></i>新增器材</span>
      </a>
    </div>
  </div>
<div class="container">
 <div class="row mt-4">
    <div class="col d-flex justify-content-between p-4">
    <button class="btn btn-danger btn-sm " id="delete-selected">刪除選取項目</button>
      <!-- 搜尋 -->
      <div class="col-lg-3 me-5  d-flex align-items-center justify-content-end">
        <form class="d-flex" style= "height:20px;">
            <div class="input-group">
                  <button class="input-group-text">
                    <i class="tf-icons bx bx-search fs-4"></i>
                  </button>
              <input type="search" class="form-control " placeholder="Search..." name="keyword" 
              value="<?=empty($_GET['keyword'])?'':htmlentities($_GET['keyword'])?>" >
            </div>
        </form>
      </div>
    </div>
  </div>
  <!-- 表格 -->
  <div class="row">
    <div class="col table-responsive text-nowrap">
      <table class="table  table-hover mb-4">
        <thead>
          <tr>
            <th class="p-4 fw-bold fs-6">
              <input type="checkbox" id="select-all" />
            </th>
            <th class="p-4 fw-bold  fs-6">#id</th>
            <th class="p-4 fw-bold  fs-6">編號</th>
            <th class="p-4 fw-bold  fs-6">品項</th>
            <th class="p-4 fw-bold  fs-6">器材描述</th>
            <th class="p-4 fw-bold  fs-6">
            <form class="d-inline-block" >
            <select class="custom-select" 
                    name="category" 
                    onchange="this.form.submit()" 
                    style="width: auto; display: inline-block; background: none;">
              <option value="" class=" fs-6">器材種類</option>
              <!-- 動態生成種類選項 -->
              <?php
              $categories = $pdo->query("SELECT DISTINCT category_name FROM products")->fetchAll();
              foreach ($categories as $c): ?>
                <option value="<?= htmlentities($c['category_name']) ?>" 
                <?= $c['category_name'] == ($_GET['category'] ?? '') ? 'selected' : '' ?>>
                  <?= htmlentities($c['category_name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </form>
            </th>
            <th class="p-4  fw-bold  fs-6">重量(公斤)</th>
            <th class="p-4  fw-bold  fs-6">
            <form class="d-inline-block">
              <select class="custom-select" name="sort_price" onchange="this.form.submit()">
                <option value="">價格</option>
                <option value="asc" <?= ($_GET['sort_price'] ?? '') == 'asc' ? 'selected' : '' ?>>價格--由低到高</option>
                <option value="desc" <?= ($_GET['sort_price'] ?? '') == 'desc' ? 'selected' : '' ?>>價格--由高到低</option>
                <!-- <option value="id" 價格--以 ID 排序</option> -->
              </select>
            </form>
            </th>
            <th class="p-4  fw-bold  fs-6">圖片連結</th>
            <th class="p-4  fw-bold  fs-6">建立時間</th>
            <th class="p-4  fw-bold  fs-6">#</i></th>
            <th class="p-4  fw-bold  fs-6">#</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <?php foreach ($rows as $r): ?>
            <tr>
              <td class="p-4">
                <input type="checkbox" class="row-checkbox" value="<?= $r['product_id'] ?>" />
              </td>
              <td class="p-4"><?= $r['product_id'] ?></td>
              <td class="p-4"><?= $r['product_code'] ?></td>
              <td class="p-4"><?= $r['name'] ?></td>
              <td class="p-4"><?= $r['description'] ?></td>
              <td class="p-4"><?= $r['category_name'] ?></td>
              <td class="p-4"><?= $r['weight'] ?></td>
              <td class="p-4"><?= $r['base_price'] ?></td>
              <td class="p-4"><?= $r['image_url'] ?></td>
              <td class="p-4"><?= $r['created_at'] ?></td>
              <td class="p-4"><a class="dropdown-item" href="products_edit.php?product_id=<?= $r['product_id'] ?>">
                <i class="bx bx-edit-alt me-1"></i></a>
              </td>
              <td class="p-4"><a class="dropdown-item"  href="javascript:" onclick="deleteOne(event)">
                <i class="bx bx-trash me-1"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php
          $qs = array_filter($_GET); # 去除值是空字串的項目
       ?>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
        <li class="page-item <?= $page==1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?<?php $qs['page'] = 1;
                                        echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <li class="page-item <?= $page==1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?<?php $qs['page'] = $page - 1;
                                        echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angle-left"></i>
            </a>
          </li>

          <?php for ($i = $page - 5; $i <= $page + 5; $i++): 
                if ($i >= 1 and $i <= $totalPages):
                $qs = array_filter($_GET); # 去除值是空字串的項目
                $qs['page'] = $i;
            ?>
            <li class="page-item <?= $i==$page ? 'active' : '' ?>">
              <a style="height = 10px" class="page-link" href="?<?= http_build_query($qs) ?>"><?= $i ?></a>
            </li>
          <?php 
          endif;
        endfor; ?>

          <li class="page-item <?= $page==$totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?<?php $qs['page'] = $page + 1;
                                        echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angle-right"></i>
            </a>
          </li>
          <li class="page-item <?= $page==$totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?<?php $qs['page'] = $totalPages;
                                        echo http_build_query($qs) ?>">
              <i class="fa-solid fa-angles-right"></i>
            </a>
          </li>
        </ul>
      </nav>
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./products.php" class="nav-link">
            <i class="fa-solid fa-circle-xmark me-3"></i>否</a>
            </button>
        </div>
    </div>
    </div>
</div>

<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
  const deleteOne = e=>{
          e.preventDefault();
          const tr = e.target.closest('tr')
          const [td_product_id, ,td_name] = tr.querySelectorAll('td');
          const productid = td_product_id.innerHTML
          const name = td_name.innerHTML
          const delModal = new bootstrap.Modal('#delete-modal')
          delModal.show()
          document.querySelector('#exampleModalLabel2').innerHTML=`是否要刪除編號為${productid}，名稱為${name}的器材`
          document.querySelector('#yesgo').addEventListener('click',function(){
            location.href=`product-del-api.php?product_id=${productid}`
          })
      }
      // 多選刪除
      document.addEventListener("DOMContentLoaded", function () {
        const selectAllCheckbox = document.getElementById("select-all");
        const rowCheckboxes = document.querySelectorAll(".row-checkbox");
        const deleteButton = document.getElementById("delete-selected");

        // 全選功能
        selectAllCheckbox.addEventListener("change", function () {
          const isChecked = selectAllCheckbox.checked;
          rowCheckboxes.forEach((checkbox) => {
            checkbox.checked = isChecked;
          });
        });

  // 批量刪除功能
        deleteButton.addEventListener("click", function () {
          const selectedIds = Array.from(rowCheckboxes)
            .filter((checkbox) => checkbox.checked)
            .map((checkbox) => checkbox.value);

          if (selectedIds.length === 0) {
            alert("請先勾選要刪除的項目！");
            return;
          }

          if (confirm(`確定要刪除選取的 ${selectedIds.length} 項嗎？`)) {
            // 發送 AJAX 請求到後端
            fetch("delete-multiple-api.php", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ ids: selectedIds }),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  alert("刪除成功！");
                  location.reload(); // 重新加載頁面
                } else {
                  alert("刪除失敗：" + data.error);
                }
              })
              .catch((error) => console.error("Error:", error));
          }
        });
      });


</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>
