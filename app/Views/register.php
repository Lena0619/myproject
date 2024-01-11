<!DOCTYPE html>
<html>
<head>
    <title>註冊</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php if (session()->get('error')) { ?>
    <div><?php echo session()->get('error'); ?></div>
<?php } ?>

<div class="container">
    <div class="p-3 bg-light border" style="width:50%;margin:20px auto;padding:50px">
        <h3 class="mb-4">Register</h3>

        <?php
        // 檢查是否有錯誤訊息的 Flashdata
        if (session()->getFlashdata('msg') !== null) {
            $error = session()->getFlashdata('msg');
            echo '<p style="color: red;">' . $error . '</p>';
        }
        ?>

        <form action="<?php echo base_url('register/process'); ?>"  enctype="multipart/form-data" method="post">
            <div class="mb-3">
              <label for="org_id" class="form-label"><font style="color:red">* </font>單位</label>
              <div class="row g-2 align-items-center">
                <div class="col-10">
                    <select class="form-select" class="form-control" name="org_id" id="org_id" required='required'>
                      <option value="">請選擇</option>
                      <?php if ($orgs): ?>
                          <ul>
                              <?php foreach ($orgs as $org): ?>
                                  <option value="<?php echo $org['id']; ?>"><?php echo $org['title']; ?></option>
                              <?php endforeach; ?>
                          </ul>
                      <?php endif; ?>
                    </select>
                </div>
                <div class="col-2">
                    <button class="btn btn-outline-secondary btn-sm ms-2" id="addorg" type="button" style="width:90%">新增</button>
                </div>
                <div class="col-12" id="addorg_container" style="display:none">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="輸入單位名稱" id="new_org">
                      <button class="btn btn-outline-success" type="button" id="addorg_submit">確認</button>
                      <button class="btn btn-outline-dark" type="button" id="addorg_cancel">取消</button>
                    </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="name" class="form-label"><font style="color:red">* </font>姓名</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="" required='required'>
            </div>
            <div class="mb-3">
              <label for="account" class="form-label"><font style="color:red">* </font>帳號</label>
              <input type="text" class="form-control" name="account" id="account" placeholder="" required='required'>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label"><font style="color:red">* </font>密碼</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="" required='required'>
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">生日</label>
              <input type="date" class="form-control" name="birthday" id="birthday" placeholder="">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label"><font style="color:red">* </font>Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="" required='required'>
            </div>
            <div class="mb-3">
              <label for="csvfile" class="form-label"><font style="color:red">* </font>申請資格CSV檔上傳</label>
              <input type="file" class="form-control" name="csvfile" id="csvfile" placeholder="" required='required'>
            </div>


            <button type="submit" class="btn btn-primary mt-4" id="btSubmit">Submit</button>

            <div class="mt-5 ms-1 fs-5">
                <a href="<?php echo base_url('login'); ?>">登入</a>
            </div>
        </form>
    </div>
</div>

</body>
<script type="text/javascript">
    $(function(){
        $('button#addorg').click(function(){
            $('div#addorg_container').css('display','block');
            $('button#addorg').css('display','none');
        });

        $('button#addorg_cancel').click(function(){
            $('#new_org').val("");
            $('#new_org').css("border", "1px solid #dee2e6");
            $('button#addorg').css('display','block');
            $('div#addorg_container').css('display','none');
        });

        $('button#addorg_submit').click(function(){
            var org = $('#new_org').val();
            if (org === "") {
                $('#new_org').css("border", "1.5px solid rgb(255, 0, 0)");
                return false;
            }
            $.ajax({
                type:'POST',
                url: globalThis.location + '/add_new_org',
                data:{new_org:org},
                success: function(response){
                    console.log(response);
                    $('#new_org').val("");
                    $('#new_org').css("border", "1px solid #dee2e6");
                    $('button#addorg').css('display','block');
                    $('div#addorg_container').css('display','none');
                    window.location = window.location.href;
                },
                error: function(error){
                    console.log(error);
                    $('#new_org').val("");
                    $('#new_org').css("border", "1px solid #dee2e6");
                    $('button#addorg').css('display','block');
                    $('div#addorg_container').css('display','none');
                }
            })
        });
    })
</script>
</html>