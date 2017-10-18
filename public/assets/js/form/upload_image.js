class UploadImage {
	constructor(form, panel, model, type ,limit = 5, style = 'default') {
		this.form = form;
		this.panel = panel;
		this.model = model;
		this.type = type;
		this.limit = limit;
		this.style = style; // default, description
		this.code = null;
		this.index = 0;
		this.runningNumber = 0;
		this.imagesPlaced = [];
		this.defaultImage = '/assets/images/common/add_image.png';
		this.allowedClick = true;
		this.inputDisable = [];
	}

	setImages(images = []){

		if(typeof images[0] === 'undefined') {
			this.index = this._createUploader(this.index,images);
		}else{
			for (let i = 0; i < Object.keys(images).length; i++) {
				this.index = this._createUploader(this.index,images[i]);
			}
		}

		

		if(this.index < this.limit){
			this.index = this.createUploader(this.index);
		}
		
	}

	init(){

		this.code = Token.generateToken();

  	let hidden = document.createElement('input');
    hidden.setAttribute('type','hidden');
    hidden.setAttribute('name','Image['+this.type+'][token]');
    hidden.setAttribute('value',this.code);
    $(this.panel).append(hidden);

    this.bind();
	}

	bind(){

		let _this = this;

		$(_this.panel).on('click', '.image-input', function(e){

			for (var i = 0; i < _this.inputDisable.length; i++) {
				if(_this.inputDisable[i] == this.id) {
					e.preventDefault();
					return false;
				}
			};

		});

		$(_this.panel).on('change', '.image-input', function(){
			_this.preview(this);
		});

		$(_this.panel).on('click', '.image-remove-btn', function(){
			_this.removePreview(this);
		});
		
	}

	preview(input){

		if (input.files && input.files[0]) {

			let parent = $(input).parent();

			if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
			  alert("Your browser does not support new File API! Please upgrade.");
				return false;
			}else{
			  let fileSize = input.files[0].size;
			  let mimeType = input.files[0].type;

			  if(!this.checkImageType(mimeType) || !this.checkImageSize(fileSize)) {
		
			  	parent.css('borderColor','red');
		  		parent.find('.error-message').css('display','block').text('ไม่รองรับไฟล์นี้');
		  		parent.find('input[type="hidden"]').remove();
		  		parent.find('input').val('');

			  }else {

			  	let reader = new FileReader();

			  	reader.onload = function (e) {
			  		parent.find('div.preview-image').css('display','none').css('background-image', 'url(' + e.target.result + ')');
			  	}

			  	reader.readAsDataURL(input.files[0]);

		  		parent.find('.error-message').css('display','none').text('');

		  		let formData = new FormData(); 
		  		formData.append('model', this.model);
		  		formData.append('token', this.code);
		  		formData.append('imageType', this.type);
		  		formData.append('image', input.files[0]);

		  		this.uploadImage(parent,input,formData);

			  }
			}

		}

	}

	uploadImage(parent,input,data) {

		let _this = this;
		
		let id = input.getAttribute('id');

		let request = $.ajax({
	    url: "/upload/image",
	    type: "POST",
	    headers: {
	    	'x-csrf-token': $('[name="_token"]').val()
	    },
	    data: data,
	    dataType: 'json',
	    contentType: false,
	    cache: false,
	    processData:false,
	    beforeSend: function( xhr ) {

	    	_this.inputDisable.push(input.id);  

	    	$(_this.form + ' input[type="submit"]').prop('disabled','disabled').addClass('disabled');  	

	    	$(parent).parent().find('.status').css('width','0%');
	    	parent.parent().find('.progress-bar').css('display','block');

	    },
	    mimeType:"multipart/form-data",
	    xhr: function(){
	
	    	let xhr = $.ajaxSettings.xhr();
	    	if (xhr.upload) {
	    		xhr.upload.addEventListener('progress', function(event) {
	    			let percent = 0;
	    			let position = event.loaded || event.position;
	    			let total = event.total;
	    			if (event.lengthComputable) {
	    				percent = Math.ceil(position / total * 100);
	    			}
	    
	    			parent.parent().find('.status').css('width',percent +'%');
	    		}, true);
	    	}
	    	return xhr;
	    }
	  });

	  request.done(function (response, textStatus, jqXHR){

	  	if(response.uploaded){

	  		parent.find('a').css('display','block');
	  		parent.parent().find('.preview-image').fadeIn(450).css('background-color','#fff');

	  		let key = parent.prop('id').split('_');

	  		_this.createAddedImage(parent,key[0],key[1],response.filename);
	  		
	  	}else{

	  		parent.find('input').val('');

	  		const snackbar = new Snackbar();
	  		snackbar.setTitle('ไม่รอบรับรูปภาพนี้ หรือ ไม่สามารถอัพโหลดรูปนี้ได้');
	  		snackbar.setType('error');
	  		snackbar.display();

	  	}

	  	parent.parent().find('.progress-bar').css('display','none');

	  	setTimeout(function(){
	  		_this.inputDisable.splice(_this.inputDisable.indexOf(input.id),1);

	  		if(_this.inputDisable.length == 0) {
	  			$(_this.form + ' input[type="submit"]').prop('disabled',false).removeClass('disabled');
	  		}

	  	},350);
	  	
	  });

	  request.fail(function (jqXHR, textStatus, errorThrown){
	    console.error(
	        "The following error occurred: "+
	        textStatus, errorThrown
	    );
	  });

	}

	createAddedImage(parent,code,index,filename,description='') {

		let hidden = document.createElement('input');
	  hidden.setAttribute('type','hidden');

	  let hiddenInputName = 'Image['+this.type+'][images]['+index+'][filename]';
	  if((this.type == 'profile-image') || (this.type == 'cover')) {
	  	hiddenInputName = 'Image['+this.type+'][image][filename]';
	  }

	  hidden.setAttribute('name',hiddenInputName);
	  hidden.setAttribute('value',filename);
	  parent.append(hidden);

	  // if(this.style == 'description'){
	  // 	document.getElementById(code+'_textarea_'+index).setAttribute('name','Image['+this.type+'][images]['+index+'][description]');
	  // }

		if(this.imagesPlaced.indexOf(parent.prop('id')) < 0){
			this.imagesPlaced.push(parent.prop('id'));

			if(this.index < this.limit){
				this.index = this.createUploader(this.index);
			}
		}

	}

	removePreview(input){

		if(this.allowedClick){

			let _this = this;

			this.allowedClick = false;

			let parent = $(input).parent(); 
			parent.fadeOut(220);  

			--this.index;

			if(this.imagesPlaced.length == this.limit){
				this.index = this.createUploader(this.index);
			}

			this.imagesPlaced.splice(this.imagesPlaced.indexOf($(parent).prop('id')),1);

			if(input.getAttribute('data-id') != null) {
				let key = $(parent).prop('id').split('_');
			 	this.createHiddenDeletedImage(parent.parent().parent(),key[1],input.getAttribute('data-id'));
			}

			parent.parent().remove();

			setTimeout(function(){
				_this.allowedClick = true;
			},500);

		}
		
	}

	createHiddenDeletedImage(parent,index,value) {
		let hidden = document.createElement('input');
	  hidden.setAttribute('type','hidden');
	  hidden.setAttribute('name','Image['+this.type+'][delete]['+index+']');
	  hidden.setAttribute('value',value);
	  parent.append(hidden);
	}

	createUploader(index){

		let html = '';
		html += '<div class="image-panel '+this.style+' clearfix">';
		html += '<label id="'+this.code+'_'+this.runningNumber+'" class="image-label">';
		html += '<input id="'+this.code+'_image_'+this.runningNumber+'" class="image-input" type="file">';
		// html +=	'<div class="preview-image" style="background-image:url('+this.defaultImage+')"></div>';
		html +=	'<div class="preview-image"></div>';
		html += '<a href="javscript:void(0);" class="image-remove-btn">×</a>'
		html += '<p class="error-message"></p>';
		html += '<div class="progress-bar"><div class="status"></div></div>'
		html += '</label>';
		if(this.style == 'description'){
			html += '<textarea id="'+this.code+'_textarea_'+this.runningNumber+'" placeholder="คำอธิบายเี่ยวกับรูปภาพนี้"></textarea>';
		}
		html += '</div>';

		++this.runningNumber;
		$(this.panel).append(html);

		return ++index;

	}

	_createUploader(index,image){

		this.imagesPlaced.push(this.code+'_'+this.runningNumber);

		let html = '';
		html += '<div class="image-panel '+this.style+' clearfix">';
		html += '<input type="hidden" name="Image['+this.type+'][images]['+index+'][id]" value="'+image.id+'" >';
		html += '<label id="'+this.code+'_'+this.runningNumber+'" class="image-label">';
		html += '<input id="'+this.code+'_image_'+this.runningNumber+'" class="image-input" type="file">';
		html +=	'<div class="preview-image" style="background-image:url('+image._url+')"></div>';
		html += '<a href="javscript:void(0);" class="image-remove-btn" data-id="'+image.id+'" style="display:block;">×</a>';
		html += '<p class="error-message"></p>';
		html += '<div class="progress-bar"><div class="status"></div></div>'
		html += '</label>';
		if(this.style == 'description'){
			html += '<textarea id="'+this.code+'_textarea_'+this.runningNumber+'" name="Image['+this.type+'][images]['+index+'][description]" placeholder="คำอธิบายเี่ยวกับรูปภาพนี้">'+image.description+'</textarea>';
		}
		html += '</div>';

		++this.runningNumber;
		
		$(this.panel).append(html);

		return ++index;

	}

	checkImageType(type){
		let allowedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

		let allowed = false;

		for (let i = 0; i < allowedFileTypes.length; i++) {
			if(type == allowedFileTypes[i]){
				allowed = true;
				break;						
			}
		};

		return allowed;
	}

	checkImageSize(size) {
		// 5MB
		let maxSize = 5242880;

		let allowed = false;

		if(size <= maxSize){
			allowed = true;
		}

		return allowed;
	}

}
