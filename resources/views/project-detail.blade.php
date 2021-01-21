<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GH Soft - Proje Detayı</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/custom.css">
    <script>

        function Redirect(jobID) {
            console.log(jobID);
            location.href = "../isler/"+jobID;
        }

        function jobDelete(jobID) {
            $.ajax({
                type:"POST",
                url:"../api/jobs/delete",
                data:{jobID:jobID},
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
    </script>
</head>
<body ng-app="app" ng-controller="bodyController">
    <header>
        <nav class="navbar">
            <a class="navbar-brand" href="/">
                <img src="../images/logo.png" height="60" alt="">
            </a>
            <a href="api/logout" class="btn btn-danger ml-auto" type="button">Çıkış Yap</a>
        </nav>
    </header>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page">@{{project.projectName}}</li>
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                @{{project.projectName}}
            </div>
            <div class="card-body">
                <form class="row" ng-submit="updateProject()">
                    <div class="col-lg-2 col-md-3 align-items-center d-flex">
                        <h1>GH Soft</h1>
                    </div>
                    <div class="col-md-6 bg-dark align-items-center justify-content-center d-flex">
                        <h1 class="text-white">Teknik Kart</h1>
                    </div>
                    <div class="col-lg-4 col-md-3">
                        <div class="form-group">
                            <label>Tarih</label>
                            <input type="date" class="form-control" ng-model="project.projectDate" required>
                        </div>
                        <div class="form-group">
                            <label>Kart No</label>
                            <input type="text" class="form-control" id="kartno" ng-model="project.projectID" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Proje Adı</label>
                        <input type="text" class="form-control" ng-model="project.projectName" required>
                        <label>Teknik Uzman</label>
                        <input type="text" class="form-control" ng-model="project.projectTechnician" required>
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-4 form-group">
                        <label>Tahmini Süre</label>
                        <input type="text" class="form-control" ng-model="project.projectEstimatedTime" disabled>
                        <label>Gerçekleşen Süre</label>
                        <input type="text" class="form-control" ng-model="project.projectActualTime">
                    </div>
                    <div class="col-12 form-group">
                        <label>Açıklama</label>
                        <textarea class="form-control" style="height: 300px;" ng-model="project.projectDescription" id="desc"></textarea>
                    </div>
                    <div class="col-12 form-group">
                        <label>Notlar</label>
                        <textarea class="form-control" style="height: 300px;" ng-model="project.projectNotes"></textarea>
                    </div>
                    <div class="col-12 form-group">
                        <a href="../yeni-is-ekle" type="button" class="btn btn-success float-left">Yeni İş Ekle</a>
                        <button type="submit" class="btn btn-primary float-right">Güncelle</button>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Yapılacak
                            </div>
                            <div class="card-body">
                                <ul class="list-group item-gray" data-jobState="1">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Yapılıyor
                            </div>
                            <div class="card-body">
                                <ul class="list-group item-yellow" data-jobState="2">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Tamamlandı
                            </div>
                            <div class="card-body">
                                <ul class="list-group item-green" data-jobState="3">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/custom.js"></script>
<script>
    $( function() {
        $(".card-body ul").sortable({
            connectWith: ".list-group",
            remove: function( event, ui ) {
                var data = {
                    jobState:$(ui.item).parent().attr("data-jobState"),
                    jobID:$(ui.item).attr("data-id")
                }
                $.ajax({
                    type:"POST",
                    url:"../api/jobs/stateUpdate",
                    data:data,
                    success:function(res) {
                        res = JSON.parse(res);
                        console.log(res);
                        if(res.status === "error")
                            alert(res.message);
                    },
                    error:function(err) {
                        alert("Tanımlanamayan sistem hatası lütfen sistem yöneticisine başvurun");
                        console.log(err);
                    }
                })
            }
        }).disableSelection();

    });
    var app = angular.module('app', []);
    app.controller("bodyController",function bodyController($scope) {
        var parent = $scope;
        var projectID = "{{$id}}";
        parent.updateProject = function() {
            parent.projectCopy = Object.assign({},parent.project);
            parent.projectCopy.projectDate = (new Date(parent.project.projectDate)).toLocaleDateString();
            $.ajax({
                type:"POST",
                url:"../api/projects/update",
                data:parent.projectCopy,
                success:function(res) {
                    res = JSON.parse(res);
                    console.log(res);
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
        parent.projectLoad = function(projectID) {
            $.ajax({
                type:"GET",
                url:"../api/projects/detail",
                data:{projectID:projectID,userID:getCookie("userID")},
                success:function(res) {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.status === "success") {
                        parent.project = res.data;
                        parent.project.projectDate = new Date(parent.project.projectDate);
                        for(var i=1;i<=3;i++) {
                            var text="";
                            for(var j=0;j<parent.project["Jobs"+i].length;j++) {
                                var job = parent.project["Jobs"+i][j];
                                text += '<li class="list-group-item" data-id="'+job.jobID+'">\
                                    <span class="actions">\
                                        <i class="fa fa-trash" onClick="jobDelete('+job.jobID+')"></i>\
                                        <i class="fa fa-edit" onClick="Redirect('+job.jobID+')"></i>\
                                    </span>\
                                    <h4>'+job.jobTitle+'</h4>\
                                    <span>'+job.jobDescription+'</span>\
                                    </li>';
                            }
                            $('*[data-jobState="'+i+'"]').html(text);
                        }
                    }
                    parent.$apply();
                },
                error:function(err) {
                    alert("Tanımlanamayan sistem hatası lütfen sistem yöneticisine başvurun");
                    console.log(err);
                }
            })
        }
        parent.projectLoad(projectID);
        $("#desc").on("input",function() {
            var currentLength = $(this).val().length;
            parent.project.projectEstimatedTime = Math.floor(currentLength/4);
        });
    });
</script>
</html>
