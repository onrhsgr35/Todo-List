<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GH Soft - İş Oluştur</title>
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
            <li class="breadcrumb-item active" aria-current="page">Yeni İş Ekle</li>
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Yeni İş Ekle
            </div>
            <div class="card-body">
                <form class="row" ng-submit="createJob()">
                    <div class="col-md-3 form-group">
                        <label>Proje</label>
                        <select class="form-control" ng-model="job.projectID" name="project" required>
                            <option disabled ng-value="0">Lütfen Seçim Yapınız</option>
                            <option ng-repeat="item in projects" ng-value="item.projectID" ng-selected="item.projectID==job.projectID">@{{item.projectName}}</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>İş Adı</label>
                        <input type="text" class="form-control" ng-model="job.jobTitle" name="title" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>İş Açıklaması</label>
                        <input type="text" class="form-control" ng-model="job.jobDescription" name="desc">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>İş Durumu</label>
                        <input type="text" class="form-control" value="Yapılacak" disabled>
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
        parent.projects = [];
        parent.job = {
            projectID:0,
            jobTitle:"",
            jobDescription:""
        }
        parent.createJob = function() {
            if(!parent.job.projectID) {
                alert("Lütfen bir proje seçiniz.");
                return;
            }
            $.ajax({
                type:"POST",
                url:"api/jobs/add",
                data:parent.job,
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
        parent.LoadProjects = function() {
            var data = {
                userID:getCookie("userID")
            }
            $.ajax({
                type:"GET",
                url:"api/projects/list",
                data:data,
                success:function(res) {
                    res = JSON.parse(res);
                    if(res.status === "success")
                        parent.projects = res.data;
                    else
                        parent.errorMsg = res.message;
                    parent.$apply();
                },
                error:function(err) {
                    alert("Tanımlanamayan sistem hatası lütfen sistem yöneticisine başvurun");
                    console.log(err);
                }
            })
        }
        parent.LoadProjects();
    });
</script>
</html>
