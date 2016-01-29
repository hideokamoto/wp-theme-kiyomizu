(function($) {
	if( $('#kiyomizu-related-post')[0] ){
		$.ajax({
				type: 'GET',
				url: $('#kiyomizu-related-post').data('postlist-url'),
				dataType: 'json'
		}).done(function(json){
			var html = '<ul>';
			for (var i = 0; i < json.length; i++) {
				html += '<li>';
				html += '<a href="' + json[i].link + '">';
				html += '<b>' + json[i].title.rendered + '</b>';
				html += '</a>';
				html += json[i].excerpt.rendered;
				html += '</li>';
			}
			html += '</ul>';
			$('#kiyomizu-related-post').append(html);
		}).fail(function(json){
			$('#kiyomizu-related-post').append($('#kiyomizu-related-post').data('fail-text'));
		});
	}
})(jQuery);
