<?php

    /**
     *$data 要循环处理的值
     *$parent_id 父级分类ID
     *$level 级别 默认为0
      @return array
     */
    function CreateTree($data,$parent_id=0,$level=0){
        if( !$data){
            return;
        }
        static $newarray = [];
        foreach($data as $k=>$v){
            if($v->parent_id == $parent_id){
                $v->level = $level;
                $newarray[] =$v;

                //调用自身
                CreateTree($data,$v->cate_id,$level+1);
            }
        }

        return $newarray;

    }

//单文件文件上传
    function uploads($filename){
        $photo = request()->file($filename);

        if ($photo->isValid()){     
            $store_result = $photo->store('uploads');
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');

    }
//多个文件上传
    function Moreuploads($filename){
       $photo = request()->file($filename);
       if(!is_array($photo)){
         return;
       } 
      //dd($photo);
       foreach( $photo as $v ){
          if ($v->isValid()){
            $store_result[] = $v->store('uploads');
          }
       }
         
       return $store_result;
    }