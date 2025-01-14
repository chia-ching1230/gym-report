<?php require __DIR__ . '/includes/init.php';?>
<?php
$title = "新增文章";
$pageName = "article-add"; 
?>
<?php include __DIR__ . '/includes/html-header.php'; ?>
<?php include __DIR__ . '/includes/html-sidebar.php'; ?>
<?php include __DIR__ . '/includes/html-layout-navbar.php'; ?>
<?php include __DIR__ . '/includes/html-content wrapper-start.php'; ?>

<div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">新增文章</h5> 
        <small class="text-muted float-end"> <a href="./article.php" class="nav-link">回到文章列表</a>
        </small>
      </div>
      <div class="card-body">
        <form onsubmit="sendData(event)">
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-title">標題</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="basic-default-title" placeholder="請輸入標題" name="title">
              <div id="titleError"  style="color: red;" class="mt-3"></div>
            </div>
            
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="basic-default-author">作者工號</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="basic-default-author_id" name="author_id" placeholder="請輸入工號" require >
              <div id="author_idError"  class="mt-3" style="color: red;" ></div>
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="basic-default-content">文章內容</label>
            <div class="col-sm-10">
              <textarea id="basic-default-content" class="form-control" placeholder="請輸入文章內容" rows="9" name="content" ></textarea>
              <div id="contentError"  class="mt-3" style="color: red;"></div>
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
          <a href="./article.php" class="nav-link">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> 
            <i class="fa-solid fa-door-open me-4"></i>回到列表</a>
            </button>
        </div>
    </div>
    </div>
</div>

<script>
    const title = document.querySelector('#basic-default-title')
    const content = document.querySelector('#basic-default-content')
    const author_id = document.querySelector('#basic-default-author_id')
    const textCount = document.querySelector('#textCount')
    
    content.addEventListener('input', () => {
    textCount.innerHTML = `${content.value.length} 個字`;
    });
    
    const sendData = e=>{
        e.preventDefault();
        content.classList.remove('btn-outline-danger')
        document.querySelector('#contentError').innerHTML =''
        title.classList.remove('btn-outline-danger')
        document.querySelector('#titleError').innerHTML =''
        author_id.classList.remove('btn-outline-danger')
        document.querySelector('#author_idError').innerHTML=''
        
        let isPass = true 

        if(title.value.length <= 4){
            isPass=false;
            document.querySelector('#titleError').innerHTML ='標題不能小於5個字'
            title.classList.add('btn-outline-danger')
        }
        if(author_id.value.length !== 6){
            isPass=false;
            document.querySelector('#author_idError').innerHTML ='工號錯誤 ( 提示：6碼 )'
            author_id.classList.add('btn-outline-danger')
        }
        if(content.value.length < 30){
            isPass=false;
            document.querySelector('#contentError').innerHTML ='內文不能小於30個字'
            content.classList.add('btn-outline-danger')
        }
        

        
        if (isPass) {
          const fd = new FormData(document.forms[0]);
          const myModal = new bootstrap.Modal('#success-modal')
          fetch(`article-add-api.php`, {
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
