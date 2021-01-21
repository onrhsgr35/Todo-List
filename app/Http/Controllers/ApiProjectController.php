<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\projects;
use App\Models\jobs;

class ApiProjectController extends Controller
{
    public $res = ["status"=>"error","message"=>""];
    function ApiVariablesCheck($data,$turkishData,$method) {
        switch ($method) {
            case 'GET':
                for($i=0;$i<count($data);$i++) {
                    if(!isset($_GET[$data[$i]]) || $_GET[$data[$i]] === 0 || $_GET[$data[$i]] === '') {
                        return $turkishData[$i] . ' İsimli Değer Boş Yada Tanımsız Olamaz';
                    }
                }
                break;
            case 'POST':
                for($i=0;$i<count($data);$i++) {
                    if(!isset($_POST[$data[$i]]) || $_POST[$data[$i]] === 0 || $_POST[$data[$i]] === '') {
                        return $turkishData[$i] . ' İsimli Değer Boş Yada Tanımsız Olamaz';
                    }
                }
                break;
            default:
                return 'Bilinmeyen method';
                break;
        }
        return 'Success';
    }
    function DisplayMessage($status,$message,$data) {
        $res["status"] = $status;
        $res["message"] = $message;
        if($data != "")
            $res["data"]=$data;
        echo json_encode($res);
    }
    public function list() {
        $controlResult = $this->ApiVariablesCheck(["userID"],["Kullanıcı ID"],"GET");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        $projectsList = projects::where("userID",$_GET["userID"])->get();
        if(count($projectsList) > 0)
            $this->DisplayMessage("success","Projeler Başarı İle Listelendi",$projectsList);
        else
            $this->DisplayMessage("error","Bu Kullanıcıya Ait Proje Bulunamadı","");
        return;
    }
    public function detail() {
        $controlResult = $this->ApiVariablesCheck(["userID","projectID"],["Kullanıcı ID","Proje ID"],"GET");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        $projectDetail = projects::where([["userID","=",$_GET["userID"]],["projectID","=",$_GET["projectID"]]])->first();
        if($projectDetail) {
            $projectDetail["Jobs1"] = jobs::where([["projectID","=",$_GET["projectID"]],["jobState","=",1]])->get();
            $projectDetail["Jobs2"] = jobs::where([["projectID","=",$_GET["projectID"]],["jobState","=",2]])->get();
            $projectDetail["Jobs3"] = jobs::where([["projectID","=",$_GET["projectID"]],["jobState","=",3]])->get();
            $this->DisplayMessage("success","Proje Detayı Başarı İle Listelendi",$projectDetail);
        } else {
            $this->DisplayMessage("error","Bu Kullanıcıya Ait Proje Bulunamadı","");
        }
        return;
    }
    public function update() {
        $controlResult = $this->ApiVariablesCheck(["projectName","projectTechnician","projectID","projectDate","projectEstimatedTime"],["Proje Adı","Teknik Uzman","Proje ID","Tarih","Tahmini Süre"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        isset($_POST["projectDescription"]) == 1 ? $description=$_POST["projectDescription"]:$description="";
        isset($_POST["projectNotes"]) == 1 ? $notes=$_POST["projectNotes"]:$notes="";
        isset($_POST["projectActualTime"]) == 1 ? $actualTime=$_POST["projectActualTime"]:$actualTime="";
        $updateQuery = projects::where("projectID",$_POST["projectID"])->update([
            "projectName"=>$_POST["projectName"],
            "projectTechnician"=>$_POST["projectTechnician"],
            "projectDescription"=>$description,
            "projectNotes"=>$notes,
            "projectActualTime"=>$actualTime,
            "projectDate"=>date('Y-m-d',strtotime($_POST["projectDate"])),
            "projectEstimatedTime"=>$_POST["projectEstimatedTime"]
        ]);
        if($updateQuery)
            $this->DisplayMessage("success","Proje güncelleme işlemi başarı ile tamamlandı.","");
        else
            $this->DisplayMessage("error","Proje güncelleme işlemi sırasında hata oluştu yada değişen bir veri yok.Yönetici ile iletişime geçiniz.","");
        return;
    }
    public function add() {
        $controlResult = $this->ApiVariablesCheck(["name","technician","userID","date","estimatedTime"],["Proje Adı","Teknik Uzman","Kullanıcı ID","Tarih","Tahmini Süre"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        isset($_POST["description"]) == 1 ? $description=$_POST["description"]:$description="";
        isset($_POST["notes"]) == 1 ? $notes=$_POST["notes"]:$notes="";
        isset($_POST["actualtime"]) == 1 ? $actualTime=$_POST["actualtime"]:$actualTime="";
        $insertQuery = projects::insert([
            "userID"=>$_POST["userID"],
            "projectName"=>$_POST["name"],
            "projectTechnician"=>$_POST["technician"],
            "projectDescription"=>$description,
            "projectNotes"=>$notes,
            "projectActualTime"=>$actualTime,
            "projectDate"=>date('Y-m-d',strtotime($_POST["date"])),
            "projectEstimatedTime"=>$_POST["estimatedTime"]
        ]);
        if($insertQuery)
            $this->DisplayMessage("success","Proje oluşturma işlemi başarı ile tamamlandı.",date('Y-m-d',strtotime($_POST["date"])));
        else
            $this->DisplayMessage("error","Proje oluşturma işlemi sırasında hata oluştu.Yönetici ile iletişime geçiniz.","");
        return;
    }
    public function delete() {
        $controlResult = $this->ApiVariablesCheck(["projectID"],["Proje ID"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        if(projects::where("projectID",$_POST["projectID"])->delete())
            $this->DisplayMessage("success","Proje Başarı İle Silindi","");
        else
            $this->DisplayMessage("error","Proje Silinirken Hata İle Karşılaşıldı","");
        return;
    }
}
