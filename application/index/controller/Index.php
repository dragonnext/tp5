<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $res = Db('blog_content')->paginate(5);
        $type = db('blog_category')->select();
        foreach ($type as $key => $value) {
            $type[$key]['num'] = db('blog_content')->where('fid',$type[$key]['id'])->count();
        };
        // dump($res);
        $this->assign('type',$type);
        $this->assign('info',$res);
        return $this->fetch();
    }
    public function about(){
    	return $this->fetch();
    }
    public function gbook(){
    	return $this->fetch();
    }
    public function info(){
        $id = input('id');
        db('blog_content')->where('id',$id)->setInc('click');
        $res = db('blog_content')->where('id',$id)->find();
        $comment = db('blog_comment')->where('fid',$id)->select();
        foreach ($comment as $key => $value) {
            $comment[$key]['child'] = db('blog_comment')->where('idh',$comment[$key]['id'])->find();
        }
        $next = db('blog_content')->where('id','gt',$id)->find();
        $prev = db('blog_content')->where('id','lt',$id)->find();
        // dump($comment);
        $this->assign('comment',$comment);
        $this->assign('con',$res);
        $this->assign('next',$next);
        $this->assign('prev',$prev);
    	return $this->fetch();
    }
    public function fabulous(){
        $id = input('id');
        $res = db('blog_content')->where('id',$id)->setInc('fabulous');

        if($res==1){
            echo 1;//点击成功
        }else{
            echo 0;//点赞失败
        }
    }
    public function comment(){
        $name = input('author');
        $email = input('email');
        $comment = input('comment');
        $fid = input('id');
        $data['content'] = $comment;
        $data['email'] = $email;
        $data['comment_name'] = $name;
        $data['createtime'] = time();
        $data['fid'] = $fid;
        $res = db('blog_comment')->insert($data);
        if($res==1){
            echo 0;//数据插入成功
        }
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
