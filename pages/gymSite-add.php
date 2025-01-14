<?php require __DIR__ . '/includes/init.php';?>
<?php
$title = "新增GYM點";
$pageName = "gymSite-add"; 
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">新增GYM點</h5> 
        <small class="text-muted float-end"> <a href="./gymSite.php" class="nav-link">回到GYM點列表</a>
        </small>
      </div>
      <div class="card-body">
        <form onsubmit="sendData(event)">
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-name">據點名稱</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-name" placeholder="請輸入據點名稱" name="name">
              <div id="nameError" class="mt-3" style="color: red;"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-address">地址</label>
            <div class="col-sm-10">
              <textarea id="basic-default-address" class="form-control" placeholder="請輸據點入地址" aria-describedby="basic-icon-default-message2" rows="2" name="address" ></textarea>
              <div id="addressError" class="mt-3" style="color: red;"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-tel">聯絡電話</label>
            <div class="col-sm-10">
              <input type="tel" class="form-control " id="basic-default-tel" name="tel" placeholder="065800000"  require>
              <div id="telError"  class="mt-3" style="color: red;"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-author">email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control " id="basic-default-email" name="email" placeholder="XXX@XX.XX" require>
              <div id="emailError"  class="mt-3" style="color: red;"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-open">營業星期</label>
            <div class="col-sm-10">
            <div class="form-check form-check-inline mt-3">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Monday" name="business_days[]">
              <label class="form-check-label" for="inlineCheckbox1">Monday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Tuesday" name="business_days[]" >
              <label class="form-check-label" for="inlineCheckbox2">Tuesday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="Wednesday" name="business_days[]">
              <label class="form-check-label" for="inlineCheckbox3">Wednesday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="Thursday" name="business_days[]">
              <label class="form-check-label" for="inlineCheckbox4">Thursday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="Friday" name="business_days[]">
              <label class="form-check-label" for="inlineCheckbox5">Friday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="Saturday" name="business_days[]">
              <label class="form-check-label" for="inlineCheckbox6">Saturday</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="Sunday" name="business_days[]">
              <label class="form-check-label" for="inlineCheckbox7">Sunday</label>
            </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-open">開門時間</label>
            <div class="col-sm-10">
              <input type="time" class="form-control " id="basic-default-open" name="open" value="08:30:00" require>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-colse">關門時間</label>
            <div class="col-sm-10">
              <input type="time" class="form-control " id="basic-default-colse" name="colse" value="20:30:00" require>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-description">描述</label>
            <div class="col-sm-10">
              <textarea id="basic-default-description" class="form-control" placeholder="請輸入據點描述" aria-describedby="basic-icon-default-message2" rows="5" name="description" ></textarea>
              <div id="descriptionError"  class="mt-3" style="color: red;"></div>
            </div>
          </div>
          
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-image_url">圖片</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-image_url" name="image_url" placeholder="請輸入圖片訊息" require>
              <div id="imageError"  class="mt-3" style="color: red;"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-google_map_link">位置</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-google_map_link" name="google_map_link" placeholder="請輸入位置訊息" require>
              <div id="map_linkError"  class="mt-3" style="color: red;"></div>

            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-manager">經理</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-manager" name="manager" placeholder="請輸入經理名稱" require>
              <div id="managerError"  class="mt-3" style="color: red;"></div>

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
            <h4 class="modal-title" id="exampleModalLabel2">新增結果</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- alert -->
            <div class="alert alert-primary" role="alert">
            成功!
            </div>
        </div>
        <div class="modal-footer">
            <a href="./gymSite.php" class="nav-link">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> 
            <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
            </button>
        </div>
    </div>
    </div>
</div>
<!-- modal null -->
<div class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true" id="null-modal">
    <div class="modal-dialog modal-sm" role="document" >
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel2">提示</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <!-- alert -->
            <div class="alert alert-danger" role="alert">
            請選擇至少一天營業!
            </div>
        </div>
    </div>
    </div>
</div>

