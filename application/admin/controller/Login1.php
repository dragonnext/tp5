<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Login1 extends Controller{
	public function index(){
		return $this->fetch();
	}
	public function login(){
		$username = input('username');
		$password = input('password');
		$res = db('blogger')->where('username',$username)->where('password',$password)->find();
		if(empty($res)){
			echo '1';
		}else{
			Session::set('id',$res['id']);
			Session::set('username',$res['username']);
			echo '0';
		}
		// echo $res;
		// return json($username.'==='.$password);
	}
}
?>