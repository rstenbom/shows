$(document).ready(function () {

	/* 
	 * A "dirty" modal. Just to hide and show the form.
	 */
	var Modal = function () {};

	Modal.hide = function () {
		$('body').removeClass('modal-open');
		$('#modal-bkg').removeClass('visible').fadeOut(250);
		$('#form-wrap').removeClass('visible').fadeOut(250);		
	}

	Modal.show = function () {
		$('body').addClass('modal-open');	
		$('#modal-bkg').addClass('visible').fadeIn(500);	
		$('#form-wrap').addClass('visible').fadeIn(500);	
	}

	/*
	 * The show Object.	 
	 *
	 * You can also pass an object as the first argument instead of strings.
	 *
	 * Example usage:
	 * var show = new Show("test", "2010-10-13", "17:00", "some synopsis", "some bline", "some url", "some leadtext", function (jsonResponse) {
	 *	 console.log(jsonResponse);
	 * }); 
	 * show.save() // submit to server
	 */
	var Show = function (name, date, start_time, synopsis, bline, url, leadtext) {
		this.attr = {};
		
		if ($.isPlainObject(name)) {
			this.attr = name;
		} else {
			this.attr.name = name || null;
			this.attr.date = date || null;
			this.attr.start_time = start_time || null;
			this.attr.synopsis = synopsis || null;
			this.attr.bline = bline || null;
			this.attr.url = url || null;
			this.attr.leadtext = leadtext || null;
		}

		return this; // Chaining
	};

	Show.prototype.save = function (callback) {
		var self = this;
		$.ajax({
			type: "POST",
			url: '/shows',
			data: self.attr,
			success: callback.bind(self),
			error: callback,
			dataType: 'json'			
		});
	} 

	Show.prototype.render = function (callback) {
		// We have little use for a JS template language,
		// this is our only function rendering html
		var $tbody = $('table#shows tbody');
		var $html = $('<tr style="display: none;"/>');
		$html.append('<td>'+this.attr.name+'</td>');
		$html.append('<td>'+this.attr.leadtext+'</td>');
		$html.append('<td>'+this.attr.synopsis+'</td>');
		$html.append('<td>'+this.attr.bline+'</td>');
		$html.append('<td>'+this.attr.url+'</td>');
		$html.append('<td>'+this.attr.date+'</td>');
		$html.append('<td>'+this.attr.start_time+'</td>');
		$html.append('<td><a class="delete" href="/show/delete/' + this.attr.id + '">Delete</a></td>');
		$tbody.append($html);
		$html.fadeIn(500);
	}

	Show.get = function (callback) {			
		$.ajax({
			type: "GET",
			url: '/shows',			
			success: callback,
			error: callback
		});
	}

	/*
	 * Event handlers
	 */

	// Submit handler for the show form
	var $form = $('#newshow');
	$form.submit(function(e) {
		var url,obj, show, indexedArray, unindexedArray;		
		url = '/shows';
		indexedArray = {};
		unindexedArray = $form.serializeArray(); 	
		// Map the unindexed array so we get a one level object	with formname: formvalue
		$.map(unindexedArray, function(n, i) {
        	indexedArray[n['name']] = n['value'];
    	});
		
		show = new Show(indexedArray).save(function(data) {									
			if (data.error)
				alert("Could not save show");

			if ($('#form-wrap').hasClass('visible'))
				Modal.hide();						

			this.attr = data;
			this.render();
		});		

		return false; // prevent default behaviour
	});	


	$('#modal-bkg').click(function () {
		Modal.hide();
	});
	var $addshow_button = $('#addshow-button');
	$addshow_button.click(function(e) {	
		Modal.show();
		return false;
	});
});