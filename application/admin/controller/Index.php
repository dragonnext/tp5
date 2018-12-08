<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        $res = Db('blog_content')->select();
        dump(111);
        return $this->fetch();
    }
    public function about(){
    	return $this->fetch();
    }
    public function gbook(){
    	return $this->fetch();
    }
    public function info(){
    	return $this->fetch();
    }
    public function infopic(){
    	return $this->fetch();
    }
    public function articlelist(){
    	return $this->fetch();
    }
    public function share(){
    	return $this->fetch();
    }
}
