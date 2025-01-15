<?php require __DIR__ . '/includes/init.php';?>
<?php
$title = "訂單修改";
$pageName = "order-edit"; 
# 修改前要先拿到第6行(取得指定的PK)
$order_id = empty($_GET['order_id'])? 0 : intval($_GET['order_id']);
if(empty($order_id)){
    header('Location: order.php');//(第一關)意思是如果沒有就離開
    exit;
}
//讀取該筆資料
$sql="SELECT * FROM orders WHERE order_id = $order_id";
$r = $pdo->query($sql)->fetch(); //此語法只會有一筆資料或沒有資料2種狀況
if(empty($r)){
    header('Location: order.php'); //如果沒有對應資料就跳走
    exit;
}
# 第一個跳走exit是沒有給參數,第二個跳走是有參數,但沒有拿到參數對應資料
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>


<div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">編輯訂單</h5> 
        <small class="text-muted float-end"> <a href="./order.php" class="nav-link">回到訂單列表</a>
        </small>
      </div>
      <div class="card-body">
        <form onsubmit="sendData(event)">
            <input type="hidden" class="form-control" name="order_id" value="<?=$r['order_id'] ?>" >    
            <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-order_id">訂單號碼</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-order_id" name="order_id" value="<?=$r['order_id'] ?>" disabled >
                <div id="order_idError" class="mt-3" style="color: red;"></div>
                </div>
            </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-member_id">會員編號</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-member_id" placeholder="ID" name="member_id" value="<?=$r['member_id']?>" require>
              <div id="member_idError" class="mt-3" style="color: red;"></div>
            </div>
            
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-total_amount">總金額</label>
            <div class="col-sm-10">
              <input type="number" class="form-control " id="basic-default-total_amount" name="total_amount" value="<?=$r['total_amount']?>" require>
              <div id="total_amountError" class="mt-3" style="color: red;"></div>
            </div>
            
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-checkbox">自取門市</label>
            <div class="col-sm-10">
            <div class="row">
                    <div class="col-sm-6">
                        <select id="self_pickup_store" class="form-select" name="self_pickup_store">
                            <option value="健身房A" selected="">健身房A</option>
                            <option value="健身房B" >健身房B</option>
                            <option value="健身房C" >健身房C</option>
                            <option value="健身房D" >健身房D</option>
                            <option value="健身房E" >健身房E</option>
                        </select>
                    </div>
                </div>
              <div id="self_pickup_storeError" class="mt-3" style="color: red;"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-checkbox" >付款方式</label >
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-6">
                        <select id="payment_method" class="form-select" name="payment_method">
                            <option value="現金" selected="">現金</option>
                            <option value="信用卡">信用卡</option>
                        </select>
                    </div>
                </div>
                
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-checkbox" >訂單狀態</label >
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-6">
                        <select id="status" class="form-select" name="status">
                            <option value="completed" selected="">已完成</option>
                            <option value="canceled">已取消</option>
                            <option value="pending">待處理</option>
                        </select>
                    </div>
                </div>
                
            </div>
          </div>
      
          <div class="mt-6 text-end">
            <button type="submit" class="btn btn-primary me-3">確定</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  

<?php include __DIR__ . '/includes/html-content wrapper-end.php'; ?>
<!-- modal success -->
<div class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true" id="success-modal">
    <div class="modal-dialog modal-sm" role="document" >
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel2">修改結果</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- alert -->
            <div class="alert alert-primary" role="alert">
            成功!
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./order.php" class="nav-link">
            <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
            </button>
        </div>
    </div>
    </div>
</div>
<!-- modal no-edit -->
<div class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true" id="no-edit-modal">
    <div class="modal-dialog modal-sm" role="document" >
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel2">修改結果</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- alert -->
            <div class="alert alert-secondary" role="alert">
            訂單沒有修改!
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./order.php" class="nav-link">
            <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
            </button>
        </div>
    </div>
    </div>
</div>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<script>
    const myModal = new bootstrap.Modal('#success-modal')
    const noEditModal = new bootstrap.Modal('#no-edit-modal')
    const member_id = document.querySelector('#basic-default-member_id')
    const total_amount = document.querySelector('#basic-default-total_amount')
    const self_pickup_store = document.querySelector('#self_pickup_store')
    const payment_method = document.querySelector('#payment_method')
    const status = document.querySelector('#status')
    



// 從後端傳遞的數據
const storeValue = <?= json_encode($r['self_pickup_store']); ?>;  // 自取門市
const paymentMethodValue = <?= json_encode($r['payment_method']); ?>; // 付款方式
const statusValue = <?= json_encode($r['status']); ?>; // 訂單狀態


// 設定下拉選單的選中值
document.querySelector('#self_pickup_store').value = storeValue;
document.querySelector('#payment_method').value = paymentMethodValue;
document.querySelector('#status').value = statusValue;

/*textCount.innerHTML = `${content.value.length} 個字`;
content.addEventListener('input', () => {
    textCount.innerHTML = `${content.value.length} 個字`;
});*/

    
    const sendData = e=>{
        e.preventDefault();
        total_amount.classList.remove('btn-outline-danger')
        document.querySelector('#total_amountError').innerHTML =''
        self_pickup_store.classList.remove('btn-outline-danger')
        document.querySelector('#self_pickup_storeError').innerHTML =''
        member_id.classList.remove('btn-outline-danger')
        document.querySelector('#member_idError').innerHTML=''

        let isPass = true 

        

        

        if(member_id.value.length === ''){
            isPass=false;
            document.querySelector('#member_idError').innerHTML ='會員編號不能空白'
            member_id.classList.add('btn-outline-danger')
        }
        /*if(content.value.length < 30){
            isPass=false;
            document.querySelector('#contentError').innerHTML ='內文不能小於30個字'
            content.classList.add('btn-outline-danger')
        }*/
        
        if (isPass) {
          const fd = new FormData(document.forms[0]);
          fetch(`order-edit-api.php`, {
            method: 'POST',
            body: fd
            }).then(r => r.json())
            .then(obj => {
            console.log(obj);
            if (obj.success) {
                alert(obj.error)
            }
            if (obj.success) {
              myModal.show()
            }else{
              noEditModal.show()
            }
            }).catch(console.warn);
        }
    };
</script>
<?php include __DIR__ . '/includes/html-footer.php'; ?>
