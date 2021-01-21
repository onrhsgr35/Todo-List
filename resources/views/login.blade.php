<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GH Soft - Giriş Yap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="row">
        <div class="col-md-6 loginLeft">
            <img src="images/logo.png" alt="Logo">
        </div>
        <div class="col-md-6 loginRight">
            <form type="POST" id="login" class="needs-validation">
                <h3 align="center">Giriş Yap</h3>
                <div class="form-group">
                    <label>E-Posta Adresi</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Şifre</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <div class="form-group d-flex align-items-center">
                    <input type="checkbox" id="rememberme" name="rememberme">
                    <label for="rememberme" class="mb-0 ml-1">Beni Hatırla</label>
                    <button type="submit" name="login" class="btn btn-outline-success ml-auto">Giriş Yap</button>
                </div>
                <div class="form-group">
                    <a href="kayit-ol"><small>Hesabınız yok mu? Kayıt olmak için tıklayın.</small></a>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    $("#login").on("submit",function(e) {
        e.preventDefault();
        var data = {
            email:$("#email").val(),
            pass:$("#pass").val(),
            rememberme:$("#rememberme").prop("checked") == true ? 1:0
        }
        $.ajax({
            type:"POST",
            url:"api/login",
            data:data,
            success:function(res) {
                res = JSON.parse(res);
                if(res.status === "success")
                    location.href = "/";
                else
                    alert(res.message);
            },
            error:function(err) {
                alert("Tanımlanamayan sistem hatası lütfen sistem yöneticisine başvurun");
                console.log(err);
            }
        })
    });
</script>
</html>
