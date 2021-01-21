<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GH Soft - Proje Oluştur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <link rel="stylesheet" href="css/custom.css">
</head>
<body ng-app="app" ng-controller="bodyController">
    <header>
        <nav class="navbar">
            <a class="navbar-brand" href="/">
                <img src="images/logo.png" height="60" alt="">
            </a>
            <a href="api/logout" class="btn btn-danger ml-auto" type="button">Çıkış Yap</a>
        </nav>
    </header>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Yeni Proje Ekle</li>
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Yeni Proje Ekle
            </div>
            <div class="card-body">
                <form class="row" ng-submit="createProject()">
                    <div class="col-lg-2 col-md-3 align-items-center d-flex">
                        <h1>GH Soft</h1>
                    </div>
                    <div class="col-md-6 bg-dark align-items-center justify-content-center d-flex">
                        <h1 class="text-white">Teknik Kart</h1>
                    </div>
                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <label>Tarih</label>
                            <input type="date" class="form-control" ng-model="project.date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label>Kart No</label>
                            <input type="text" class="form-control" id="kartno" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Proje Adı</label>
                        <input type="text" class="form-control" ng-model="project.name" name="name" required>
                        <label>Teknik Uzman</label>
                        <input type="text" class="form-control" ng-model="project.technician" name="technician" required>
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-4 form-group">
                        <label>Tahmini Süre</label>
                        <input type="text" class="form-control" ng-model="project.estimatedTime" disabled>
                        <label>Gerçekleşen Süre</label>
                        <input type="text" class="form-control" ng-model="project.actualtime" name="actualtime">
                    </div>
                    <div class="col-12 form-group">
                        <label>Açıklama</label>
                        <textarea class="form-control" style="height: 300px;" ng-model="project.description" id="desc" name="desc"></textarea>
                    </div>
                    <div class="col-12 form-group">
                        <label>Notlar</label>
                        <textarea class="form-control" style="height: 300px;" ng-model="project.notes" name="notes"></textarea>
                    </div>
                    <div class="col-12 form-group">
                        <button type="submit" class="btn btn-primary float-right" name="create">Oluştur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="js/custom.js"></script>
<script>
    var app = angular.module('app', []);
    app.controller("bodyController",function bodyController($scope) {
        var parent = $scope;
        parent.project = {userID:getCookie("userID")};
        parent.project.estimatedTime=0;
        parent.createProject = function() {
            parent.projectCopy = Object.assign({},parent.project);
            parent.projectCopy.date = (new Date(parent.project.date)).toLocaleDateString();
            $.ajax({
                type:"POST",
                url:"api/projects/add",
                data:parent.projectCopy,
                success:function(res) {
                    res = JSON.parse(res);
                    alert(res.message);
                    if(res.status === "success")
                        location.href="/";
                    parent.$apply();
                },
                error:function(err) {
                    alert("Tanımlanamayan sistem hatası lütfen sistem yöneticisine başvurun");
                    console.log(err);
                }
            })
        }
        $("#desc").on("input",function() {
            var currentLength = $(this).val().length;
            parent.project.estimatedTime = Math.floor(currentLength/4);
        });
    });
</script>
</html>
