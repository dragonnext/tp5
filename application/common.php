<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//上传图片返回Jason数组--url
function uploadimg($file,$folder,$type = 'json'){
    $file = request()->file('file');
    if(isset($file)){
        // 获取表单上传文件 例如上传了001.jpg  
        // 移动到框架应用根目录/public/uploads/ 目录下  
        $info = $file->move('uploads/'.$folder); 
        if($info){  
            // 成功上传后 获取上传信息  
            $a=$info->getSaveName(); 
            $imgp= str_replace("\\","/",$a);  
            $imgpath=$imgp;  
            $data['status']=0;
            $data['url']= $imgpath;
        }else{  
        // 上传失败获取错误信息 
            $data['status']=1;    
        } 
    }
    if($type == "json"){
        return json($data);
    }else{
        return $data;
    }
}