<script>
    const email = document.querySelector('#basic-default-email')
    const name = document.querySelector('#basic-default-name')
    const address = document.querySelector('#basic-default-address')
    const description  = document.querySelector('#basic-default-description')
    const tel = document.querySelector('#basic-default-tel')
    const google_map_link = document.querySelector('#basic-default-google_map_link')
    const manager = document.querySelector('#basic-default-manager')
    const image_url = document.querySelector('#basic-default-image_url')


    const sendData = e=>{

        e.preventDefault();
          name.classList.remove('btn-outline-danger')
          document.querySelector('#nameError').innerHTML =''
          email.classList.remove('btn-outline-danger')
          document.querySelector('#emailError').innerHTML =''
          description.classList.remove('btn-outline-danger')
          document.querySelector('#descriptionError').innerHTML =''
          tel.classList.remove('btn-outline-danger')
          document.querySelector('#telError').innerHTML =''
          google_map_link.classList.remove('btn-outline-danger')
          document.querySelector('#map_linkError').innerHTML =''
          manager.classList.remove('btn-outline-danger')
          document.querySelector('#managerError').innerHTML =''
          image_url.classList.remove('btn-outline-danger')
          document.querySelector('#imageError').innerHTML =''
          address.classList.remove('btn-outline-danger')
          document.querySelector('#addressError').innerHTML =''



        function validateEmail(email) {
        const pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(email);
        }
        function formatPhoneNumber(tel) {
          const cleanedPhone = tel.replace(/\D/g, '');
          if (cleanedPhone.length === 9) {
          return cleanedPhone.replace(/^(\d{2})(\d{4})(\d{3})$/, '$1-$2-$3');
          } else {
          return document.querySelector('#telError').innerHTML = "長度錯誤(9碼060000000)"; 
          }
        }
        function validatePhoneNumber(tel) {
          const formattedPhone = formatPhoneNumber(tel);
          if (formattedPhone) {
            return formattedPhone; 
          }
          return false;
        }
        

        let isPass = true 

        if(name.value.length < 3){
            isPass=false;
            document.querySelector('#nameError').innerHTML ='名字不能小於1個字'
            name.classList.add('btn-outline-danger')
        }
        if(manager.value.length < 1){
            isPass=false;
            document.querySelector('#managerError').innerHTML ='名字不能小於1個字'
            manager.classList.add('btn-outline-danger')
        }
        if(address.value.length < 10){
            isPass=false;
            document.querySelector('#addressError').innerHTML ='地址不能小於10個字'
            address.classList.add('btn-outline-danger')
        }
        if(description.value.length < 10){
            isPass=false;
            document.querySelector('#descriptionError').innerHTML ='描述不能小於10個字'
            description.classList.add('btn-outline-danger')
        }
        if(tel.value.length !== 9){
            isPass=false;
            document.querySelector('#telError').innerHTML ='請填寫正確電話(9碼)'
            tel.classList.add('btn-outline-danger')
        }
        if(image_url.value.length === 0){
            isPass=false;
            document.querySelector('#imageError').innerHTML ='不能為空'
            image_url.classList.add('btn-outline-danger')
        }
        if(google_map_link.value.length < 10){
            isPass=false;
            document.querySelector('#map_linkError').innerHTML ='請填寫正確mapLink'
            google_map_link.classList.add('btn-outline-danger')
        }
        
        if(!validateEmail(email.value)){
            isPass=false;
            document.querySelector('#emailError').innerHTML  ='請填寫正確email'
            email.classList.add('btn-outline-danger')
        }
        
        if(!validatePhoneNumber(tel.value)){
            isPass=false;
            document.querySelector('#telError').innerHTML  ='請填寫正確電話'
            tel.classList.add('btn-outline-danger')
        }
        const mynullModal = new bootstrap.Modal('#null-modal')
        if (document.querySelectorAll('input[name="business_days[]"]:checked').length === 0) {
            isPass = false;
            mynullModal.show();
        }
        
        if (isPass) {
          const fd = new FormData(document.forms[0]);
          const myModal = new bootstrap.Modal('#success-modal')
          fetch(`gymSite-add-api.php`, {
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
            }
            }).catch(console.warn);
        }
    }
</script>
<?php include __DIR__ . '/includes/html-script.php'; ?>
<?php include __DIR__ . '/includes/html-footer.php'; ?>
