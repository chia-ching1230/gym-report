<?php require __DIR__ . '/includes/init.php';?>
<?php
$title = "編輯最新消息";
$pageName = "gymNews-edit"; 
$news_id = empty($_GET['news_id'])? 0 : intval($_GET['news_id']);
if(empty($news_id)){
    header('Location: gymNews.php');
    exit;
}

$sql="SELECT * FROM gym_news WHERE news_id = $news_id";
$r = $pdo->query($sql)->fetch();
if(empty($r)){
    header('Location: gymNews.php');
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
        <h5 class="mb-0">編輯最新消息</h5> 
        <small class="text-muted float-end"> <a href="./gymNews.php" class="nav-link">回到最新消息列表</a>
        </small>
      </div>
      <div class="card-body">
        <form onsubmit="sendData(event)">
            <input type="hidden" class="form-control" name="news_id" value="<?=$r['news_id'] ?>" >    
            <div class="row mb-6">
                <label class="col-sm-2 col-form-label" for="basic-default-new_id">最新消息ID</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-new_id" name="news_id" value="<?=$r['news_id'] ?>" disabled >
                </div>
            </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-title">標題</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-title" placeholder="請輸入標題" name="title" value="<?=$r['title']?>">
              <div id="titleError" class="mt-3" style="color: red;"></div>
            </div>
            
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-author">發布者</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-author" name="author_id" placeholder="請輸入發布者工號" min=1  value="<?=$r['author_id']?>" require>
              <div id="authorError" class="mt-3" style="color: red;"></div>
            </div>
            
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="basic-default-content">文章內容</label>
            <div class="col-sm-10">
              <textarea id="basic-default-content" class="form-control" placeholder="請輸入最新消息內容" aria-describedby="basic-icon-default-message2" rows="3" name="content" ><?=$r['content']?></textarea>
              <div id="contentError" class="mt-3" style="color: red;"></div>
            </div>
          </div>
          <div class="row" >
            <div class="col-12">
                <small class="text-muted float-end" id="textCount">0 個字</small>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-checkbox" >發布狀態</label >
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-6">
                        <select id="sendNotification" class="form-select" name="uploadStatus">
                            <option value="1"  <?=($r['uploadStatus'] == 1) ? 'selected' : ''; ?>>發布</option>
                            <option value="0" <?=($r['uploadStatus'] == 0) ? 'selected' : ''; ?>>未發布</option>
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymNews.php" class="nav-link">
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
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> <a href="./gymNews.php" class="nav-link">
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
    const content = document.querySelector('#basic-default-content')
    const textCount = document.querySelector('#textCount')
    const author = document.querySelector('#basic-default-author')

    textCount.innerHTML = `${content.value.length} 個字`;
    content.addEventListener('input', () => {
    textCount.innerHTML = `${content.value.length} 個字`;
    });
    
    const sendData = e=>{
        e.preventDefault();
        content.classList.remove('btn-outline-danger')
        document.querySelector('#contentError').innerHTML =''
        title.classList.remove('btn-outline-danger')
        document.querySelector('#titleError').innerHTML =''
        author.classList.remove('btn-outline-danger')
        document.querySelector('#authorError').innerHTML=''
        
        
        let isPass = true 

        if(title.value.length < 3){
            isPass=false;
            document.querySelector('#titleError').innerHTML ='標題不能小於3個字'
            title.classList.add('btn-outline-danger')
        }
        if(content.value.length < 10){
            isPass=false;
            document.querySelector('#contentError').innerHTML ='內文不能小於10個字'
            content.classList.add('btn-outline-danger')
        }
        if(author.value.length !== 8){
            isPass=false;
            document.querySelector('#authorError').innerHTML ='工號錯誤 ( 提示：8碼 )'
            author.classList.add('btn-outline-danger')
        }


        
        if (isPass) {
          const fd = new FormData(document.forms[0]);
          fetch(`gymNews-edit-api.php`, {
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
