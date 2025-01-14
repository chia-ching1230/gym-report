<?php require __DIR__ . '/includes/init.php';?>
<?php
$title = "編輯GYM點";
$pageName = "gymSite-edit"; 
$gym_id = empty($_GET['gym_id'])? 0 : intval($_GET['gym_id']);
if(empty($gym_id)){
    header('Location: gymSite.php');
    exit;
}

$sql="SELECT * FROM gyms WHERE gym_id = $gym_id";
$r = $pdo->query($sql)->fetch();
if(empty($r)){
    header('Location: gymSite.php');
    exit;
}
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>



<div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">編輯GYM點</h5> 
        <small class="text-muted float-end"> <a href="./gymSite.php" class="nav-link">回到GYM點列表</a>
        </small>
      </div>
      <div class="card-body">
        <form onsubmit="sendData(event)">
        <input type="hidden" class="form-control" name="gym_id" value="<?=$r['gym_id']?>">
        <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-gym_id">據點ID</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-gym_id" placeholder="請輸入據點名稱" name="gym_id" value="<?=$r['gym_id']?>" disabled>
            </div>
        </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-name">據點名稱</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-name" placeholder="請輸入據點名稱" name="name" value="<?=$r['name'] ?>">
              <div id="nameError" class="color-danger my-2"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-address">地址</label>
            <div class="col-sm-10">
              <textarea id="basic-default-address" class="form-control" placeholder="請輸入地址" aria-describedby="basic-icon-default-message2" rows="2" name="address" ><?=$r['address']?></textarea>
              <div id="addressError"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-open">開門時間</label>
            <div class="col-sm-10">
              <input type="time" class="form-control " id="basic-default-open" name="open" value="<?=$r['opening_hours']?>" require>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-colse">關門時間</label>
            <div class="col-sm-10">
              <input type="time" class="form-control " id="basic-default-colse" name="colse" value="<?=$r['closing_hours']?>"require >
            </div>
          </div>
          <div class="row mb-6">
            <?php
            $business_days = explode(",", str_replace(' ', '', $r['business_days'])); 
            ?>
            <label class="col-sm-2 col-form-label" for="basic-default-open">營業星期</label>
            <div class="col-sm-10">
            <div class="form-check form-check-inline mt-3">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Monday" name="business_days[]" <?=in_array("Monday", $business_days)?'checked':''?>>
              <label class="form-check-label" for="inlineCheckbox1">Monday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Tuesday" name="business_days[]" <?=in_array("Tuesday", $business_days)?'checked':''?> >
              <label class="form-check-label" for="inlineCheckbox2">Tuesday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Wednesday" name="business_days[]" <?=in_array("Wednesday", $business_days)?'checked':''?>>
              <label class="form-check-label" for="inlineCheckbox3">Wednesday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="Thursday" name="business_days[]" <?=in_array("Thursday", $business_days)?'checked':''?>>
              <label class="form-check-label" for="inlineCheckbox4">Thursday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="Friday" name="business_days[]" <?=in_array("Friday", $business_days)?'checked':''?>>
              <label class="form-check-label" for="inlineCheckbox5">Friday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="Saturday" name="business_days[]" <?=in_array("Saturday", $business_days)?'checked':''?>>
              <label class="form-check-label" for="inlineCheckbox6">Saturday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="Sunday" name="business_days[]" <?=in_array("Sunday", $business_days)?'checked':''?>>
              <label class="form-check-label" for="inlineCheckbox7">Sunday</label>
            </div>
            </div>
          </div>
          
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-description">描述</label>
            <div class="col-sm-10">
              <textarea id="basic-default-description" class="form-control" placeholder="description..." aria-describedby="basic-icon-default-message2" rows="5" name="description" ><?=$r['description']?></textarea>
              <div id="descriptionError"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-tel">聯絡電話</label>
            <div class="col-sm-10">
              <input type="tel" class="form-control " id="basic-default-tel" name="tel" placeholder="06-5800000" value="<?=$r['contact_info']?>" require>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-author">email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control " id="basic-default-email" name="email" placeholder="XXX@XX.XX" value="<?=$r['email']?>" require>
            </div>
            <div id="emailError" class="color-danger my-2"></div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-manager">經理</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-manager" name="manager" placeholder="請輸入經理名稱" value="<?=$r['manager']?>" require>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-image_url">圖片</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-image_url" name="image_url" placeholder="請輸入圖片訊息" value="<?=$r['image_url']?>" require>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-author">位置</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-google_map_link" name="google_map_link" placeholder="請輸入位置訊息" value="<?=$r['google_map_link']?>"require>
            </div>
          </div>
          <div class="mt-6">
            <button type="submit" class="btn btn-primary me-3">確定</button>
            <button type="reset" class="btn btn-outline-secondary">重設</button>
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
            <h4 class="modal-title" id="exampleModalLabel2">編輯結果</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- alert -->
            <div class="alert alert-primary" role="alert">
            成功!
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymSite.php" class="nav-link">
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
            <h4 class="modal-title" id="exampleModalLabel2">編輯結果</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- alert -->
            <div class="alert alert-secondary" role="alert">
            資料沒有修改!
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymSite.php" class="nav-link">
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
    const email = document.querySelector('#basic-default-email')
    const name = document.querySelector('#basic-default-name')
    const address = document.querySelector('#basic-default-address')
    const businessDays = document.querySelectorAll('input[name="business_days[]"]:checked');
    
    const sendData = e=>{
        e.preventDefault();
        name.classList.remove('btn-outline-danger')
        email.classList.remove('btn-outline-danger')
        address.classList.remove('btn-outline-danger')



        function validateEmail(email) {
        const pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(email);
        }

        let isPass = true 

        if(name.value.length <= 3){
            isPass=false;
            document.querySelector('#nameError').innerHTML ='名字不能小於3個字'
            name.classList.add('btn-outline-danger')
        }
        if(address.value.length <= 10){
            isPass=false;
            document.querySelector('#addressError').innerHTML ='地址不能小於10個字'
            address.classList.add('btn-outline-danger')
        }
        if(!validateEmail(email.value)){
            isPass=false;
            document.querySelector('#emailError').innerHTML  ='請填寫正確email'
            email.classList.add('btn-outline-danger')
        }

        
        if (businessDays.length === 0) {
            isPass = false;
            alert('請選擇至少一個營業星期');
        }
        if (isPass) {
          const fd = new FormData(document.forms[0]);
          fetch(`gymSite-edit-api.php`, {
            method: 'POST',
            body: fd
            }).then(r => r.json())
            .then(obj => {
            console.log(obj);
            if (!obj.success && obj.error) {
                alert(obj.error)
            }
            if (obj.success) {
                myModal.show()
            }else{
                noEditModal.show()
            }
            }).catch(console.warn);
        }
    }
</script>

<?php include __DIR__ . '/includes/html-footer.php'; ?>
