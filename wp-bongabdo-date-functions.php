<?php
function wp_bongabdo_date_post($the_date, $d, $post) {
	$wp_bongabdo = wp_bongabdo(strtotime( $post->post_date ));
	return $wp_bongabdo[0] . ' ' . $wp_bongabdo[1] . ' ' . $wp_bongabdo[2];
}

function wp_bongabdo_date_comment( $d, $comment_ID) {
	$comment = get_comment( $comment_ID );
	$wp_bongabdo = wp_bongabdo(strtotime( $comment->comment_date ));
	return $wp_bongabdo[0] . ' ' . $wp_bongabdo[1] . ' ' . $wp_bongabdo[2];
}

function wp_bongabdo($timestamp) {
	$engDate  = date( 'd', $timestamp );
	$engMonth  = date( 'm', $timestamp );
	$engYear = date( 'Y', $timestamp );		
	$engHour = date( 'G', $timestamp );
	
	$bn_months = array('Poush', 'Magh', 'Falgun', 'Chaitro', 'Boishakh', 'Joishtho', 'Ashar', 'Srabon', 'Bhadro', 'Ashin', 'Kartrik', 'Agrohayon');
	$bn_month_dates = array(30,30,30,30,31,31,31,31,31,30,30,30);
	$bn_month_middate = array(13,12,14,13,14,14,15,15,15,15,14,14);	
	$lipyearindex = 3;
	$morning = 6;

	$bangDate = $engDate - $bn_month_middate[$engMonth - 1];
	if ($engHour < $morning) 
		$bangDate -= 1;
	
	if (($engDate <= $bn_month_middate[$engMonth - 1]) || ($engDate == $bn_month_middate[$engMonth - 1] + 1 && $engHour < $morning) ) {
		$bangDate += $bn_month_dates[$engMonth - 1];
		if (is_leapyear($engYear) && $lipyearindex == $engMonth) 
			$bangDate += 1;
		$bangMonth = $bn_months[$engMonth - 1];
	}
	else{
		$bangMonth = $bn_months[($engMonth)%12];		
	}

	$bangYear = $engYear - 593;
	if (($engMonth < 4) || (($engMonth == 4) && (($engDate < 14) || ($engDate == 14 && $engHour < $morning))))
		$bangYear -= 1;
	
	return array($bangDate, $bangMonth, $bangYear);
}

function months_to_bn($content=''){
	$oldmonths = array( 'Boishakh', 'Joishtho', 'Ashar', 'Srabon', 'Bhadro', 'Ashin', 'Kartrik', 'Agrohayon', 'Poush', 'Magh', 'Falgun', 'Chaitro' );
	$newmonths = array("বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র");
	
	$newcontent = str_replace($oldmonths, $newmonths, $content);
	
	return $newcontent;
}

function digits_to_bn($content=''){
	$olddigits = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$newdigits = array( '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯' );
	
	$newcontent = str_replace($olddigits, $newdigits, $content);
	
	$urls = geturls($content);
	$new_urls =  array();
	
	foreach($urls as $url) {
		$new_urls[] = str_replace($olddigits, $newdigits, $url);
	}
	
	$newcontent = str_replace($new_urls, $urls, $newcontent);
	
	return $newcontent;
}

function is_leapyear($year) {
	if ( $year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0) )
		return true;
	else
		return false;
}

function geturls($string) {
	$regex = '/https?\:\/\/[^\" ]+/i';
	preg_match_all($regex, $string, $matches);
	return ($matches[0]);
}
?>
