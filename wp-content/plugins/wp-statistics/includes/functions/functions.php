<?php
	function wp_statistics_useronline() {
		
		global $wpdb, $table_prefix;
		
		return $wpdb->query("SELECT * FROM {$table_prefix}statistics_useronline");
	}
	
	function wp_statistics_visit($time, $daily = null) {
	
		global $wpdb, $table_prefix;
		
		$s = new WP_Statistics();
		
		if( $daily == true ) {
		
			$result = $wpdb->get_row("SELECT * FROM {$table_prefix}statistics_visit WHERE `last_counter` = '{$s->Current_Date('Y-m-d', $time)}'");
			
			if( $result) {
				return $result->visit;
			} else {
				return 0;
			}
			
		} else {
		
			switch($time) {
				case 'today':
					$result = $wpdb->get_col("SELECT `visit` FROM {$table_prefix}statistics_visit WHERE `last_counter` = '{$s->Current_Date('Y-m-d')}'");
					break;
					
				case 'yesterday':
					$result = $wpdb->get_col("SELECT `visit` FROM {$table_prefix}statistics_visit WHERE `last_counter` = '{$s->Current_Date('Y-m-d', -1)}'");
					break;
					
				case 'week':
					$result[0] = array_sum( $wpdb->get_col("SELECT `visit` FROM {$table_prefix}statistics_visit WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', -7)}' AND '{$s->Current_Date('Y-m-d')}'") );
					break;
					
				case 'month':
					$result[0] = array_sum( $wpdb->get_col("SELECT `visit` FROM {$table_prefix}statistics_visit WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', -30)}' AND '{$s->Current_Date('Y-m-d')}'") );
					break;
					
				case 'year':
					$result[0] = array_sum( $wpdb->get_col("SELECT `visit` FROM {$table_prefix}statistics_visit WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', -360)}' AND '{$s->Current_Date('Y-m-d')}'") );
					break;
					
				case 'total':
					$result = $wpdb->get_col("SELECT SUM(visit) FROM {$table_prefix}statistics_visit");
					break;
					
				default:
					$result[0] = array_sum( $wpdb->get_col("SELECT `visit` FROM {$table_prefix}statistics_visit WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', $time)}' AND '{$s->Current_Date('Y-m-d')}'") );
					break;
			}
		}

		if( array_key_exists(0,$result) ) {
			return $result[0];
		} else {
			return 0;
		}
	}
	
	function wp_statistics_visitor($time, $daily = null) {
	
		global $wpdb, $table_prefix;
		
		$s = new WP_Statistics();
		
		if( $daily == true ) {
		
			$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor WHERE `last_counter` = '{$s->Current_Date('Y-m-d', $time)}'");
			
			return $result;
				
		} else {
		
			switch($time) {
				case 'today':
					$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor WHERE `last_counter` = '{$s->Current_Date('Y-m-d')}'");
					break;
					
				case 'yesterday':
					$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor WHERE `last_counter` = '{$s->Current_Date('Y-m-d', -1)}'");
					break;
					
				case 'week':
					$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', -7)}' AND '{$s->Current_Date('Y-m-d')}'");
					break;
					
				case 'month':
					$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', -30)}' AND '{$s->Current_Date('Y-m-d')}'");
					break;
					
				case 'year':
					$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', -360)}' AND '{$s->Current_Date('Y-m-d')}'");
					break;
					
				case 'total':
					$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor");
					break;
					
				default:
					$result = $wpdb->query("SELECT * FROM {$table_prefix}statistics_visitor WHERE `last_counter` BETWEEN '{$s->Current_Date('Y-m-d', $time)}' AND '{$s->Current_Date('Y-m-d')}'");
					break;
			}
		}
		
		return $result;
	}
	
	function wp_statistics_ua_list() {
	
		global $wpdb, $table_prefix;
		
		$result = $wpdb->get_results("SELECT DISTINCT agent FROM {$table_prefix}statistics_visitor", ARRAY_N);
				
		foreach( $result as $out )
			{
			$Browsers[] = $out[0];
			}
				
		return $Browsers;
	}
	
	function wp_statistics_useragent($agent) {
	
		global $wpdb, $table_prefix;
		
		$result = $wpdb->get_var("SELECT COUNT(agent) FROM {$table_prefix}statistics_visitor WHERE `agent` = '$agent'");
		
		return $result;
	}

	function wp_statistics_platform_list() {
	
		global $wpdb, $table_prefix;
		
		$result = $wpdb->get_results("SELECT DISTINCT platform FROM {$table_prefix}statistics_visitor", ARRAY_N);
				
		foreach( $result as $out )
			{
			$Platforms[] = $out[0];
			}
				
		return $Platforms;
	}

	function wp_statistics_platform($platform) {
	
		global $wpdb, $table_prefix;
		
		$result = $wpdb->get_var("SELECT COUNT(platform) FROM {$table_prefix}statistics_visitor WHERE `platform` = '$platform'");
		
		return $result;
	}
	
	function wp_statistics_agent_version_list($agent) {
	
		global $wpdb, $table_prefix;
		
		$result = $wpdb->get_results("SELECT DISTINCT version FROM {$table_prefix}statistics_visitor WHERE agent = '$agent'", ARRAY_N);
				
		foreach( $result as $out )
			{
			$Versions[] = $out[0];
			}
				
		return $Versions;
	}

	function wp_statistics_agent_version($agent, $version) {
	
		global $wpdb, $table_prefix;
		
		$result = $wpdb->get_var("SELECT COUNT(version) FROM {$table_prefix}statistics_visitor WHERE agent = '$agent' AND version = '$version'");
		
		return $result;
	}

	function wp_statistics_searchengine_list() {
		// This function returns an array or array's which define what search engines we should look for.
		// Each sub array is made up of the following items:
		//		name 		 = The proper name of the search engine
		//		tag 		 = a short one word, all lower case, representation of the search engine
		//		sqlpattern   = either a single SQL style search pattern OR an array or search patterns to match the hostname in a URL against
		//		regexpattern = either a single regex style search pattern OR an array or search patterns to match the hostname in a URL against
		//		querykey 	 = the URL key that contains the search string for the search engine
		//		image		 = the name of the image file to associate with this search engine (just the filename, no path info)
		//
		return array( 
						'baidu' => array( 'name' => 'Baidu', 'tag' => 'baidu', 'sqlpattern' => '%baidu.com%', 'regexpattern' => 'baidu\.com', 'querykey' => 'wd', 'image' => 'baidu.png' ),
						'bing' => array( 'name' => 'Bing', 'tag' => 'bing', 'sqlpattern' => '%bing.com%', 'regexpattern' =>'bing\.com', 'querykey' => 'q', 'image' => 'bing.png' ), 
						'duckduckgo' => array( 'name' => 'DuckDuckGo', 'tag' => 'duckduckgo', 'sqlpattern' => array('%duckduckgo.com%', '%ddg.gg%'), 'regexpattern' => array('duckduckgo\.com','ddg\.gg'), 'querykey' => 'q', 'image' => 'duckduckgo.png' ),
						'google' => array( 'name' => 'Google', 'tag' => 'google', 'sqlpattern' => '%google.%', 'regexpattern' => 'google\.', 'querykey' => 'q', 'image' => 'google.png' ),
						'yahoo' => array( 'name' => 'Yahoo!', 'tag' => 'yahoo', 'sqlpattern' => '%yahoo.com%', 'regexpattern' => 'yahoo\.com', 'querykey' => 'p', 'image' => 'yahoo.png' ),
						'yandex' => array( 'name' => 'Yandex', 'tag' => 'yandex', 'sqlpattern' => '%yandex.ru%', 'regexpattern' => 'yandex\.ru', 'querykey' => 'text', 'image' => 'yandex.png' )
					);
	}

	function wp_statistics_searchengine_query($search_engine = 'all') {
		$searchengine_list = wp_statistics_searchengine_list();
		$search_query = '';
		
		if( strtolower($search_engine) == 'all' ) {
			foreach( $searchengine_list as $se ) {
				if( is_array( $se['sqlpattern'] ) ) {
					foreach( $se['sqlpattern'] as $subse ) {
						$search_query .= "`referred` LIKE '{$subse}' OR ";
					}
				}
				else {
					$search_query .= "`referred` LIKE '{$se['sqlpattern']}' OR ";
				}
			}
			
			// Trim off the last ' OR ' for the loop above.
			$search_query = substr( $search_query, 0, strlen( $search_query ) - 4 );
		}
		else {
			if( is_array( $searchengine_list[$search_engine]['sqlpattern'] ) ) {
				foreach( $searchengine_list[$search_engine]['sqlpattern'] as $se ) {
					$search_query .= "`referred` LIKE '{$se}' OR ";
				}

				// Trim off the last ' OR ' for the loop above.
				$search_query = substr( $search_query, 0, strlen( $search_query ) - 4 );
			}
			else {
				$search_query .= "`referred` LIKE '{$searchengine_list[$search_engine]['sqlpattern']}'";
			}
		}
		
		return $search_query;
	}

	function wp_statistics_searchengine_regex($search_engine = 'all') {
		$searchengine_list = wp_statistics_searchengine_list();
		$search_query = '';
		
		if( strtolower($search_engine) == 'all' ) {
			foreach( $searchengine_list as $se ) {
				if( is_array( $se['regexpattern'] ) ) {
					foreach( $se['regexpattern'] as $subse ) {
						$search_query .= "{$subse}|";
					}
				}
				else {
					$search_query .= "{$se['regexpattern']}|";
				}
			}
			
			// Trim off the last '|' for the loop above.
			$search_query = substr( $search_query, 0, strlen( $search_query ) - 1 );
		}
		else {
			if( is_array( $searchengine_list[$search_engine]['regexpattern'] ) ) {
				foreach( $searchengine_list[$search_engine]['regexpattern'] as $se ) {
					$search_query .= "{$se}|";
				}

				// Trim off the last '|' for the loop above.
				$search_query = substr( $search_query, 0, strlen( $search_query ) - 1 );
			}
			else {
				$search_query .= $searchengine_list[$search_engine]['regexpattern'];
			}
		}
		
		// Add the brackets and return
		return "({$search_query})";
	}
	
	function wp_statistics_searchengine($search_engine = 'all', $time = 'total') {
	
		global $wpdb, $table_prefix;
		
		$s = new WP_Statistics();

		$search_query = wp_statistics_Searchengine_query($search_engine);

		switch($time) {
			case 'today':
				$result = $wpdb->query("SELECT * FROM `{$table_prefix}statistics_visitor` WHERE `last_counter` = '{$s->Current_Date('Y-m-d')}' AND {$search_query}");
				break;
				
			case 'yesterday':
				$result = $wpdb->query("SELECT * FROM `{$table_prefix}statistics_visitor` WHERE `last_counter` = '{$s->Current_Date('Y-m-d', -1)}' AND {$search_query}");
				
				break;
				
			case 'week':
				$result = $wpdb->query("SELECT * FROM `{$table_prefix}statistics_visitor` WHERE `last_counter` = '{$s->Current_Date('Y-m-d', -7)}' AND {$search_query}");
				
				break;
				
			case 'month':
				$result = $wpdb->query("SELECT * FROM `{$table_prefix}statistics_visitor` WHERE `last_counter` = '{$s->Current_Date('Y-m-d', -30)}' AND {$search_query}");
				
				break;
				
			case 'year':
				$result = $wpdb->query("SELECT * FROM `{$table_prefix}statistics_visitor` WHERE `last_counter` = '{$s->Current_Date('Y-m-d', -360)}' AND {$search_query}");
				
				break;
				
			case 'total':
				$result = $wpdb->query("SELECT * FROM `{$table_prefix}statistics_visitor` WHERE {$search_query}");
				
				break;
				
			default:
				$result = $wpdb->query("SELECT * FROM `{$table_prefix}statistics_visitor` WHERE `last_counter` = '{$s->Current_Date('Y-m-d', $time)}' AND {$search_query}");
				
				break;
		}
		
		return $result;
	}
	
	function wp_statistics_countposts() {
	
		$count_posts = wp_count_posts('post');
		return $count_posts->publish;
	}

	function wp_statistics_countpages() {
	
		$count_pages = wp_count_posts('page');
		return $count_pages->publish;
	}

	function wp_statistics_countcomment() {
	
		global $wpdb;
		
		$countcomms = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
		
		return $countcomms;
	}

	function wp_statistics_countspam() {
	
		return number_format_i18n(get_option('akismet_spam_count'));
	}

	function wp_statistics_countusers() {
	
		$result = count_users();
		return $result['total_users'];
	}

	function wp_statistics_lastpostdate( $type='english' ) {
	
		global $wpdb;
		
		$db_date = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_type='post' AND post_status='publish' ORDER BY ID DESC LIMIT 1");
		
		$date_format = get_option('date_format');
		
		if ( $type == 'farsi' ) {
		
			return jdate($date_format, strtotime($db_date));
			
		} else {
		
			return date($date_format, strtotime($db_date));
			
		}
	}
	
	function wp_statistics_average_post() {
	
		global $wpdb;
		
		$get_first_post = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date LIMIT 1");
		$get_total_post = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'");
		
		$days_spend = intval((time() - strtotime($get_first_post) ) / (60*60*24));
		
		return round($get_total_post / $days_spend, 2);
	}

	function wp_statistics_average_comment() {
	
		global $wpdb;
		
		$get_first_comment = $wpdb->get_var("SELECT comment_date FROM $wpdb->comments ORDER BY comment_date LIMIT 1");
		$get_total_comment = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");

		$days_spend = intval((time() - strtotime($get_first_comment) ) / (60*60*24));
		
		return round($get_total_comment / $days_spend, 2);
	}

	function wp_statistics_average_registeruser() {
	
		global $wpdb;
		
		$get_first_user = $wpdb->get_var("SELECT user_registered FROM $wpdb->users ORDER BY user_registered LIMIT 1");
		$get_total_user = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users");

		$days_spend = intval((time() - strtotime($get_first_user) ) / (60*60*24));
		
		return round($get_total_user / $days_spend, 2);
	}
	
	function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}