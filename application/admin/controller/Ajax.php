<?php
namespace app\index\controller;
use think\Controller;
class Ajax extends Controller{
	public function ajax(){
		// return json('1');
		echo $_GET['callbackparam']."(".json_encode(1).")";
	}
}
?>