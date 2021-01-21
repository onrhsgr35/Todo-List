<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\projects;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function Home() {
        return view('index');
    }
    public function NewProject() {
        return view('create-project');
    }
    public function NewJob() {
        isset($_GET["projectID"]) ? $id=$_GET["projectID"]:$id=0;
        return view('create-job',["id"=>$id]);
    }
    public function ProjectDetail($id) {
        if(projects::where([['projectID',"=",$id],["userID","=",$_COOKIE["userID"]]])->first())
            return view('project-detail',["id"=>$id]);
        return abort(404);
    }
    public function JobDetail($id) {
        if(DB::table('jobs')->join("projects","projects.projectID","=","jobs.projectID")->join("users","users.userID","=","projects.userID")->where([['jobs.jobID',"=",$id],["users.userID","=",$_COOKIE["userID"]]])->first())
            return view('job-detail',["id"=>$id]);
        return abort(404);
    }
}
