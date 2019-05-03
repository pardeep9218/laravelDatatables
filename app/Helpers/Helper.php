<?php

function displayMessage()
{
      if (Session::has('message'))
      {
         return entryMessages(Session::get('message'),'success');
      }

      return '';
}

function showSubCategories($cat, $dashes = '',$selectedcat=''){
    $dashes .= '-';
    if($subcats=$cat->children()){
      foreach($subcats as $cat){
            $selected=($cat->id==$selectedcat)? 'selected' :'';
        echo "<option value=".$cat->id." ".$selected.">".$dashes." ".$cat->name."</option><br />";
            showSubCategories($cat, $dashes,$selectedcat);
      }
    }
}

function entryMessages($msg,$type){
  if(!empty($msg)){
    if($type=='success'){

      $statusmessage='<div class="alert bg-white alert-success media fade in">
                               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                               <div class="media-left">
                                   <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
                                   <i class="fa fa-check fa-lg"></i>
                                   </span>
                               </div>
                               <div class="media-body">
                           <h4 class="alert-title">Message</h4>
                           <p class="alert-message">';
      if(is_array($msg)){
        $sr=1;$separator=' ';
        foreach($msg as $error){
                   $statusmessage.=$separator.'<span class="badge badge-success">'.$sr.'</span> '.$error;
                           $separator=', ';
                           $sr++;
                }
      }else{
        $statusmessage.=$msg;
      }
                              
      $statusmessage.=     '</p>
                       </div>
                    </div>';

    }elseif($type=='warning'){

      $statusmessage='<div class="alert bg-white alert-warning media fade in">
                       <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                       <div class="media-left">
                           <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
                           <i class="fa fa-exclamation-triangle fa-lg"></i>
                           </span>
                       </div>
                       <div class="media-body">
                           <h4 class="alert-title">Errors</h4>
                           <p class="alert-message">';
      if(is_array($msg)){
        $sr=1;$separator=' ';
        foreach($msg as $error){
                   $statusmessage.=$separator.'<span class="badge badge-warning">'.$sr.'</span> '.$error;
                           $separator=', ';
                           $sr++;
                }
      }else{
        $statusmessage.=$msg;
      }
                              
      $statusmessage.=     '</p>
                       </div>
                    </div>';
      
    }elseif($type=='danger'){
      $statusmessage='<div class="alert bg-white alert-danger media fade in">
                       <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                       <div class="media-left">
                           <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
                           <i class="fa fa-exclamation-triangle fa-lg"></i>
                           </span>
                       </div>
                       <div class="media-body">
                           <h4 class="alert-title">Errors</h4>
                           <p class="alert-message">';
      if(is_array($msg)){
        $sr=1;$separator=' ';
        foreach($msg as $error){
                   $statusmessage.=$separator.'<span class="badge badge-danger">'.$sr.'</span> '.$error;
                           $separator=', ';
                           $sr++;
                }
      }else{
        $statusmessage.=$msg;
      }
                              
      $statusmessage.=     '</p>
                       </div>
                    </div>';
      
    }elseif($type=='info'){

      $statusmessage='<div class="alert bg-white alert-info media fade in">
                       <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                       <div class="media-left">
                           <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
                           <i class="fa fa-info fa-lg"></i>
                           </span>
                       </div>
                       <div class="media-body">
                           <h4 class="alert-title">Message</h4>
                           <p class="alert-message">';
      if(is_array($msg)){
        $sr=1;$separator=' ';
        foreach($msg as $error){
                   $statusmessage.=$separator.'<span class="badge badge-info">'.$sr.'</span> '.$error;
                           $separator=', ';
                           $sr++;
                }
      }else{
        $statusmessage.=$msg;
      }
                              
      $statusmessage.=     '</p>
                       </div>
                    </div>';
      
    }
    return $statusmessage;
  }
}