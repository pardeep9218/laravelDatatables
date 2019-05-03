var delbtn="<button type='button' class='btn btn-danger del-btn'><i class='fa fa-minus'></i></button>";
$(document).on('click','.add-btn',function(){
    $clone=$('.parent .child:first-child').clone();
    $clone.find('.contactnumber').attr('id','contact'+cloneid);
    $clone.find('.contactnumber').val('');
    $clone.append(delbtn);
    $clone.appendTo('.parent');
    cloneid++;
            
})
$(document).on('click','.del-btn',function(){
    $(this).closest('.child').remove();
});

if($('.form_time').length){
    $(".form_time").datetimepicker({
        format: "HH:mm"
    });
}

$(document).on('click','.add-color',function(){
    var color=$('.color-value').val();
    $.ajax({
        url:ADMIN_PATH+'/getsize',
        type:'POST',
        data:{count:count},
        success:function(response){
            var select=`
            <select class="form-control selectpicker js-input" multiple name='data[`+count+`][size][]' id='select`+count+`' data-placeholder="select size">
                <option value=''>Select size</option>`;
                $.each(response,function( index, value ) {
                  select+=`<option value="`+value.title+`">`+value.title+`</option>`;
                });
            select+=`</select>`;
            

            $('.colors-div').append(`
                <div class='row color-row'>
                    <div class='col-sm-2'>
                        <label>Color</label>
                        <div class='small-color-box' style='background:`+color+`'></div>
                        <input type='hidden' class='form-control' name='data[`+count+`][color]' value='`+color+`' readonly>
                    </div>
                    <div class='col-sm-4'>
                        <label>Images</label>
                        <input type='file' name='data[`+count+`][images][]' class='js-input-img' id='imginput`+count+`' multiple>
                    </div>
                    <div class='col-sm-4'>
                        <label>Size</label>
                        `+select+`
                    </div>
                    <div class='col-sm-2'>
                        <label class='col-xs-12'>&nbsp;</label>
                        <button type='button' class='btn btn-danger del-color'><i class='fa fa-minus'></i></button>
                    </div>
                </div>
            `);
            count=count+1;
            $('.selectpicker').selectpicker('refresh');
            $('#productform').validate().resetForm();
            $('.js-input').each(function () {
                $(this).rules("add", {
                    required:true,
                    messages: {
                        required: "required",
                    }
                });
            });
            $('.js-input-img').each(function () {
                $this=$(this);
                $(this).rules("add", {
                    required:function () {
                           if ($this.next(".old-img").length==0 || $this.next(".old-img").html()=='') {
                               return true;
                           } else {
                               return false;
                           }
                    },
                    messages: {
                        required: "required",
                    }
                });
            });
        }
    })
    
});
//initialize editable end

$(document).on('click','.del-color',function(){
    $(this).closest('.color-row').remove();
});

$(document).on('click','.del-uploaded-color',function(){
    var id=$(this).attr('id');
    $this=(this);
    alertify.confirm('Delete Confirm', 'Are you sure you want to delete a color', function(){
        $.ajax({
            url:ADMIN_PATH+'/delete-color',
            type:'POST',
            data:{id:id,type:'color'},
            success:function(data){
                if(data.status=='success'){
                    $this.closest('.color-row').remove();
                }else{
                    alertify.warning(data.msg);
                }
            }
        });
    }, 
    function(){ 
       console.log('cancelled');
    });
    
});

$(document).on('click','.del-old-img',function(){
    var img=$(this).attr('img');
    $this=(this);
    alertify.confirm('Delete Confirm', 'Are you sure you want to delete an image', function(){
        $.ajax({
            url:ADMIN_PATH+'/delete-color',
            type:'POST',
            data:{img:img,type:'img'},
            success:function(data){
                if(data.status=='success'){
                }else{
                    //alertify.warning(data.msg);
                }
                
                    $this.closest('.old-img').remove();
            }
        });
    }, 
    function(){ 
       console.log('cancelled');
    });
    
});


if($('.color-picker').length){
  $('.color-picker').colorpicker();
}

