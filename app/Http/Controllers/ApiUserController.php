<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\Redirect;

class ApiUserController extends Controller
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
    public function Login() {
        $controlResult = $this->ApiVariablesCheck(["email","pass","rememberme"],["E-Posta","Şifre","Beni Hatırla"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        $emailControl = users::where("userEmail",$_POST["email"])->first();
        if(!$emailControl) {
            $this->DisplayMessage("error","Bu E-Posta Adresine Ait Bir Kullanıcı Mevcut Değil","");
            return;
        }
        if(!password_verify($_POST["pass"],$emailControl["userPassword"])) {
            $this->DisplayMessage("error","Girmiş Olduğunuz Şifre Yanlış","");
        } else {
            $expireDate = 0;
            if($_POST["rememberme"])
                $expireDate = time() + (60 * 60 * 24 * 365);
            setcookie("userID",$emailControl["userID"],$expireDate,"/");
            $this->DisplayMessage("success","Başarıyla giriş yaptınız.","");
        }
        return;
    }
    public function Register() {
        $controlResult = $this->ApiVariablesCheck(["name","surname","email","pass"],["Ad","Soyad","E-Posta","Şifre"],"POST");
        if($controlResult != "Success") {
            $this->DisplayMessage("error",$controlResult,"");
            return;
        }
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $this->DisplayMessage("error","Geçersiz E-Posta Adresi","");
            return;
        }
        $emailControl = users::where("userEmail",$_POST["email"])->first();
        if($emailControl) {
            $this->DisplayMessage("error","Bu E-Posta Adresine Ait Bir Kullanıcı Mevcut","");
            return;
        }
        $insertQuery = users::insert([
            "userName"=>$_POST["name"],
            "userSurname"=>$_POST["surname"],
            "userEmail"=>$_POST["email"],
            "userPassword"=>password_hash($_POST["pass"],PASSWORD_BCRYPT)
        ]);
        if($insertQuery)
            $this->DisplayMessage("success","Kayıt işlemi başarı ile tamamlandı.","");
        else
            $this->DisplayMessage("error","Kayıt işlemi sırasında hata oluştu.Yönetici ile iletişime geçiniz.","");
        return;
    }
    public function Logout() {
        setcookie("userID","",time()-3600,"/");
        return Redirect::to('/giris-yap');
    }
}
