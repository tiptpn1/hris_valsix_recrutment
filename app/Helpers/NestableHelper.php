<?php
if (!function_exists('buildDD')) {
   
    function buildDD($elements, $parentId = 0, $currLevel = 0, $prevLevel = -1)
    {
        foreach ($elements as $element) {

            if ($element->parent_id == $parentId) {                       
                if ($currLevel > $prevLevel){
                    if($parentId == 0){
                        echo '<ol class="dd-list">'; 
                    }
                    else{
                        echo '<ol>';
                    }
                }
            
                if ($currLevel == $prevLevel) echo " </li> ";
            
                    echo '<li class="dd-item" data-id="'.$element->id.'">
                    <div class="item_actions">
                        <button class="btn btn-xs btn-primary edit" data-id="'.$element->id.'" title="Ubah">
                            <i class="fa fa-pencil fa-small" aria-hidden="true"></i>
                        </button> / 
                        <button class="btn btn-xs btn-warning delete" data-id="'.$element->id.'" title="Hapus">
                            <i class="fa fa-trash fa-small" aria-hidden="true"></i>
                        </button>
                        '.($parentId==0 ? '/ <button class="btn btn-xs btn-success submenu" data-id="'.$element->id.'" title="Set Sub-Menu"><i class="fa fa-mail-reply fa-small" aria-hidden="true"></i></button>' : "").'
                    </div>
                    <div class="dd-handle">
                      <span>'.$element->description. '</span> <small>'. $element->url.'</small>
                    </div>
                   ';
            
                if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
            
                $currLevel++; 
            
                buildDD ($elements, $element->id, $currLevel, $prevLevel);
            
                $currLevel--;               
            }   
        
        }
        if ($currLevel == $prevLevel) echo " </li>  </ol> ";   
    }
}