$(function () {
	$(function() {
		$('#cropbox').Jcrop({ boxWidth: 300, boxHeight: 300 });
	});

	$('.cancelCrop').click(function(e) {
		window.location = ''
	});
	$('.confirmCrop').click(function(e) {
		$('#imagePreview').modal('hide');
	});

	$("#avatar").change(function(){
		readURL(this);
		setTimeout(function(){
			var jcrop_api;

			$('.target').Jcrop({
				boxWidth: 600,
				aspectRatio: 800/800,
				minSize: [50],
				onChange: showCoords,
				onSelect: showCoords,
				onRelease: clearCoords
			},
			function(){
				jcrop_api = this;
			}
			);

			$('#coords').on('change', 'input',function(e){
				var x1 = $('#x1').val(),
				x2 = $('#x2').val(),
				y1 = $('#y1').val(),
				y2 = $('#y2').val();
				jcrop_api.setSelect([x1,y1,x2,y2]);
			});

			function showCoords(c) {
				$('#x1').val(c.x);
				$('#y1').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
				$('.confirmCrop').attr('disabled', false);
			};

			function clearCoords() {
				$('#x1').val('');
				$('#y1').val('');
				$('#w').val('');
				$('#h').val('');
				$('.confirmCrop').attr('disabled', true);
			};
		}, 1000);

		$('#imagePreview').modal('show');
        // $('#imageArea').show();
    });

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#imageArea').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function centerModals(){
		$('.modal').each(function(i){
			var $clone = $(this).clone().css('display', 'block').appendTo('body');
			var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
			top = top > 0 ? top : 0;
			$clone.remove();
			$(this).find('.modal-content').animate({"margin-top":top});
		});
	}

});