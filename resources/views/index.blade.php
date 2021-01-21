<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GH Soft - Anasayfa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/custom.css">
</head>
<body ng-app="app" ng-controller="bodyController">
    <header>
        <nav class="navbar">
            <a class="navbar-brand" href="/">
                <img src="images/logo.png" height="60" alt="Logo">
            </a>
            <a href="api/logout" class="btn btn-danger ml-auto" name="cikisyap" type="button">Çıkış Yap</a>
        </nav>
    </header>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Anasayfa</li>
        </ol>
    </nav>
    <div class="container-fluid">
        <a href="yeni-proje-ekle" class="btn btn-sm btn-primary float-right mb-2">Yeni Proje Ekle</a>
        <a href="yeni-is-ekle" type="button" class="btn btn-sm btn-success float-right mr-2">Yeni İş Ekle</a>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Proje Adı</th>
                    <th>Teknik Uzman</th>
                    <th>Proje Tarihi</th>
                    <th class="text-right">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <tr class="ng-hide" ng-show="errorMsg != ''">
                    <td colspan="5">@{{errorMsg}}</td>
                </tr>
                <tr ng-repeat="(index,item) in projects" class="ng-hide" ng-show="projects.length > 0" ng-click="Redirect(item.projectID)">
                    <td>@{{index + 1}}</td>
                    <td>@{{item.projectName}}</td>
                    <td>@{{item.projectTechnician}}</td>
                    <td>@{{item.projectDate}}</td>
                    <td align="right"><a href="javascript:void(0)" ng-click="deleteProject(item.projectID)"><i class="fa fa-trash text-danger"></i></a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
<script src="js/custom.js"></script>
<script>
    var app = angular.module('app', []);
    app.controller("bodyController",function bodyController($scope) {
        var parent = $scope;
        parent.projects = [];
        parent.errorMsg = '';
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
        parent.deleteProject = function(projectID) {
            $.ajax({
                type:"POST",
                url:"api/projects/delete",
                data:{projectID:projectID},
                success:function(res) {
                    res = JSON.parse(res);
                    alert(res.message);
                    location.reload();
                    parent.$apply();
                },
                error:function(err) {
                    alert("Tanımlanamayan sistem hatası lütfen sistem yöneticisine başvurun");
                    console.log(err);
                }
            })
        }
        parent.Redirect = function(projectID) {
            location.href = "projeler/"+projectID;
        }
        parent.LoadProjects();
    });

</script>
</html>
