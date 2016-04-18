<?php
function mention_format_text( $t_text ) {
	preg_match_all( "/@{U[0-9]+}/", $t_text, $t_matches );

	if( !empty( $t_matches[0] ) ) {
		$t_matched_mentions = $t_matches[0];
		array_unique( $t_matched_mentions );
		
		$t_formatted_mentions = array();

		foreach( $t_matched_mentions as $t_mention ) {

			$t_user_id = substr( $t_mention, 3, strlen( $t_mention ) - 4 );
			if( $t_username = user_get_name( $t_user_id ) ) {
				if ( is_blank($t_username) ) {
					continue;
				}
				$t_username = string_display_line( $t_username );
				if( user_exists( $t_user_id ) && user_get_field( $t_user_id, 'enabled' ) ) {
					$t_user_url = '<a class="user" href="' . string_sanitize_url( 'view_user_page.php?id=' . $t_user_id, true ) . '">@' . $t_username . '</a>';
				} else {
					$t_user_url = '<del class="user">@' . $t_username . '</del>';
				}
				$t_formatted_mentions[$t_mention] = "<span class='mention'>{$t_user_url}</span>";
			}
		}

		$t_text = str_replace(
			array_keys( $t_formatted_mentions ),
			array_values( $t_formatted_mentions ),
			$t_text
		);
	}

	return $t_text;
}

function mention_users( $t_text ) {
	preg_match_all( "/@[A-Za-z0-9]+/", $t_text, $t_matches );
	$t_mentioned_users = array();
	
	if( !empty( $t_matches[0] )) {
		$t_matched_mentions = $t_matches[0];
		array_unique( $t_matched_mentions );
		
		foreach( $t_matched_mentions as $t_mention ) {
			$t_mentioned_user = substr($t_mention, 1);
			if( $t_user_id = user_get_id_by_name($t_mentioned_user) ) {
				if ( is_blank( $t_user_id ) ) {
					continue;
				}
				$t_mentioned_users[] = $t_user_id;
			}
		}
	}
	return $t_mentioned_users;
}

function mention_format_text_save( $t_text ) {
	preg_match_all( "/@[A-Za-z0-9]+/", $t_text, $t_matches );

	if( !empty( $t_matches[0] )) {
		$t_matched_mentions = $t_matches[0];
		array_unique( $t_matched_mentions );
		
		$t_formatted_mentions = array();

		foreach( $t_matched_mentions as $t_mention ) {
			$t_mentioned_user = substr($t_mention, 1);
			if( $t_user_id = user_get_id_by_name($t_mentioned_user) ) {
				if ( is_blank( $t_user_id ) ) {
					continue;
				}
				$t_formatted_mentions[$t_mention] = "@{U" . $t_user_id . "}";
			}
		}

		$t_text = str_replace(
			array_keys( $t_formatted_mentions ),
			array_values( $t_formatted_mentions ),
			$t_text
		);
	}

	return $t_text;
}