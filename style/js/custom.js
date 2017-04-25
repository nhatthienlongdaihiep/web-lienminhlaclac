function secondsToTime(secs)
{
    secs = Math.round(secs);
    var hours = Math.floor(secs / (60 * 60));

    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);

    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);

    var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
    };
    return obj;
}

$(document).ready(function(){
	$('.time_free').click(function(){
		var time = $(this).attr('data-time');
		$('#ithoigian').val(time);
		$(window).scrollTop(0);
		$('#ithoigian').animate({opacity: 0.1}, 'slow', function(){
			$('#ithoigian').animate({opacity: 1}, 'slow');
		});
	});
});
