<?php require __DIR__ . '/includes/init.php';?>
<?php
$title = "影片修改";
$pageName = "videos-edit"; 
$videos_id = empty($_GET['videos_id'])? 0 : intval($_GET['videos_id']);
if(empty($videos_id)){
    header('Location: videos.php');
    exit;
}

$sql="SELECT * FROM Videos WHERE videos_id = $videos_id";
$r = $pdo->query($sql)->fetch();
if(empty($r)){
    header('Location: videos.php');
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
        <h5 class="mb-0">編輯影片</h5> 
        <small class="text-muted float-end"> <a href="./videos.php" class="nav-link">回到影片列表</a>
        </small>
      </div>
      <div class="card-body">
        <form onsubmit="sendData(event)">
            <input type="hidden" class="form-control" name="videos_id" value="<?=$r['videos_id'] ?>" >    
            <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-videos_id">影片ID</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-videos_id" name="videos_id" value="<?=$r['videos_id'] ?>" disabled >
                </div>
            </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-title">標題</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-title" placeholder="title" name="title" value="<?=$r['title']?>">
              <div id="titleError" class="color-danger my-2"></div>
            </div>
            
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="basic-default-description">描述</label>
            <div class="col-sm-10">
              <textarea id="basic-default-description" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2" rows="3" name="description" ><?=$r['description']?></textarea>
              <div id="descriptionError"></div>
            </div>
          </div>
          <div class="row" >
            <div class="col-12">
                <small class="text-muted float-end" id="textCount">0 個字</small>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-video_url">影片連結</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-video_url" placeholder="video_url" name="video_url" value="<?=$r['video_url']?>">
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-category">分類</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-category" placeholder="category" name="category" value="<?=$r['category']?>">
            </div>
          </div>
          


          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-checkbox" >發布狀態</label >
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-6">
                        <select id="sendNotification" class="form-select" name="status">
                            <option value="1"  <?=($r['status'] == 1) ? 'selected' : ''; ?>>發布</option>
                            <option value="0" <?=($r['status'] == 0) ? 'selected' : ''; ?>>未發布</option>
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./videos.php" class="nav-link">
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./videos.php" class="nav-link">
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
    const title = document.querySelector('#basic-default-title')
    const description = document.querySelector('#basic-default-description')
    const textCount = document.querySelector('#textCount')

    textCount.innerHTML = `${description.value.length} 個字`;
    description.addEventListener('input', () => {
    textCount.innerHTML = `${description.value.length} 個字`;
    });
    
    const sendData = e=>{
        e.preventDefault();
        description.classList.remove('btn-outline-danger')
        textCount.classList.remove('btn-outline-danger')
        
        let isPass = true 

        if(title.value.length <= 5){
            isPass=false;
            document.querySelector('#titleError').innerHTML ='標題不能小於5個字'
            title.classList.add('btn-outline-danger')
        }
        if(description.value.length <= 5){
            isPass=false;
            document.querySelector('#descriptionError').innerHTML ='內文不能小於5個字'
            description.classList.add('btn-outline-danger')
        }

        
        if (isPass) {
          const fd = new FormData(document.forms[0]);
          fetch(`videos-edit-api.php`, {
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
