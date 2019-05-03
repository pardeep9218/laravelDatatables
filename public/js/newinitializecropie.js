function demoUpload() {
	var $uploadCrop;

	function readFile(input) {
			if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
				$('.upload-demo').addClass('ready');
            	$uploadCrop.croppie('bind', {
            		url: e.target.result
            	}).then(function(){
        			$('#large-image').val(e.target.result);
            	});
            	
            }
            
            reader.readAsDataURL(input.files[0]);
        }
        else {
	        swal("Sorry - you're browser doesn't support the FileReader API");
	    }
	}

	$uploadCrop = $('#upload-demo').croppie({
		viewport: {
			width: 250,
			height: 250,
			type: 'circle'
		},
		enableExif: true
	});
	enableCrop('upload');

	$('#upload').on('change', function () { readFile(this); });
	$('.upload-result').on('click', function (ev) {
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (resp) {
			
	        $('#userimage').val(resp);
	        $('#userimage').trigger('change');
	        
	        /*
	        if($('#registrationForm').bootstrapValidator('isValid')){
	        	console.log('valid');
	        }else{
	        	console.log('invalid');
	        }*/

	        html = '<img src="' + resp + '" />';
	        $("#upload-demo-i").html(html);
		});
	});
}

function enableCrop(id){
    var file=$('#'+id).val();
    if(file==""){
        $('.upload-result').attr('disabled','disabled');
    }else{
        $('.upload-result').removeAttr('disabled');
    }
}
