<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Login extends Controller{
	public function _initialize()
	{
	  error_reporting(E_ERROR | E_WARNING | E_PARSE);
	  $this->uid = $uid = Session::get('id');
	  if (!isset($uid)){
	    $this->redirect('Login1/index');
	  }
	  // dump(1111);
	  // $user_info = Db('user')->where('id',$uid)->find();
	  // $this->assign('user_info',$user_info);
	  // $this->project_id = $user_info['projectid'] ? $user_info['projectid'] : 1;
	  // Session::set('project_id',$user_info['projectid']);
	  // $this->assign('projectinfo',db('project_management')->where('id',$user_info['projectid'])->find());
	  // $this->assign('project_id', $this->project_id);
	  // $this->assign('studylog',Session::get('studylog'));
	  // $this->assign('option_type',array("radio"=>"单项","checkbox"=>"多项"));
	  // $this->assign("uid",$this->uid);
	}
	// public function index(){
	// 	return $this->fetch();
	// }
	
	public function fabu(){
		return $this->fetch();
	}
	public function article(){
		$res = db('blog_content')->select();
		foreach ($res as $key => $value) {
			$res[$key]['commentnum'] = db('blog_comment')->where('fid',$res[$key]['id'])->count();
		}
		$this->assign('res',$res);
		return $this->fetch();
	}
	public function articledelete(){
		$id = input('id');
		$res = db('blog_content')->where('id',$id)->delete();
		if($res==0){
			echo 0;//删除失败
		}else{
			return $this->redirect('article');
		}

	}
	public function xiugai(){
		$id = input('id');
		$res = db('blog_content')->where('id',$id)->find();

		// dump($res);
		$this->assign('con',$res);
		return $this->fetch();
	}
	public function updatecon(){
		// $type = input('type');
		// $con = input('con');
		// $title = input('title');
		// $data['createtime'] = time();
		// $data['content'] = $con;
		// $data['title'] = $title;
		// $data['fid'] = $type;
		// $res = db('blog_content')->insert($data);
		// if($res == 1){
		// 	echo 0;//文章保存成功
		// }else{

		// }
		$id = input('id');
		$type = input('type');
		$con = input('con');
		$title = input('title');
		$data['updatetime'] = time();
		$data['content'] = $con;
		$data['title'] = $title;
		$data['fid'] = $type;
		$res = db('blog_content')->where('id',$id)->update($data);
		if($res==0){
			echo 0;//更新失败
		}else{
			echo 1;//更新成功
		}
	}
	public function replay(){
		$res = db('blog_comment')->alias('a')
		->join('blog_content i','a.fid=i.id')
		->field('a.id,a.content,a.createtime,a.comment_name,i.title,a.key')
		->where('key','0')
		->select();
		// dump($res);
		// $res = db('blog_comment')->where('key','0')->select();
		// dump($res);
		$this->assign('con',$res);
		return $this->fetch();
	}
	public function replaycon(){
		$id = input('id');
		// $res = db('blog_comment')->alias('a')
		// ->join('blog_content i','a.fid=i.id')
		// ->field('a.id,a.content,a.createtime,a.comment_name,i.title,a.key')
		// ->where('key','0')
		// ->select();
		$huifu = db('blog_comment')->where('idh',$id)->find();
		// dump($huifu);
		$res = db('blog_comment')->where('id',$id)->find();
		$name = db('blog_content')->where('id',$res['fid'])->value('title');
		$res['title'] = $name;
		// dump($res);
		$this->assign('hf',$huifu);
		$this->assign('con',$res);
		return $this->fetch();
	}
	public function replayh(){
		$con = input('con');
		$id = input('id');
		$data['content'] = $con;
		$data['idh'] = $id;
		$data['createtime'] = time();
		$data['comment_name'] = 'me';
		$data['email'] = 'me';
		$data['key'] = 2;
		$res = db('blog_comment')->insert($data);
		if($res == 1){
			db('blog_comment')->where('id',$id)->update(['key' => 1]);
		}else{
			echo 0;//成功回复
		}
	}
	public function delete_comment(){
		$id = input('id');
		$res = db('blog_comment')->where('id',$id)->delete();
		if($res==0){
			echo 0;//删除失败
		}else{
			return $this->redirect('replay');
		}
		
	}
    //上传图片
	public function upload(){
        $uid=Session::get('id');
		$file=$_FILES['file'];
		$datas = uploadimg($file,'userimg','string');
        $img['img']="http://".$_SERVER['HTTP_HOST']."/uploads/userimg/".$datas['url'];
        $img['createtime'] = time();
        $img['fid'] = 111;
        $res=db('bolgimg')->insert($img);
        // $res=db('blogimg')->where('id',$uid)->update($img);
        // if($res){
        //     $res=1;
        // }else{
        //     $res=0;
        // };
        $backimg['code'] = 0;
        $backimg['data']['src'] = $img['img'];
        // $backimg['data']['title'] = $datas;
  //       $backimg = {
		//   "code": 0 //0表示成功，其它失败
		//   ,"msg": "" //提示信息 //一般上传失败后返回
		//   ,"data": {
		//     "src": $img['img']
		//     ,"title": "图片名称" //可选
		//   }
		// };
		// return json_encode($backimg);
		return json($backimg);

	}
	public function wztj(){
		$type = input('type');
		$con = input('con');
		$title = input('title');
		$data['createtime'] = time();
		$data['content'] = $con;
		$data['title'] = $title;
		$data['fid'] = $type;
		$res = db('blog_content')->insert($data);
		if($res == 1){
			echo 0;//文章保存成功
		}else{
			echo 1;//文章保存失败
		}
	}
	public function loginout(){
		session('id', null);
		return $this->redirect('/');
	}
}
?>