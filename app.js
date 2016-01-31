(function($) {
	$relatedPost = $('#kiyomizu-related-post');
	if( $relatedPost.length ){
		$.ajax({
				type: 'GET',
				url:  $relatedPost.data('postlist-url'),
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
			$relatedPost.append(html);
		}).fail(function(jqXHR, textMessage, errorThrown ){
			$relatedPost.append($relatedPost.data('fail-text'));
		});
	}
})(jQuery);
