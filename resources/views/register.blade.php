<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GH Soft - Kayıt Ol</title>
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
            <form id="register">
                <h3 align="center">Kayıt Ol</h3>
                <div class="form-group">
                    <label>Ad</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label>Soyad</label>
                    <input type="text" class="form-control" id="surname" required>
                </div>
                <div class="form-group">
                    <label>E-Posta Adresi</label>
                    <input type="text" class="form-control" id="email" required>
                </div>
                <div class="form-group">
                    <label>Şifre</label>
                    <input type="password" class="form-control" id="pass" required>
                </div>
                <div class="form-group d-flex align-items-center">
                    <button type="submit" class="btn btn-outline-success ml-auto">Kayıt Ol</button>
                </div>
                <div class="form-group">
                    <a href="giris-yap"><small>Hesabınız var mı? Giriş yapmak için tıklayın.</small></a>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    $("#register").on("submit",function(e) {
        e.preventDefault();
        var data = {
            name:$("#name").val(),
            surname:$("#surname").val(),
            email:$("#email").val(),
            pass:$("#pass").val()
        }
        $.ajax({
            type:"POST",
            url:"api/register",
            data:data,
            success:function(res) {
                res = JSON.parse(res);
                if(res.status === "success")
                    location.href = "/giris-yap";
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
