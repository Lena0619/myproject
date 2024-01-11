<!DOCTYPE html>
<html>
<head>
    <title>登入</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php if (session()->get('error')) { ?>
    <div><?php echo session()->get('error'); ?></div>
<?php } ?>

<div class="container">
    <div class="p-5 bg-light border" style="width:50%;margin:100px auto;padding:50px">
        <h3 class="mb-4">Login</h3>

        <?php
        // 檢查是否有錯誤訊息的 Flashdata
        if (session()->getFlashdata('msg') !== null) {
            $error = session()->getFlashdata('msg');
            echo '<p style="color: red;">' . $error . '</p>';
        }
        ?>

        <form action="<?php echo base_url('login/login'); ?>" method="post">
          <div class="mb-3">
            <label for="account" class="form-label">帳號</label>
            <input type="account" class="form-control" id="account" name="account" required="required">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">密碼</label>
            <input type="password" class="form-control" id="password" name="password" required="required">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div class="mt-5 ms-1 fs-5">
            <a href="<?php echo base_url('register'); ?>">註冊</a>
        </div>
    </div>
</div>

</body>
</html>