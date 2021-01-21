<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jobs;
use App\Models\projects;

class ApiJobController extends Controller
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
    public function stateUpdate() {
        $controlResult = $this->ApiVariablesCheck(["jobState","jobID"],["İş Durumu","İş ID"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        $updateQuery = jobs::where("jobID",$_POST["jobID"])->update([
            "jobState"=>$_POST["jobState"]
        ]);
        if($updateQuery)
            $this->DisplayMessage("success","İş güncelleme işlemi başarı ile tamamlandı.","");
        else
            $this->DisplayMessage("error","İş güncelleme işlemi sırasında hata oluştu.Yönetici ile iletişime geçiniz.","");
        return;
    }
    public function detail() {
        $controlResult = $this->ApiVariablesCheck(["jobID"],["İş ID"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        $jobDetail = jobs::where("jobID",$_POST["jobID"])->first();
        if($jobDetail) {
            $project = projects::select("projectName")->where("projectID",$jobDetail["projectID"])->first();
            $jobDetail["projectName"] = $project["projectName"];
            $this->DisplayMessage("success","Başarı ile iş detayı getirildi.",$jobDetail);
        }else {
            $this->DisplayMessage("error","İş detayı işlemi sırasında hata oluştu.Yönetici ile iletişime geçiniz.","");
        }
        return;
    }
    public function update() {
        $controlResult = $this->ApiVariablesCheck(["jobTitle","jobID"],["İş Adı","İş ID"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        isset($_POST["jobDescription"]) == 1 ? $description=$_POST["jobDescription"]:$description="";
        $updateQuery = jobs::where("jobID",$_POST["jobID"])->update([
            "jobTitle"=>$_POST["jobTitle"],
            "jobDescription"=>$description,
        ]);
        if($updateQuery)
            $this->DisplayMessage("success","İş güncelleme işlemi başarı ile tamamlandı.","");
        else
            $this->DisplayMessage("error","İş güncelleme işlemi sırasında hata oluştu.Yönetici ile iletişime geçiniz.","");
        return;
    }
    public function add() {
        $controlResult = $this->ApiVariablesCheck(["jobTitle","projectID"],["İş Adı","Proje ID"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        isset($_POST["jobDescription"]) == 1 ? $description=$_POST["jobDescription"]:$description="";
        $insertQuery = jobs::insert([
            "jobTitle"=>$_POST["jobTitle"],
            "jobDescription"=>$description,
            "projectID"=>$_POST["projectID"]
        ]);
        if($insertQuery)
            $this->DisplayMessage("success","İş oluşturma işlemi başarı ile tamamlandı.","");
        else
            $this->DisplayMessage("error","İş oluşturma işlemi sırasında hata oluştu.Yönetici ile iletişime geçiniz.","");
        return;
    }
    public function delete() {
        $controlResult = $this->ApiVariablesCheck(["jobID"],["İş ID"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        if(jobs::where("jobID",$_POST["jobID"])->delete())
            $this->DisplayMessage("success","İş Başarı İle Silindi","");
        else
            $this->DisplayMessage("error","İş Silinirken Hata İle Karşılaşıldı","");
        return;
    }
}
