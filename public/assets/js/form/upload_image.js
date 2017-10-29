class UploadImage {
	constructor(form, panel, model, type ,limit = 5, defaultPreview = '') {
		this.form = form;
		this.panel = panel;
		this.model = model;
		this.type = type;
		this.limit = limit;
		// this.style = 'default'; // default, description
		this.code = null;
		this.index = 0;
		this.runningNumber = 0;
		this.imagesPlaced = [];
		this.deletingImages = [];
		this.defaultPreview = defaultPreview;
		this.allowedClick = true;
		this.inputDisable = [];
	}

	setImages(images = []){

		if(typeof images.id !== 'undefined') {
			this.index = this._createUploader(this.index,images);
		}else if(images.length > 0){
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

			// let file = this.files[0];
			// let img = new Image();
   //    img.onload = function () {
   //    	console.log('sdsd');
   //        alert("width : "+this.width + " and height : " + this.height);
   //    };
   //    img.src = window.URL.createObjectURL(file);

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

				let _this = this;
				let file = input.files[0];

			  if(!this.checkImageType(file.type) || !this.checkImageSize(file.size)) {
		
			  	parent.css('borderColor','red');
		  		parent.find('.error-message').css('display','block').text('ไม่รองรับไฟล์นี้');
		  		parent.find('input[type="hidden"]').remove();
		  		parent.find('input').val('');

			  }else {

			  	let reader = new FileReader();

			  	reader.onload = function (e) {
			  		// parent.find('div.preview-image').css('display','none').css('background-image', 'url(' + e.target.result + ')');
			  	
			  		let image = new Image();
            image.onload = function (imageEvent) {

            		let dimension = _this.resizeImage(_this.type,image.width,image.height);

                // Resize the image
                let canvas = document.createElement('canvas');
                //     max_size = 400,
                //     width = image.width,
                //     height = image.height;
                // if (width > height) {
                //     if (width > max_size) {
                //         height *= max_size / width;
                //         width = max_size;
                //     }
                // } else {
                //     if (height > max_size) {
                //         width *= max_size / height;
                //         height = max_size;
                //     }
                // }
                canvas.width = dimension.width;
                canvas.height = dimension.height;
                canvas.getContext('2d').drawImage(image, 0, 0, dimension.width, dimension.height);
                let dataUrl = canvas.toDataURL('image/jpeg');
                let resizedImage = _this.dataURLToBlob(dataUrl);
                // $.event.trigger({
                //     type: "imageResized",
                //     blob: resizedImage,
                //     url: dataUrl
                // });
					
								parent.find('div.preview-image').css('display','none').css('background-image', 'url(' + dataUrl + ')');

								let formData = new FormData(); 
								formData.append('model', _this.model);
								formData.append('token', _this.code);
								formData.append('imageType', _this.type);
								formData.append('image', resizedImage);

								_this.uploadImage(parent,input,formData);

            }
            image.src = e.target.result;

			  	}
			  	reader.readAsDataURL(file);

		  		parent.find('.error-message').css('display','none').text('');

		  		// not resizing
		  		// let formData = new FormData(); 
		  		// formData.append('model', this.model);
		  		// formData.append('token', this.code);
		  		// formData.append('imageType', this.type);
		  		// formData.append('image', file);

		  		// this.uploadImage(parent,input,formData);

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

	  		// if($(parent).find('.image-remove-btn').length) {
	  		// 	_this._removePreview($(parent).find('.image-remove-btn')[0],parent);
	  		// }

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

			if(this.imagesPlaced.indexOf($(parent).prop('id')) !== -1) {
				this.imagesPlaced.splice(this.imagesPlaced.indexOf($(parent).prop('id')),1);
			}

			this._removePreview(input,parent);

			// if((input.getAttribute('data-id') != null) && (this.deletingImages.indexOf(input.getAttribute('data-id')) === -1)) {

			// 	this.deletingImages.push(input.getAttribute('data-id'));

			// 	let key = $(parent).prop('id').split('_');
			//  	this.createHiddenDeletedImage(parent.parent().parent(),key[1],input.getAttribute('data-id'));
			// }

			parent.parent().remove();

			setTimeout(function(){
				_this.allowedClick = true;
			},500);

		}
	}

	_removePreview(input,parent) {

		if((input.getAttribute('data-id') != null) && (this.deletingImages.indexOf(input.getAttribute('data-id')) === -1)) {

			this.deletingImages.push(input.getAttribute('data-id'));

			let key = $(parent).prop('id').split('_');
		 	this.createHiddenDeletedImage(parent.parent().parent(),key[1],input.getAttribute('data-id'));
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
		html += '<div class="image-panel clearfix">';
		html += '<label id="'+this.code+'_'+this.runningNumber+'" class="image-label '+this.defaultPreview+'">';
		html += '<input id="'+this.code+'_image_'+this.runningNumber+'" class="image-input" type="file">';
		html +=	'<div class="preview-image"></div>';
		html += '<a href="javscript:void(0);" class="image-remove-btn">×</a>'
		html += '<p class="error-message"></p>';
		html += '<div class="progress-bar"><div class="status"></div></div>'
		html += '</label>';
		// if(this.style == 'description'){
		// 	html += '<textarea id="'+this.code+'_textarea_'+this.runningNumber+'" placeholder="คำอธิบายเี่ยวกับรูปภาพนี้"></textarea>';
		// }
		html += '</div>';

		++this.runningNumber;
		$(this.panel).append(html);

		return ++index;

	}

	_createUploader(index,image){

		this.imagesPlaced.push(this.code+'_'+this.runningNumber);

		let html = '';
		html += '<div class="image-panel clearfix">';
		html += '<input type="hidden" name="Image['+this.type+'][images]['+index+'][id]" value="'+image.id+'" >';
		html += '<label id="'+this.code+'_'+this.runningNumber+'" class="image-label '+this.defaultPreview+'">';
		html += '<input id="'+this.code+'_image_'+this.runningNumber+'" class="image-input" type="file">';
		html +=	'<div class="preview-image" style="background-image:url('+image._url+')"></div>';
		html += '<a href="javscript:void(0);" class="image-remove-btn" data-id="'+image.id+'" style="display:block;">×</a>';
		html += '<p class="error-message"></p>';
		html += '<div class="progress-bar"><div class="status"></div></div>'
		html += '</label>';
		// if(this.style == 'description'){
		// 	html += '<textarea id="'+this.code+'_textarea_'+this.runningNumber+'" name="Image['+this.type+'][images]['+index+'][description]" placeholder="คำอธิบายเี่ยวกับรูปภาพนี้">'+image.description+'</textarea>';
		// }
		html += '</div>';

		++this.runningNumber;
		
		$(this.panel).append(html);

		return ++index;

	}

	dataURLToBlob(dataURL) {
    let BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        let parts = dataURL.split(',');
        let contentType = parts[0].split(':')[1];
        let raw = parts[1];

        return new Blob([raw], {type: contentType});
    }

    let parts = dataURL.split(BASE64_MARKER);
    let contentType = parts[0].split(':')[1];
    let raw = window.atob(parts[1]);
    let rawLength = raw.length;

    let uInt8Array = new Uint8Array(rawLength);

    for (let i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], {type: contentType});
	}

	resizeImage(type,width,height) {

		let maxSize;

		switch(type) {

			case 'photo':
				maxSize = 960;
			break;

			case 'avatar':
				maxSize = 400;
			break;

			default:
				return false;
			break

		}

		if ((width > height) && (width > maxSize)) {
	    height *= maxSize / width;
	    width = maxSize;
		}else if((height > width) && (height > maxSize)) {
	    width *= maxSize / height;
	    height = maxSize;
		}else if(width > maxSize){
			width = maxSize;
			height = width;
		}

		return {
			width: width,
			height: height
		};

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
