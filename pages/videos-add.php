<?php require __DIR__ . '/includes/init.php';?>
<?php
$title = "新增影片";
$pageName = "videos-add"; 
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar-admin.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">新增影片</h5> 
        <small class="text-muted float-end border border-1 p-3 fs-6 rounded" style="background-color: #696cff;">
  <a href="videos.php" class="nav-link link-light">回到影片列表</a>
</small>
      </div>
      <div class="card-body">
        <form onsubmit="sendData(event)">
          <div class="row mb-6 d-flex">
            <label class="col-sm-2 col-form-label" for="basic-default-title"><i class="fa-solid fa-pen m-1"></i>標題(必填)</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-title" placeholder="例:伏地挺身挑戰" name="title">
              <div id="titleError" class="color-danger my-2"></div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="basic-default-description"><i class="fa-solid fa-pen m-1"></i>描述(必填)</label>
            <div class="col-sm-10">
              <textarea id="basic-default-description" class="form-control" placeholder="例:訓練胸部與三頭肌的經典動作" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2" rows="3" name="description" ></textarea>
              <div id="descriptionError" class="color-danger my-2"></div>
            </div>
          </div>
          <div class="row" >
            <div class="col-12">
                <small class="text-muted float-end" id="textCount">0 個字</small>
            </div>
          </div>

          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-video_url"><i class="fa-solid fa-pen m-1"></i>影片連結(必填)</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-video_url" placeholder="例:https://example.com/video1" name="video_url">
              <div id="video_url_Error" class="color-danger my-2"></div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-checkbox" ><i class="fa-solid fa-pen m-1"></i>影片分類</label >
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-6">
                        <select id="sendNotification" class="form-select" name="category_name">
                            <option value="居家徒手健身" selected="">居家徒手健身</option>
                            <option value="居家器械運動">居家器械運動</option>
                            <option value="居家有氧">居家有氧</option>
                        </select>
                    </div>
                </div>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-checkbox" ><i class="fa-solid fa-pen m-1"></i>發布狀態</label >
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-6">
                        <select id="sendNotification" class="form-select" name="status">
                            <option value="1" selected="">發布</option>
                            <option value="0">未發布</option>
                        </select>
                    </div>
                </div>
                
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
          <a href="./videos.php" class="nav-link">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> 
            <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
            </button>
        </div>
    </div>
    </div>
</div>

<script>
    const title = document.querySelector('#basic-default-title')
    const description = document.querySelector('#basic-default-description')
    const video_url = document.querySelector('#basic-default-video_url')
    const textCount = document.querySelector('#textCount')
    
    description.addEventListener('input', () => {
    textCount.innerHTML = `${description.value.length} 個字`;
    });
    
    const sendData = e=>{
        e.preventDefault();
        description.classList.remove('btn-outline-danger')
        title.classList.remove('btn-outline-danger')
        video_url.classList.remove('btn-outline-danger')
        textCount.classList.remove('btn-outline-danger')
        
        let isPass = true 

        if(title.value.length <= 0){
            isPass=false;
            document.querySelector('#titleError').innerHTML ='此欄為必填'
            title.classList.add('btn-outline-danger')
        }
        if(description.value.length <= 0){
            isPass=false;
            document.querySelector('#descriptionError').innerHTML ='此欄為必填'
            description.classList.add('btn-outline-danger')
        }
        if(video_url.value.length <= 0){
            isPass=false;
            document.querySelector('#video_url_Error').innerHTML ='此欄為必填'
            video_url.classList.add('btn-outline-danger')
        }

        
        if (isPass) {
          const fd = new FormData(document.forms[0]);
          const myModal = new bootstrap.Modal('#success-modal')
          fetch(`videos-add-api.php`, {
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
