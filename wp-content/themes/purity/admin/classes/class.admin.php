<?php if (!defined('OT_VERSION')) exit('No direct script access allowed');
/**
 * OptionTree Admin
 *
 * @package     WordPress
 * @subpackage  OptionTree
 * @since       1.0.0
 * @author      Derek Herman
 */
class OT_Admin
{
  private $table_name = NULL;
  private $version = NULL;
  private $option_array = array();

  function __construct() 
  {
    global $table_prefix;

    $this->table_name = $table_prefix . 'bp_option_tree';
    $this->version = OT_VERSION;
    $this->option_array = $this->option_tree_data();
  }

  /**
   * Initiate Plugin & setup main options
   *
   * @uses get_option()
   * @uses add_option()
   * @uses option_tree_activate()
   * @uses wp_redirect()
   * @uses admin_url()
   *
   * @access public
   * @since 1.0.0
   *
   * @return bool
   */
  function option_tree_init() 
  {
    // check for activation
    $check = get_option( 'option_tree_activation' );

    // redirect on activation
    if ($check != "set" && $this->option_array[0]) 
    {
      // set blank option values
      foreach ( $this->option_array as $value ) 
      {
          $key = $value->item_id;
        $new_options[$key] = '';
      }

      // add theme options
      add_option( 'option_tree', $new_options );
      add_option( 'option_tree_activation', 'set');

      // load DB activation function if updating plugin
      $this->option_tree_activate();

      // Redirect
      wp_redirect( admin_url().'admin.php?page=option_tree&xml=true' );
    }
    return false;
  }

  /**
   * Plugin Table Structure
   *
   * @access public
   * @since 1.0.0
   *
   * @param string $type
   *
   * @return string
   */
  function option_tree_table( $type = '')
  {
    if ( $type == 'create' ) 
    {
      $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            item_id VARCHAR(50) NOT NULL,
            item_title VARCHAR(100) NOT NULL,
            item_desc LONGTEXT,
            item_type VARCHAR(30) NOT NULL,
            item_options VARCHAR(250) DEFAULT NULL,
            item_sort mediumint(9) DEFAULT '0' NOT NULL,
            UNIQUE KEY (item_id)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
    }
    return $sql;
  }

  /**
   * Plugin Activation
   *
   * @uses get_var()
   * @uses get_option()
   * @uses dbDelta()
   * @uses option_tree_table()
   * @uses option_tree_default_data()
   * @uses update_option()
   * @uses add_option()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_activate() 
  {
    global $wpdb;

    // check for table
    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

    // check for installed version
      $installed_ver = get_option( 'option_tree_version' );

    // add/update table
      if ( $installed_ver != $this->version ) 
      {
      // run query
          require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta( $this->option_tree_table( 'create' ) );
    }

    // new install default data
    if ( $new_installation ) 
    {
      $this->option_tree_default_data();
    }

    // New Version Update
    if ( $installed_ver != $this->version ) 
    {
      update_option( 'option_tree_version', $this->version );
    } 
    else if ( !$installed_ver ) 
    {
      add_option( 'option_tree_version', $this->version );
    }
  }
  

  /**
   * Plugin Deactivation delete options
   *
   * @uses delete_option()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_deactivate() 
  {
    // remove activation check & version
    delete_option( 'option_tree_activation' );
    delete_option( 'option_tree_version' );
  }

  /**
   * Plugin Activation Default Data
   *
   * @uses query()
   * @uses prepare()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_default_data() 
  {
      global $wpdb;

    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

/*

Replace with your theme options file path.

*/
	//$ot_data_file = get_bloginfo('template_url') . "/admin/settings/theme-options.txt";   
	
	$ot_data_file = 'YToxMTE6e3M6MTU6ImdlbmVyYWxfZGVmYXVsdCI7czo3OiJHZW5lcmFsIjtzOjEwOiJsb2dvX2ltYWdlIjtzOjcwOiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1L2xvZ28ucG5nIjtzOjEwOiJuYXZfbWFyZ2luIjtzOjA6IiI7czoxNDoiY3VzdG9tX2Zhdmljb24iO3M6NzM6Imh0dHA6Ly90aGV0YXVyaXMuY29tL3RoZW1lcy9wdXJpdHkvd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDUvZmF2aWNvbi5wbmciO3M6MTU6Imdsb2JhbF90ZW1wbGF0ZSI7czoxMzoiUmlnaHQgU2lkZWJhciI7czoxMToicHJfdHJhY2tpbmciO3M6MDoiIjtzOjEwOiJhcHBlYXJhbmNlIjtzOjEwOiJBcHBlYXJhbmNlIjtzOjEwOiJ0aGVtZV9za2luIjtzOjU6IkxpZ2h0IjtzOjExOiJ0aGVtZV9jb2xvciI7czo3OiIjZTk3MDE3IjtzOjExOiJob3Zlcl9jb2xvciI7czo0OiIjNDQ0IjtzOjg6ImJnX2NvbG9yIjtzOjA6IiI7czo2OiJiZ19pbWciO3M6MDoiIjtzOjg6ImhvbWVwYWdlIjtzOjg6IkhvbWVwYWdlIjtzOjEzOiJzbGlkZXJfZW5hYmxlIjthOjE6e2k6MDtzOjI3OiJFbmFibGUgdGhlIEhvbWVwYWdlIFNsaWRlci4iO31zOjExOiJob21lcGFnZV9jYyI7czowOiIiO3M6MjM6ImhvbWVwYWdlX3RhZ2xpbmVfZW5hYmxlIjthOjE6e2k6MDtzOjI4OiJFbmFibGUgdGhlIGhvbWVwYWdlIHRhZ2xpbmUuIjt9czoxNjoiaG9tZXBhZ2VfdGFnbGluZSI7czoyMDM6IkhlbGxvIGFuZCBXZWxjb21lIHRvIFB1cml0eSwgYSBOWUMgYmFzZWQgcGhvdG9ncmFwaHkgYWdlbmN5LiA8YnI+IEZlZWwgZnJlZSB0byByZWFkIG1vcmUgPGEgaHJlZj1cIiNcIj5BYm91dCB1czwvYT4gYW5kIGNoZWNrIG91ciA8YSBocmVmPVwiI1wiPlBvcnRmb2xpbzwvYT4uIFF1ZXN0aW9ucz8gPGEgaHJlZj1cIiNcIj5TZW5kIHVzIGEgbWFpbDwvYT4uIjtzOjExOiJyZWNlbnRfd29yayI7YToxOntpOjA7czo0NzoiRW5hYmxlIHRoZSBSZWNlbnQgV29yayBzZWN0aW9uIG9uIHRoZSBob21lcGFnZS4iO31zOjE0OiJyZWNlbnRfd29ya19zdCI7czoxMjoiRm91ciBDb2x1bW5zIjtzOjE0OiJwb3J0Zm9saW9fcGFnZSI7czowOiIiO3M6MTI6InJlY2VudF9wb3N0cyI7YToxOntpOjA7czo0NzoiRW5hYmxlIHRoZSBSZWNlbnQgV29yayBzZWN0aW9uIG9uIHRoZSBob21lcGFnZS4iO31zOjE1OiJyZWNlbnRfcG9zdHNfc3QiO3M6MTI6IkZvdXIgQ29sdW1ucyI7czo0OiJibG9nIjtzOjQ6IkJsb2ciO3M6MTM6ImJsb2dfdGVtcGxhdGUiO3M6MTU6IlJpZ2h0IFNpZGViYXIgMSI7czoxMzoiYmxvZ19wb3N0c19uciI7czoyOiIxMCI7czoxNjoiYmxvZ19jb21tZW50c19uciI7czoyOiIyMCI7czo5OiJwb3J0Zm9saW8iO3M6OToiUG9ydGZvbGlvIjtzOjIzOiJwb3J0Zm9saW9fcG9zdF90ZW1wbGF0ZSI7czoxMjoiTGVmdCBTaWRlYmFyIjtzOjEyOiJhbGxfcHJvamVjdHMiO3M6ODoiU2hvdyBBbGwiO3M6NjoiZm9vdGVyIjtzOjY6IkZvb3RlciI7czoxMToiZm9vdGVyX2NvbHMiO3M6MTI6IkZvdXIgY29sdW1ucyI7czoxMjoiZm9vdGVyX3N0eWxlIjtzOjg6IkZvb3RlciAxIjtzOjk6ImNvcHlyaWdodCI7czo1NToiwqkgMjAxMSA8YSBocmVmPVwiI1wiPlB1cml0eTwvYT4gLSBBbGwgcmlnaHRzIHJlc2VydmVkLiI7czoxNToic29jaWFsX3Byb2ZpbGVzIjtzOjEyOiJTb2NpYWwgTGlua3MiO3M6ODoic29jaWFsXzEiO3M6MToiIyI7czo4OiJzb2NpYWxfMiI7czoxOiIjIjtzOjk6InNvY2lhbF8xNyI7czowOiIiO3M6ODoic29jaWFsXzMiO3M6MToiIyI7czo4OiJzb2NpYWxfNCI7czoxOiIjIjtzOjg6InNvY2lhbF81IjtzOjE6IiMiO3M6ODoic29jaWFsXzYiO3M6MDoiIjtzOjk6InNvY2lhbF8xOSI7czowOiIiO3M6OToic29jaWFsXzE4IjtzOjA6IiI7czo4OiJzb2NpYWxfNyI7czowOiIiO3M6ODoic29jaWFsXzgiO3M6MDoiIjtzOjg6InNvY2lhbF85IjtzOjA6IiI7czo5OiJzb2NpYWxfMTAiO3M6MDoiIjtzOjk6InNvY2lhbF8xMSI7czoxOiIjIjtzOjk6InNvY2lhbF8xMiI7czowOiIiO3M6OToic29jaWFsXzEzIjtzOjA6IiI7czo5OiJzb2NpYWxfMTQiO3M6MDoiIjtzOjk6InNvY2lhbF8xNSI7czowOiIiO3M6OToic29jaWFsXzE2IjtzOjA6IiI7czo2OiJzbGlkZXIiO3M6NjoiU2xpZGVyIjtzOjEzOiJzbGlkZXJfc2xpZGVyIjthOjQ6e2k6MDthOjU6e3M6NToib3JkZXIiO3M6MToiMCI7czo1OiJ0aXRsZSI7czo3OiJTbGlkZSAxIjtzOjU6ImltYWdlIjtzOjY4OiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1LzV3LmpwZyI7czo0OiJsaW5rIjtzOjE6IiMiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjA6IiI7fWk6MTthOjU6e3M6NToib3JkZXIiO3M6MToiMSI7czo1OiJ0aXRsZSI7czo3OiJTbGlkZSAyIjtzOjU6ImltYWdlIjtzOjY5OiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1Lzd3MS5qcGciO3M6NDoibGluayI7czoxOiIjIjtzOjExOiJkZXNjcmlwdGlvbiI7czoyNjoiVGhpcyBpcyBhbiBleGFtcGxlIGNhcHRpb24iO31pOjI7YTo1OntzOjU6Im9yZGVyIjtzOjE6IjIiO3M6NToidGl0bGUiO3M6MDoiIjtzOjU6ImltYWdlIjtzOjY4OiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1Lzh3LmpwZyI7czo0OiJsaW5rIjtzOjE6IiMiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjA6IiI7fWk6MzthOjU6e3M6NToib3JkZXIiO3M6MToiMyI7czo1OiJ0aXRsZSI7czowOiIiO3M6NToiaW1hZ2UiO3M6Njk6Imh0dHA6Ly90aGV0YXVyaXMuY29tL3RoZW1lcy9wdXJpdHkvd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDUvNncxLmpwZyI7czo0OiJsaW5rIjtzOjE6IiMiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjA6IiI7fX1zOjEzOiJzbGlkZXJfaGVpZ2h0IjtzOjM6IjM4MCI7czoxMjoic2xpZGVyX3BhdXNlIjtzOjQ6IjMwMDAiO3M6MTI6InNsaWRlcl9zcGVlZCI7czozOiI3MDAiO3M6MTM6InNsaWRlcl9lZmZlY3QiO3M6NDoiZmFkZSI7czoyMDoic2xpZGVyX2RpcmVjdGlvbl9uYXYiO3M6NToiZmFsc2UiO3M6NzoiY29udGFjdCI7czo3OiJDb250YWN0IjtzOjE2OiJwcl9jb250YWN0X2VtYWlsIjtzOjE3OiJwcmFmZ29uQGdtYWlsLmNvbSI7czoxNToicHJfZm9ybV9zdWNjZXNzIjtzOjQ3OiI8aDI+VGhhbmsgeW91LCB5b3VyIG1lc3NhZ2UgaGFzIGJlZW4gc2VudC48L2gyPiI7czoxNzoidHJfc3VibWl0X2NvbnRhY3QiO3M6NDoiU2VuZCI7czo0OiJmb250IjtzOjEwOiJUeXBvZ3JhcGh5IjtzOjk6ImZvbnRfYm9keSI7czo5OiJPcGVuIFNhbnMiO3M6MTI6ImZvbnRfaGVhZGluZyI7czo5OiJPcGVuIFNhbnMiO3M6NzoiZnNfYm9keSI7czowOiIiO3M6NjoiZnNfbmF2IjtzOjA6IiI7czo1OiJmc19odCI7czowOiIiO3M6NToiZnNfaDEiO3M6MDoiIjtzOjU6ImZzX2gyIjtzOjA6IiI7czo1OiJmc19oMyI7czowOiIiO3M6NToiZnNfaDQiO3M6MDoiIjtzOjU6ImZzX2g1IjtzOjA6IiI7czo1OiJmc19oNiI7czowOiIiO3M6OToidHJhbnNsYXRlIjtzOjk6IlRyYW5zbGF0ZSI7czoyMDoidHJfcmVjZW50X3dvcmtfdGl0bGUiO3M6MTE6IlJlY2VudCBXb3JrIjtzOjE5OiJ0cl9yZWNlbnRfd29ya192aWV3IjtzOjE4OiJWaWV3IFBvcnRmb2xpbyDihpIiO3M6MjE6InRyX3JlY2VudF9wb3N0c190aXRsZSI7czoxMzoiRnJvbSB0aGUgQmxvZyI7czoyMDoidHJfcmVjZW50X3Bvc3RzX3ZpZXciO3M6MTg6IkdvIHRvIHRoZSBCbG9nIOKGkiI7czoxMjoidHJfcmVhZF9tb3JlIjtzOjk6IlJlYWQgbW9yZSI7czo1OiJ0cl9ieSI7czoyOiJCeSI7czo1OiJ0cl9pbiI7czoyOiJJbiI7czo3OiJ0cl90YWdzIjtzOjQ6IlRhZ3MiO3M6MTI6InRyX3Bvc3RlZF9ieSI7czo5OiJQb3N0ZWQgYnkiO3M6MTI6InRyX3Bvc3RlZF9pbiI7czoyOiJpbiI7czo1OiJ0cl9vbiI7czoyOiJvbiI7czoxNDoidHJfbGVhdmVfcmVwbHkiO3M6MTE6IkxlYXZlIFJlcGx5IjtzOjE1OiJ0cl9jYW5jZWxfcmVwbHkiO3M6MTI6IkNhbmNlbCBSZXBseSI7czo4OiJ0cl9yZXBseSI7czo1OiJSZXBseSI7czoxMToidHJfY29tbWVudHMiO3M6ODoiY29tbWVudHMiO3M6MTc6InRyX25ld2VyX2NvbW1lbnRzIjtzOjE0OiJOZXdlciBDb21tZW50cyI7czoxNzoidHJfb2xkZXJfY29tbWVudHMiO3M6MTQ6Ik9sZGVyIENvbW1lbnRzIjtzOjE0OiJ0cl9vbGRlcl9wb3N0cyI7czoxMToiT2xkZXIgUG9zdHMiO3M6MTQ6InRyX25ld2VyX3Bvc3RzIjtzOjExOiJOZXdlciBQb3N0cyI7czo3OiJ0cl9uYW1lIjtzOjQ6Ik5hbWUiO3M6ODoidHJfZW1haWwiO3M6NjoiRS1NYWlsIjtzOjE4OiJ0cl9jb21tZW50X3dlYnNpdGUiO3M6NzoiV2Vic2l0ZSI7czoxODoidHJfY29udGFjdF9zdWJqZWN0IjtzOjc6IlN1YmplY3QiO3M6MTQ6InRyX2NvbW1lbnRfbXNnIjtzOjc6IkNvbW1lbnQiO3M6MTc6InRyX2NvbW1lbnRfc3VibWl0IjtzOjExOiJMZWF2ZSBSZXBseSI7czoxNDoidHJfY29udGFjdF9tc2ciO3M6NzoiTWVzc2FnZSI7czoxNDoidHJfZGl2aWRlcl90b3AiO3M6MzoiVG9wIjtzOjk6InRyX3NlYXJjaCI7czo4OiJTZWFyY2guLiI7czo5OiI0MDRfdGl0bGUiO3M6MTQ6IjQwNCBQYWdlIEVycm9yIjtzOjExOiI0MDRfdGFnbGluZSI7czoxMzoiTm90aGluZyBGb3VuZCI7czo3OiI0MDRfbXNnIjtzOjcxOiI8aDI+UGFnZSBOb3QgRm91bmQ8L2gyPg0KDQo8cD5QYWdlIHlvdSBhcmUgbG9va2luZyBmb3IgaXNuXCd0IGhlcmUuPC9wPiI7czoxMDoicmVzcG9uc2l2ZSI7czoxOToiUmVzcG9uc2l2ZSAmIFJldGluYSI7czoxMToicmV0aW5hX2xvZ28iO3M6Nzc6Imh0dHA6Ly90aGV0YXVyaXMuY29tL3RoZW1lcy9wdXJpdHkvd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDQvbG9nb19yZXRpbmEucG5nIjtzOjE3OiJyZXRpbmFfbG9nb193aWR0aCI7czozOiIxMDAiO30=';
	
	$rawdata = $ot_data_file;
      $new_options = unserialize( base64_decode( $rawdata ) );
      
	// check if array()
	if ( is_array( $new_options ) )
	{
	  // create new options
	  add_option('option_tree', $new_options);
	}
	  
	  
    //$ot_xml_file = get_bloginfo('template_url') . "/admin/settings/theme-options.xml";  
    
    $ot_xml_file = '<?xml version="1.0"?>
    <wp_option_tree>
      <row>
        <id>1</id>
        <item_id>general_default</item_id>
        <item_title>General</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>1</item_sort>
      </row>
      <row>
        <id>2</id>
        <item_id>logo_image</item_id>
        <item_title>Logo Image</item_title>
        <item_desc>Logo image.</item_desc>
        <item_type>upload</item_type>
        <item_options></item_options>
        <item_sort>2</item_sort>
      </row>
      <row>
        <id>3</id>
        <item_id>nav_margin</item_id>
        <item_title>Navigation Top Margin</item_title>
        <item_desc>A space above the page navigation expressed in pixels. Edit it&amp;#039;s value to center the menu vertically while using your own logo image.</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>3</item_sort>
      </row>
      <row>
        <id>4</id>
        <item_id>custom_favicon</item_id>
        <item_title>Favicon</item_title>
        <item_desc>Custom favicon.</item_desc>
        <item_type>upload</item_type>
        <item_options></item_options>
        <item_sort>4</item_sort>
      </row>
      <row>
        <id>5</id>
        <item_id>global_template</item_id>
        <item_title>Default Template Layout</item_title>
        <item_desc>A template for the single blog, portfolio posts and the contact page.</item_desc>
        <item_type>select</item_type>
        <item_options>Right Sidebar, Left Sidebar</item_options>
        <item_sort>5</item_sort>
      </row>
      <row>
        <id>6</id>
        <item_id>pr_tracking</item_id>
        <item_title>Tracking Code</item_title>
        <item_desc>Add your Google Analytics or any other tracking service code here. It will be placed just before the &amp;lt;/body&amp;gt; tag.</item_desc>
        <item_type>textarea</item_type>
        <item_options>8</item_options>
        <item_sort>6</item_sort>
      </row>
      <row>
        <id>7</id>
        <item_id>appearance</item_id>
        <item_title>Appearance</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>7</item_sort>
      </row>
      <row>
        <id>8</id>
        <item_id>theme_skin</item_id>
        <item_title>Theme Skin</item_title>
        <item_desc></item_desc>
        <item_type>radio</item_type>
        <item_options>Light,Dark</item_options>
        <item_sort>8</item_sort>
      </row>
      <row>
        <id>9</id>
        <item_id>theme_color</item_id>
        <item_title>Theme Color</item_title>
        <item_desc>Theme color.</item_desc>
        <item_type>colorpicker</item_type>
        <item_options></item_options>
        <item_sort>9</item_sort>
      </row>
      <row>
        <id>10</id>
        <item_id>hover_color</item_id>
        <item_title>Link Hover Color</item_title>
        <item_desc>A color of links in a hover state.</item_desc>
        <item_type>colorpicker</item_type>
        <item_options></item_options>
        <item_sort>10</item_sort>
      </row>
      <row>
        <id>11</id>
        <item_id>bg_color</item_id>
        <item_title>Background Color</item_title>
        <item_desc>Background color.</item_desc>
        <item_type>colorpicker</item_type>
        <item_options></item_options>
        <item_sort>11</item_sort>
      </row>
      <row>
        <id>12</id>
        <item_id>bg_img</item_id>
        <item_title>Background Image</item_title>
        <item_desc>An image that will be used as your website background.</item_desc>
        <item_type>upload</item_type>
        <item_options></item_options>
        <item_sort>12</item_sort>
      </row>
      <row>
        <id>13</id>
        <item_id>bg_style</item_id>
        <item_title>Fixed Background Position</item_title>
        <item_desc>Enable this option if you have one, big background image and you want it to stay &amp;#039;static&amp;#039; while scrolling the page.</item_desc>
        <item_type>checkbox</item_type>
        <item_options>Enable a fixed position</item_options>
        <item_sort>13</item_sort>
      </row>
      <row>
        <id>14</id>
        <item_id>homepage</item_id>
        <item_title>Homepage</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>14</item_sort>
      </row>
      <row>
        <id>15</id>
        <item_id>slider_enable</item_id>
        <item_title>Homepage Slider</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Enable the Homepage Slider.</item_options>
        <item_sort>15</item_sort>
      </row>
      <row>
        <id>16</id>
        <item_id>homepage_cc</item_id>
        <item_title>Homepage Custom Content</item_title>
        <item_desc>This is a place for a custom HTML code that will displayed on your homepage under the Slider. You may easily place a Vimeo, YouTube video or just a static image. Check the Theme Documentation for code examples.</item_desc>
        <item_type>textarea</item_type>
        <item_options>6</item_options>
        <item_sort>16</item_sort>
      </row>
      <row>
        <id>17</id>
        <item_id>homepage_tagline_enable</item_id>
        <item_title>Homepage Tagline</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Enable the homepage tagline.</item_options>
        <item_sort>17</item_sort>
      </row>
      <row>
        <id>18</id>
        <item_id>homepage_tagline</item_id>
        <item_title>Homepage Tagline</item_title>
        <item_desc>This is the homepage tagline text.</item_desc>
        <item_type>textarea</item_type>
        <item_options>5</item_options>
        <item_sort>18</item_sort>
      </row>
      <row>
        <id>19</id>
        <item_id>recent_work</item_id>
        <item_title>Recent Work</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Enable the Recent Work section on the homepage.</item_options>
        <item_sort>19</item_sort>
      </row>
      <row>
        <id>20</id>
        <item_id>recent_work_st</item_id>
        <item_title>Recent Work Settings</item_title>
        <item_desc></item_desc>
        <item_type>radio</item_type>
        <item_options>Three Columns, Four Columns</item_options>
        <item_sort>20</item_sort>
      </row>
      <row>
        <id>21</id>
        <item_id>portfolio_page</item_id>
        <item_title>View More link</item_title>
        <item_desc>Choose a page where people will be redirected after clicking the &amp;#039;View Portfolio&amp;#039; link, located at the bottom of the Recent Work section.</item_desc>
        <item_type>page</item_type>
        <item_options></item_options>
        <item_sort>21</item_sort>
      </row>
      <row>
        <id>22</id>
        <item_id>recent_posts</item_id>
        <item_title>Recent Posts</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Enable the Recent Work section on the homepage.</item_options>
        <item_sort>22</item_sort>
      </row>
      <row>
        <id>23</id>
        <item_id>recent_posts_st</item_id>
        <item_title>Recent Posts Settings</item_title>
        <item_desc></item_desc>
        <item_type>radio</item_type>
        <item_options>Three Columns, Four Columns</item_options>
        <item_sort>23</item_sort>
      </row>
      <row>
        <id>122</id>
        <item_id>recent_posts_thumbs</item_id>
        <item_title>Recent Posts Thumbnails</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Enable Recent Posts Thumbnails</item_options>
        <item_sort>24</item_sort>
      </row>
      <row>
        <id>24</id>
        <item_id>blog</item_id>
        <item_title>Blog</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>25</item_sort>
      </row>
      <row>
        <id>25</id>
        <item_id>blog_template</item_id>
        <item_title>Blog Template</item_title>
        <item_desc></item_desc>
        <item_type>select</item_type>
        <item_options>Right Sidebar 1, Right Sidebar 2, Right Sidebar 3, Left Sidebar 1, Left Sidebar 2, Left Sidebar 3</item_options>
        <item_sort>26</item_sort>
      </row>
      <row>
        <id>26</id>
        <item_id>blog_posts_nr</item_id>
        <item_title>Posts Per Page</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>27</item_sort>
      </row>
      <row>
        <id>27</id>
        <item_id>blog_comments_nr</item_id>
        <item_title>Comments Per Page</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>28</item_sort>
      </row>
      <row>
        <id>28</id>
        <item_id>portfolio</item_id>
        <item_title>Portfolio</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>29</item_sort>
      </row>
      <row>
        <id>29</id>
        <item_id>filter_disabled</item_id>
        <item_title>Filterable Portfolio</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Disable the filterable portfolio effect.</item_options>
        <item_sort>30</item_sort>
      </row>
      <row>
        <id>30</id>
        <item_id>portfolio_post_template</item_id>
        <item_title>Portfolio Post Template</item_title>
        <item_desc></item_desc>
        <item_type>select</item_type>
        <item_options>Right Sidebar,Left Sidebar</item_options>
        <item_sort>31</item_sort>
      </row>
      <row>
        <id>31</id>
        <item_id>all_projects</item_id>
        <item_title>&amp;#039;All Projects&amp;#039; Title</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>32</item_sort>
      </row>
      <row>
        <id>32</id>
        <item_id>footer</item_id>
        <item_title>Footer</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>33</item_sort>
      </row>
      <row>
        <id>33</id>
        <item_id>footer_disabled</item_id>
        <item_title>Disable Footer Widget Area</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Check to disable the footer widget area.</item_options>
        <item_sort>34</item_sort>
      </row>
      <row>
        <id>34</id>
        <item_id>footer_cols</item_id>
        <item_title>Footer Widget Area Columns</item_title>
        <item_desc></item_desc>
        <item_type>radio</item_type>
        <item_options>Three columns,Four columns,Five columns</item_options>
        <item_sort>35</item_sort>
      </row>
      <row>
        <id>35</id>
        <item_id>footer_style</item_id>
        <item_title>Footer Style</item_title>
        <item_desc></item_desc>
        <item_type>radio</item_type>
        <item_options>Footer 1, Footer 2</item_options>
        <item_sort>36</item_sort>
      </row>
      <row>
        <id>36</id>
        <item_id>copyright</item_id>
        <item_title>Copyright Text</item_title>
        <item_desc>The copyright text that appears on the very bottom of your website.</item_desc>
        <item_type>textarea</item_type>
        <item_options>3</item_options>
        <item_sort>37</item_sort>
      </row>
      <row>
        <id>37</id>
        <item_id>social_profiles</item_id>
        <item_title>Social Links</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>38</item_sort>
      </row>
      <row>
        <id>38</id>
        <item_id>social_disabled</item_id>
        <item_title>Disable Social Icons</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Check this to disable social icons in the footer.</item_options>
        <item_sort>39</item_sort>
      </row>
      <row>
        <id>39</id>
        <item_id>social_1</item_id>
        <item_title>Twitter</item_title>
        <item_desc>Address to your Twitter profile.</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>40</item_sort>
      </row>
      <row>
        <id>40</id>
        <item_id>social_2</item_id>
        <item_title>Facebook</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>41</item_sort>
      </row>
      <row>
        <id>41</id>
        <item_id>social_17</item_id>
        <item_title>Google+</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>42</item_sort>
      </row>
      <row>
        <id>42</id>
        <item_id>social_3</item_id>
        <item_title>Dribbble</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>43</item_sort>
      </row>
      <row>
        <id>43</id>
        <item_id>social_4</item_id>
        <item_title>RSS</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>44</item_sort>
      </row>
      <row>
        <id>44</id>
        <item_id>social_5</item_id>
        <item_title>YouTube</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>45</item_sort>
      </row>
      <row>
        <id>45</id>
        <item_id>social_6</item_id>
        <item_title>Vimeo</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>46</item_sort>
      </row>
      <row>
        <id>124</id>
        <item_id>social_19</item_id>
        <item_title>LinkedIn</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>47</item_sort>
      </row>
      <row>
        <id>123</id>
        <item_id>social_18</item_id>
        <item_title>Pinterest</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>48</item_sort>
      </row>
      <row>
        <id>46</id>
        <item_id>social_7</item_id>
        <item_title>Tumblr</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>49</item_sort>
      </row>
      <row>
        <id>47</id>
        <item_id>social_8</item_id>
        <item_title>Digg</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>50</item_sort>
      </row>
      <row>
        <id>48</id>
        <item_id>social_9</item_id>
        <item_title>Dropbox</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>51</item_sort>
      </row>
      <row>
        <id>49</id>
        <item_id>social_10</item_id>
        <item_title>Delicious</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>52</item_sort>
      </row>
      <row>
        <id>50</id>
        <item_id>social_11</item_id>
        <item_title>Myspace</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>53</item_sort>
      </row>
      <row>
        <id>51</id>
        <item_id>social_12</item_id>
        <item_title>Skype</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>54</item_sort>
      </row>
      <row>
        <id>52</id>
        <item_id>social_13</item_id>
        <item_title>Plixi</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>55</item_sort>
      </row>
      <row>
        <id>53</id>
        <item_id>social_14</item_id>
        <item_title>StubleUpon</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>56</item_sort>
      </row>
      <row>
        <id>54</id>
        <item_id>social_15</item_id>
        <item_title>Last.fm</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>57</item_sort>
      </row>
      <row>
        <id>55</id>
        <item_id>social_16</item_id>
        <item_title>Mobypicture</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>58</item_sort>
      </row>
      <row>
        <id>56</id>
        <item_id>slider</item_id>
        <item_title>Slider</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>59</item_sort>
      </row>
      <row>
        <id>57</id>
        <item_id>slider_slider</item_id>
        <item_title>Slider Images</item_title>
        <item_desc></item_desc>
        <item_type>slider</item_type>
        <item_options></item_options>
        <item_sort>60</item_sort>
      </row>
      <row>
        <id>58</id>
        <item_id>slider_height</item_id>
        <item_title>Slider Height</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>61</item_sort>
      </row>
      <row>
        <id>59</id>
        <item_id>slider_pause</item_id>
        <item_title>Pause Time</item_title>
        <item_desc>0 to disable autoplay.</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>62</item_sort>
      </row>
      <row>
        <id>60</id>
        <item_id>slider_speed</item_id>
        <item_title>Animation Speed</item_title>
        <item_desc>Slider animation speed.</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>63</item_sort>
      </row>
      <row>
        <id>61</id>
        <item_id>slider_effect</item_id>
        <item_title>Animation Effect</item_title>
        <item_desc>Slider animation effect.</item_desc>
        <item_type>select</item_type>
        <item_options>fade,slide</item_options>
        <item_sort>64</item_sort>
      </row>
      <row>
        <id>62</id>
        <item_id>slider_direction_nav</item_id>
        <item_title>Direction Nav</item_title>
        <item_desc></item_desc>
        <item_type>radio</item_type>
        <item_options>false,true</item_options>
        <item_sort>65</item_sort>
      </row>
      <row>
        <id>63</id>
        <item_id>contact</item_id>
        <item_title>Contact</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>66</item_sort>
      </row>
      <row>
        <id>64</id>
        <item_id>pr_contact_email</item_id>
        <item_title>E-Mail Address</item_title>
        <item_desc>Your contact E-mail address.</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>67</item_sort>
      </row>
      <row>
        <id>65</id>
        <item_id>pr_form_success</item_id>
        <item_title>Form Success Text</item_title>
        <item_desc>A text that appears after the contact form is succesfully submitted (HTML allowed).</item_desc>
        <item_type>textarea</item_type>
        <item_options>2</item_options>
        <item_sort>68</item_sort>
      </row>
      <row>
        <id>66</id>
        <item_id>tr_submit_contact</item_id>
        <item_title>Contact Form Submit Value</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>69</item_sort>
      </row>
      <row>
        <id>67</id>
        <item_id>font</item_id>
        <item_title>Typography</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>70</item_sort>
      </row>
      <row>
        <id>68</id>
        <item_id>font_size</item_id>
        <item_title>Typography</item_title>
        <item_desc></item_desc>
        <item_type>textblock</item_type>
        <item_options></item_options>
        <item_sort>71</item_sort>
      </row>
      <row>
        <id>120</id>
        <item_id>font_body</item_id>
        <item_title>Body Font</item_title>
        <item_desc>Choose the website body font. &amp;lt;br&amp;gt;Default: Helvetica</item_desc>
        <item_type>select</item_type>
        <item_options>Arvo,Dancing Script,Droid Sans,Droid Serif,Hammersmith One,Helvetica/Arial,Helvetica Neue,Josefin Slab,Kaffeesatz,Lato,Open Sans,Open Sans Condensed,Oswald,PT Sans,Raleway,Times New Roman,Ubuntu,Vollkorn,Yanone</item_options>
        <item_sort>72</item_sort>
      </row>
      <row>
        <id>121</id>
        <item_id>font_heading</item_id>
        <item_title>Heading Font</item_title>
        <item_desc>Choose a font for Headings, Navigation and Page Titles.&amp;lt;br&amp;gt;
    Default: League Gothic</item_desc>
        <item_type>select</item_type>
        <item_options>Arvo,Dancing Script,Droid Sans,Droid Serif,Hammersmith One,Helvetica/Arial,Helvetica Neue,Josefin Slab,Kaffeesatz,Lato,League Gothic,Open Sans,Open Sans Condensed,Oswald,PT Sans,Raleway,Times New Roman,Ubuntu,Vollkorn,Yanone</item_options>
        <item_sort>73</item_sort>
      </row>
      <row>
        <id>69</id>
        <item_id>fs_body</item_id>
        <item_title>Body Font Size</item_title>
        <item_desc>Body (paragraphs) font size given in pixels. Default: 12</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>74</item_sort>
      </row>
      <row>
        <id>70</id>
        <item_id>fs_nav</item_id>
        <item_title>Navigation Bar</item_title>
        <item_desc>Default: 22</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>75</item_sort>
      </row>
      <row>
        <id>71</id>
        <item_id>fs_ht</item_id>
        <item_title>Homepage Tagline</item_title>
        <item_desc>Default: 32</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>76</item_sort>
      </row>
      <row>
        <id>72</id>
        <item_id>fs_h1</item_id>
        <item_title>Heading H1</item_title>
        <item_desc>Default: 30</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>77</item_sort>
      </row>
      <row>
        <id>73</id>
        <item_id>fs_h2</item_id>
        <item_title>Heading H2</item_title>
        <item_desc>Default: 28</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>78</item_sort>
      </row>
      <row>
        <id>74</id>
        <item_id>fs_h3</item_id>
        <item_title>Heading H3</item_title>
        <item_desc>Default: 26</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>79</item_sort>
      </row>
      <row>
        <id>75</id>
        <item_id>fs_h4</item_id>
        <item_title>Heading H4</item_title>
        <item_desc>Default: 22</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>80</item_sort>
      </row>
      <row>
        <id>76</id>
        <item_id>fs_h5</item_id>
        <item_title>Heading H5</item_title>
        <item_desc>Default: 11</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>81</item_sort>
      </row>
      <row>
        <id>77</id>
        <item_id>fs_h6</item_id>
        <item_title>Heading H6</item_title>
        <item_desc>Default: 10</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>82</item_sort>
      </row>
      <row>
        <id>78</id>
        <item_id>translate</item_id>
        <item_title>Translate</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>83</item_sort>
      </row>
      <row>
        <id>79</id>
        <item_id>test</item_id>
        <item_title>Homepage Translate</item_title>
        <item_desc></item_desc>
        <item_type>textblock</item_type>
        <item_options></item_options>
        <item_sort>84</item_sort>
      </row>
      <row>
        <id>80</id>
        <item_id>tr_recent_work_title</item_id>
        <item_title>Recent Work Title</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>85</item_sort>
      </row>
      <row>
        <id>81</id>
        <item_id>tr_recent_work_view</item_id>
        <item_title>Recent Work - Link Title</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>86</item_sort>
      </row>
      <row>
        <id>82</id>
        <item_id>tr_recent_posts_title</item_id>
        <item_title>Recent Posts Title</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>87</item_sort>
      </row>
      <row>
        <id>83</id>
        <item_id>tr_recent_posts_view</item_id>
        <item_title>Recent Posts - Link Title</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>88</item_sort>
      </row>
      <row>
        <id>84</id>
        <item_id>blog_translate</item_id>
        <item_title>Blog Translate</item_title>
        <item_desc></item_desc>
        <item_type>textblock</item_type>
        <item_options></item_options>
        <item_sort>89</item_sort>
      </row>
      <row>
        <id>85</id>
        <item_id>tr_read_more</item_id>
        <item_title>Read More</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>90</item_sort>
      </row>
      <row>
        <id>86</id>
        <item_id>tr_by</item_id>
        <item_title>By</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>91</item_sort>
      </row>
      <row>
        <id>87</id>
        <item_id>tr_in</item_id>
        <item_title>In</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>92</item_sort>
      </row>
      <row>
        <id>88</id>
        <item_id>tr_tags</item_id>
        <item_title>Tags</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>93</item_sort>
      </row>
      <row>
        <id>89</id>
        <item_id>tr_posted_by</item_id>
        <item_title>Posted By</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>94</item_sort>
      </row>
      <row>
        <id>90</id>
        <item_id>tr_posted_in</item_id>
        <item_title>Posted In</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>95</item_sort>
      </row>
      <row>
        <id>91</id>
        <item_id>tr_on</item_id>
        <item_title>On</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>96</item_sort>
      </row>
      <row>
        <id>92</id>
        <item_id>tr_leave_reply</item_id>
        <item_title>Leave Reply</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>97</item_sort>
      </row>
      <row>
        <id>93</id>
        <item_id>tr_cancel_reply</item_id>
        <item_title>Cancel Reply</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>98</item_sort>
      </row>
      <row>
        <id>94</id>
        <item_id>tr_reply</item_id>
        <item_title>Reply</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>99</item_sort>
      </row>
      <row>
        <id>95</id>
        <item_id>tr_comments</item_id>
        <item_title>Comments</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>100</item_sort>
      </row>
      <row>
        <id>96</id>
        <item_id>tr_newer_comments</item_id>
        <item_title>Newer Comments</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>101</item_sort>
      </row>
      <row>
        <id>97</id>
        <item_id>tr_older_comments</item_id>
        <item_title>Older Comments</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>102</item_sort>
      </row>
      <row>
        <id>98</id>
        <item_id>tr_older_posts</item_id>
        <item_title>Older Posts</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>103</item_sort>
      </row>
      <row>
        <id>99</id>
        <item_id>tr_newer_posts</item_id>
        <item_title>Newer Posts</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>104</item_sort>
      </row>
      <row>
        <id>100</id>
        <item_id>forms_translate</item_id>
        <item_title>Forms Translate</item_title>
        <item_desc></item_desc>
        <item_type>textblock</item_type>
        <item_options></item_options>
        <item_sort>105</item_sort>
      </row>
      <row>
        <id>101</id>
        <item_id>tr_name</item_id>
        <item_title>Form &amp;#039;Name&amp;#039;</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>106</item_sort>
      </row>
      <row>
        <id>102</id>
        <item_id>tr_email</item_id>
        <item_title>Form &amp;#039;Email&amp;#039;</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>107</item_sort>
      </row>
      <row>
        <id>103</id>
        <item_id>tr_comment_website</item_id>
        <item_title>Form &amp;#039;Website&amp;#039;</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>108</item_sort>
      </row>
      <row>
        <id>104</id>
        <item_id>tr_contact_subject</item_id>
        <item_title>Form &amp;#039;Subject&amp;#039;</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>109</item_sort>
      </row>
      <row>
        <id>105</id>
        <item_id>tr_comment_msg</item_id>
        <item_title>Comment Form Content</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>110</item_sort>
      </row>
      <row>
        <id>106</id>
        <item_id>tr_comment_submit</item_id>
        <item_title>Submit Comment Form</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>111</item_sort>
      </row>
      <row>
        <id>107</id>
        <item_id>tr_contact_msg</item_id>
        <item_title>Contact Form Content</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>112</item_sort>
      </row>
      <row>
        <id>108</id>
        <item_id>others_translate</item_id>
        <item_title>Others Translate</item_title>
        <item_desc></item_desc>
        <item_type>textblock</item_type>
        <item_options></item_options>
        <item_sort>113</item_sort>
      </row>
      <row>
        <id>109</id>
        <item_id>tr_divider_top</item_id>
        <item_title>Divider &amp;#039;Top&amp;#039;</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>114</item_sort>
      </row>
      <row>
        <id>110</id>
        <item_id>tr_search</item_id>
        <item_title>Search</item_title>
        <item_desc></item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>115</item_sort>
      </row>
      <row>
        <id>111</id>
        <item_id>404_page_template</item_id>
        <item_title>404 Page Template</item_title>
        <item_desc></item_desc>
        <item_type>textblock</item_type>
        <item_options></item_options>
        <item_sort>116</item_sort>
      </row>
      <row>
        <id>112</id>
        <item_id>404_title</item_id>
        <item_title>Page Title</item_title>
        <item_desc>404 page title.</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>117</item_sort>
      </row>
      <row>
        <id>113</id>
        <item_id>404_tagline</item_id>
        <item_title>Page Tagline</item_title>
        <item_desc>Optional 404 page tagline.</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>118</item_sort>
      </row>
      <row>
        <id>114</id>
        <item_id>404_msg</item_id>
        <item_title>Error Message</item_title>
        <item_desc>Error message displayed in the content area - full HTML support.</item_desc>
        <item_type>textarea</item_type>
        <item_options>4</item_options>
        <item_sort>119</item_sort>
      </row>
      <row>
        <id>115</id>
        <item_id>responsive</item_id>
        <item_title>Responsive &amp;amp; Retina</item_title>
        <item_desc></item_desc>
        <item_type>heading</item_type>
        <item_options></item_options>
        <item_sort>120</item_sort>
      </row>
      <row>
        <id>116</id>
        <item_id>theme_responsive</item_id>
        <item_title>Theme Responsiveness</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Disable theme responsiveness</item_options>
        <item_sort>121</item_sort>
      </row>
      <row>
        <id>117</id>
        <item_id>theme_retina</item_id>
        <item_title>Retina Icons</item_title>
        <item_desc></item_desc>
        <item_type>checkbox</item_type>
        <item_options>Disable retina icons</item_options>
        <item_sort>122</item_sort>
      </row>
      <row>
        <id>118</id>
        <item_id>retina_logo</item_id>
        <item_title>Retina Logo</item_title>
        <item_desc>Upload your website logo in higher quality for retina devices</item_desc>
        <item_type>upload</item_type>
        <item_options></item_options>
        <item_sort>123</item_sort>
      </row>
      <row>
        <id>119</id>
        <item_id>retina_logo_width</item_id>
        <item_title>Retina Logo Width</item_title>
        <item_desc>Insert the width value for your retina logo. Basic value: 200</item_desc>
        <item_type>input</item_type>
        <item_options></item_options>
        <item_sort>124</item_sort>
      </row>
    </wp_option_tree>
    ';  
          
    $rawdata = $ot_xml_file;
    $new_options = new SimpleXMLElement( $rawdata );

    // create table
    if ($new_installation) {

    $wpdb->query( "DROP TABLE $this->table_name" );    
    $wpdb->query( $this->option_tree_table( 'create' ));

    }  

      // insert data
    foreach ( $new_options->row as $value ) 
    {
    $wpdb->insert( $this->table_name, 
      array( 
        'item_id' => $value->item_id,
        'item_title' => $value->item_title,
        'item_desc' => $value->item_desc,
        'item_type' => $value->item_type,
        'item_options' => $value->item_options
      )
    );

    }

    $string = "Theme Data Contents Here";

    // Unserialize The Array
    $new_options = unserialize( base64_decode( $string ) );

    // check if array()
    if ( is_array( $new_options ) ) 
    {
      // delete old options
      delete_option( 'option_tree' );

      // create new options
      add_option('option_tree', $new_options);

      // redirect
      //die();

      header("Location: admin.php?page=option_tree&xml=true");     

    }

  } 

  /**
   * Restore Table Data if empty
   *
   * @uses delete_option()
   * @uses option_tree_activate()
   * @uses wp_redirect()
   * @uses admin_url()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_restore_default_data() 
  {
    global $wpdb;

    // drop table
    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

    if (!$new_installation) $wpdb->query( "DROP TABLE $this->table_name" );

    // remove activation check
    delete_option( 'option_tree_version' );

    // load DB activation function
    $this->option_tree_activate();

    // Redirect
    wp_redirect( admin_url().'admin.php?page=option_tree' );
  }

  /**
   * Add Admin Menu Items & Test Actions
   *
   * @uses option_tree_export_xml()
   * @uses option_tree_data()
   * @uses get_results()
   * @uses option_tree_restore_default_data()
   * @uses option_tree_activate()
   * @uses get_option()
   * @uses option_tree_import_xml()
   * @uses get_user_option()
   * @uses add_object_page()
   * @uses add_submenu_page()
   * @uses add_action()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $param
   *
   * @return void
   */
  function option_tree_admin() 
  {
    global $wpdb;

      // export XML - run before anything else
      if ( isset($_GET['action']) && $_GET['action'] == 'export' )
      option_tree_export_xml( $this->option_tree_data(), $this->table_name );

    // grab saved table option
    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;

    if (!$new_installation) $test_options = $wpdb->get_results( "SELECT * FROM {$this->table_name}" );

    // restore table if needed
      if ( empty( $test_options ) )
      $this->option_tree_restore_default_data();

    // upgrade DB automatically
    $this->option_tree_activate();

    // load options array
      $settings = get_option( 'option_tree' );

    // upload xml data
    $this->option_tree_import_xml();

    // set admin color
    $icon = ( get_user_option( 'admin_color' ) == 'classic' ) ? OT_PLUGIN_URL.'/assets/images/generic.png' : OT_PLUGIN_URL.'/assets/images/generic.png';

    // create menu items
      add_object_page( 'Purity', 'Purity', 'manage_options', 'option_tree', array( $this, 'option_tree_options_page' ), $icon);
      $option_tree_options = add_submenu_page( 'option_tree', 'OptionTree', 'Theme Options', 'manage_options', 'option_tree', array( $this, 'option_tree_options_page' ) );
	  $option_tree_slider = add_submenu_page( 'option_tree', 'OptionTree', 'Slider', 'manage_options', 'option_tree_slider', array( $this, 'option_tree_slider_page' ) );
      
      // add menu items
      add_action( "admin_print_styles-$option_tree_options", array( $this, 'option_tree_load' ) );
	  add_action( "admin_print_styles-$option_tree_slider", array( $this, 'option_tree_load' ) );
  }

  /**
   * Load Scripts & Styles
   *
   * @uses wp_enqueue_style()
   * @uses get_user_option()
   * @uses add_thickbox()
   * @uses wp_enqueue_script()
   * @uses wp_deregister_style()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_load() 
  {
    // enqueue styles
    wp_enqueue_style( 'option-tree-style', OT_PLUGIN_URL.'/assets/css/style.css', false, $this->version, 'screen');

    // classic admin theme styles
    if ( get_user_option( 'admin_color') == 'classic' ) 
      wp_enqueue_style( 'option-tree-style-classic', OT_PLUGIN_URL.'/assets/css/style-classic.css', array( 'option-tree-style' ), $this->version, 'screen');

    // enqueue scripts
    add_thickbox();
    wp_enqueue_script( 'jquery-table-dnd', OT_PLUGIN_URL.'/assets/js/jquery.table.dnd.js', array('jquery'), $this->version );
    wp_enqueue_script( 'jquery-color-picker', OT_PLUGIN_URL.'/assets/js/jquery.color.picker.js', array('jquery'), $this->version );
    wp_enqueue_script( 'jquery-option-tree', OT_PLUGIN_URL.'/assets/js/jquery.option.tree.js', array('jquery','media-upload','thickbox','jquery-ui-core','jquery-ui-tabs','jquery-table-dnd','jquery-color-picker', 'jquery-ui-sortable'), $this->version );

    // remove GD star rating conflicts
    wp_deregister_style( 'gdsr-jquery-ui-core' );
    wp_deregister_style( 'gdsr-jquery-ui-theme' );
  }

  /**
   * Grab the wp_option_tree table options array
   *
   * @uses get_results()
   *
   * @access public
   * @since 1.0.0
   *
   * @return array
   */
  function option_tree_data() 
  {
    global $wpdb;

    // create an array of options

    $new_installation = $wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name;    
    if (!$new_installation)
    $db_options = $wpdb->get_results( "SELECT * FROM {$this->table_name} ORDER BY item_sort ASC" );
    return $db_options;
  }

  /**
   * Theme Options Page
   *
   * @uses get_option()
   * @uses get_option_page_ID()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_notice_post_locked()
   *
   * @access public
   * @since 1.0.0
   *
   * @return string
   */
  function option_tree_options_page() 
  {
    // set 
    $ot_array = $this->option_array;

    // load saved option_tree
    $settings = get_option( 'option_tree' );

    // private page ID
    $post_id = $this->get_option_page_ID( 'media' );

    // set post lock
    if ( $last = $this->option_tree_check_post_lock( $post_id ) ) 
    {
      $message = $this->option_tree_notice_post_locked( $post_id );
      } 
      else 
      {
          $this->option_tree_set_post_lock( $post_id );
      }

    // Grab Options Page
    include( OT_PLUGIN_DIR.'/front-end/options.php' );
  }

  /**
   * Settings Page
   *
   * @uses get_option()
   * @uses get_option_page_ID()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_check_post_lock()
   * @uses option_tree_notice_post_locked()
   *
   * @access public
   * @since 1.0.0
   *
   * @return string
   */
  function option_tree_settings_page() 
  {
    $ot_array = $this->option_array;

    // Load Saved Options
      $settings = get_option('option_tree');

      // private page ID
    $post_id = $this->get_option_page_ID( 'options' );

    // set post lock
    if ( $last = $this->option_tree_check_post_lock( $post_id ) ) 
    {
      $message = $this->option_tree_notice_post_locked( $post_id );
      } 
      else 
      {
          $this->option_tree_set_post_lock( $post_id );
      }

    // Get Settings Page
    include( OT_PLUGIN_DIR.'/front-end/settings.php');
  }

  /**
   * Documentation Page
   *
   * @access public
   * @since 1.0.0
   *
   * @return string
   */
  function option_tree_docs_page() 
  {
    // hook before page loads
    do_action( 'option_tree_admin_header' );
    
    // Get Settings Page
    include( OT_PLUGIN_DIR . '/front-end/docs.php' );
  }
  
  function option_tree_slider_page() 
  {

	
	$ot_array = $this->option_array;
    
    // Load Saved Options
  	$settings = get_option('option_tree');
  	
  	// Load Saved Layouts
  	$layouts = get_option('option_tree_layouts');
  	
  	// private page ID
    $post_id = $this->get_option_page_ID( 'options' );
    
    // set post lock
    if ( $last = $this->option_tree_check_post_lock( $post_id ) ) 
    {
      $message = $this->option_tree_notice_post_locked( $post_id );
  	} 
  	else 
  	{
  		$this->option_tree_set_post_lock( $post_id );
  	}

    // Get Settings Page
    include( OT_PLUGIN_DIR.'/front-end/slider.php');
  }

  /**
   * Save Theme Option via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update_option()
   * @uses option_tree_set_post_lock()
   * @uses get_option_page_ID()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_array_save() 
  {
    // Check AJAX Referer
    check_ajax_referer( '_theme_options', '_ajax_nonce' );

    // set option values
    foreach ( $this->option_array as $value ) 
    {
      $key = trim( $value->item_id );
      if ( isset( $_REQUEST[$key] ) )
      { 
        $val = $_REQUEST[$key];
        $new_settings[$key] = $val;
      }
      }

      // Update Theme Options
    update_option( 'option_tree', $new_settings );
    $this->option_tree_set_post_lock( $this->get_option_page_ID( 'media' ) );

      die();

  }

  /**
   * Reset Theme Option via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update_option()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_array_reset() 
  {
    // Check AJAX Referer
    check_ajax_referer( '_theme_options', '_ajax_nonce' );

    // clear option values
    foreach ( $this->option_array as $value ) 
    {
      $key = $value->item_id;
      $new_options[$key] = '';
    }

    // update theme Options
    update_option( 'option_tree', $new_options );

      die();
  }

  /**
   * Insert Row into Option Setting Table via AJAX
   *
   * @uses check_ajax_referer()
   * @uses get_results()
   * @uses insert()
   * @uses get_var()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_add() {
      global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // grab fresh options array
    $ot_array = $wpdb->get_results( "SELECT * FROM {$this->table_name}" );

    // get form data
    $id = $_POST['id'];
      $item_id       = htmlspecialchars(stripslashes(trim($_POST['item_id'])), ENT_QUOTES,'UTF-8',true);
      $item_title    = htmlspecialchars(stripslashes(trim($_POST['item_title'])), ENT_QUOTES,'UTF-8',true);
      $item_desc     = htmlspecialchars(stripslashes(trim($_POST['item_desc'])), ENT_QUOTES,'UTF-8',true);
      $item_type     = htmlspecialchars(stripslashes(trim($_POST['item_type'])), ENT_QUOTES,'UTF-8',true);
      $item_options  = htmlspecialchars(stripslashes(trim($_POST['item_options'])), ENT_QUOTES,'UTF-8',true);

      // validate item key
      foreach( $ot_array as $value ) 
      {
      if ( $item_id == $value->item_id ) 
      {
        die( "That option key is already in use." );
      }
      }

      // verify key is alphanumeric
    if ( eregi( '[^a-z0-9_]', $item_id ) ) 
      die("You must enter a valid option key.");

      // verify title
    if (strlen($item_title) < 1 ) 
      die("You must give your option a title.");

    if ( $item_type == 'textarea' && !is_numeric( $item_options ) )
      die("The row value must be numeric.");

    // update row
    $wpdb->insert( $this->table_name, 
      array( 
        'item_id' => $item_id,
        'item_title' => $item_title,
        'item_desc' => $item_desc,
        'item_type' => $item_type,
        'item_options' => $item_options,
        'item_sort' => $id
      )
    );

    // verify values in the DB are updated
    $updated = $wpdb->get_var(" 
      SELECT id 
      FROM {$this->table_name}
      WHERE item_id = '$item_id'
      AND item_title = '$item_title'
      AND item_type = '$item_type'
      AND item_options = '$item_options'
      ");

    // if updated
    if ( $updated )
    {
      die('updated');
    } 
    else
    {
      die("There was an error, please try again.");
    }
  }

  /**
   * Update Option Setting Table via AJAX
   *
   * @uses check_ajax_referer()
   * @uses get_results()
   * @uses update()
   * @uses get_var()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_edit() {
      global $wpdb;

    // Check AJAX Referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // grab fresh options array
    $ot_array = $wpdb->get_results( "SELECT * FROM {$this->table_name}" );

    // get form data
      $id = $_POST['id'];
      $item_id       = htmlspecialchars(stripslashes(trim($_POST['item_id'])), ENT_QUOTES,'UTF-8',true);
      $item_title    = htmlspecialchars(stripslashes(trim($_POST['item_title'])), ENT_QUOTES,'UTF-8',true);
      $item_desc     = htmlspecialchars(stripslashes(trim($_POST['item_desc'])), ENT_QUOTES,'UTF-8',true);
      $item_type     = htmlspecialchars(stripslashes(trim($_POST['item_type'])), ENT_QUOTES,'UTF-8',true);
      $item_options  = htmlspecialchars(stripslashes(trim($_POST['item_options'])), ENT_QUOTES,'UTF-8',true);

      // validate item key
      foreach($ot_array as $value) 
      {
      if ( $value->item_sort == $id ) 
      {
        if ($item_id == $value->item_id && $value->item_sort != $id) 
        {
          die("That option key is already in use.");
        }
      } 
      else if ($item_id == $value->item_id && $value->id != $id) 
      {
        die("That option key is already in use.");
      }
      }

      // verify key is alphanumeric
    if ( eregi( '[^a-z0-9_]', $item_id ) ) 
      die("You must enter a valid option key.");

      // verify title
      if ( strlen( $item_title ) < 1 ) 
      die("You must give your option a title.");

    if ( $item_type == 'textarea' && !is_numeric( $item_options ) )
      die("The row value must be numeric.");

    // update row
    $wpdb->update( $this->table_name, 
      array( 
        'item_id' => $item_id, 
        'item_title' => $item_title, 
        'item_desc' => $item_desc, 
        'item_type' => $item_type, 
        'item_options' => $item_options 
      ), 
      array( 
        'id' => $id 
      )
    );

    // verify values in the DB are updated
    $updated = $wpdb->get_var(" 
      SELECT id 
      FROM {$this->table_name}
      WHERE item_id = '$item_id'
      AND item_title = '$item_title'
      AND item_type = '$item_type'
      AND item_options = '$item_options'
      ");

    // if updated
    if ( $updated ) 
    {
      die('updated');
    } 
    else 
    {
      die("There was an error, please try again.");
    }
  }

  /**
   * Remove Option via AJAX
   *
   * @uses check_ajax_referer()
   * @uses query()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_delete() 
  {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // grab ID
      $id = $_REQUEST['id'];

    // delete item
      $wpdb->query(" 
      DELETE FROM $this->table_name 
      WHERE id = '$id'
    ");

      die('removed');
  }

  /**
   * Get Option ID via AJAX
   *
   * @uses check_ajax_referer()
   * @uses delete_post_meta()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_next_id() 
  {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // get ID
    $id = $wpdb->get_var( "SELECT id FROM {$this->table_name} ORDER BY id DESC LIMIT 1" );

    // return ID
      die($id);
  }

  /**
   * Update Sort Order via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_sort() {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( 'inlineeditnonce', '_ajax_nonce' );

    // create an array of IDs
      $fields = explode('&', $_REQUEST['id']);

      // set order
      $order = 0;

    // update the sort order
      foreach( $fields as $field ) {
          $order++;
          $key = explode('=', $field);
          $id = urldecode($key[1]);
          $wpdb->update( $this->table_name, 
        array(
          'item_sort' => $order 
        ), 
        array( 
          'id' => $id 
        )
      );
      }
      die();
  }

  /**
   * Upload XML Option Data
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_import_xml() 
  {
    global $wpdb;

    // action == upload
    if ( isset($_GET['action']) && $_GET['action'] == 'upload' ) 
    {
      {
        // success - it's XML
          $rawdata = '<?xml version="1.0"?>
          <wp_option_tree>
            <row>
              <id>1</id>
              <item_id>general_default</item_id>
              <item_title>General</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>1</item_sort>
            </row>
            <row>
              <id>2</id>
              <item_id>logo_image</item_id>
              <item_title>Logo Image</item_title>
              <item_desc>Logo image.</item_desc>
              <item_type>upload</item_type>
              <item_options></item_options>
              <item_sort>2</item_sort>
            </row>
            <row>
              <id>3</id>
              <item_id>nav_margin</item_id>
              <item_title>Navigation Top Margin</item_title>
              <item_desc>A space above the page navigation expressed in pixels. Edit it&amp;#039;s value to center the menu vertically while using your own logo image.</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>3</item_sort>
            </row>
            <row>
              <id>4</id>
              <item_id>custom_favicon</item_id>
              <item_title>Favicon</item_title>
              <item_desc>Custom favicon.</item_desc>
              <item_type>upload</item_type>
              <item_options></item_options>
              <item_sort>4</item_sort>
            </row>
            <row>
              <id>5</id>
              <item_id>global_template</item_id>
              <item_title>Default Template Layout</item_title>
              <item_desc>A template for the single blog, portfolio posts and the contact page.</item_desc>
              <item_type>select</item_type>
              <item_options>Right Sidebar, Left Sidebar</item_options>
              <item_sort>5</item_sort>
            </row>
            <row>
              <id>6</id>
              <item_id>pr_tracking</item_id>
              <item_title>Tracking Code</item_title>
              <item_desc>Add your Google Analytics or any other tracking service code here. It will be placed just before the &amp;lt;/body&amp;gt; tag.</item_desc>
              <item_type>textarea</item_type>
              <item_options>8</item_options>
              <item_sort>6</item_sort>
            </row>
            <row>
              <id>7</id>
              <item_id>appearance</item_id>
              <item_title>Appearance</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>7</item_sort>
            </row>
            <row>
              <id>8</id>
              <item_id>theme_skin</item_id>
              <item_title>Theme Skin</item_title>
              <item_desc></item_desc>
              <item_type>radio</item_type>
              <item_options>Light,Dark</item_options>
              <item_sort>8</item_sort>
            </row>
            <row>
              <id>9</id>
              <item_id>theme_color</item_id>
              <item_title>Theme Color</item_title>
              <item_desc>Theme color.</item_desc>
              <item_type>colorpicker</item_type>
              <item_options></item_options>
              <item_sort>9</item_sort>
            </row>
            <row>
              <id>10</id>
              <item_id>hover_color</item_id>
              <item_title>Link Hover Color</item_title>
              <item_desc>A color of links in a hover state.</item_desc>
              <item_type>colorpicker</item_type>
              <item_options></item_options>
              <item_sort>10</item_sort>
            </row>
            <row>
              <id>11</id>
              <item_id>bg_color</item_id>
              <item_title>Background Color</item_title>
              <item_desc>Background color.</item_desc>
              <item_type>colorpicker</item_type>
              <item_options></item_options>
              <item_sort>11</item_sort>
            </row>
            <row>
              <id>12</id>
              <item_id>bg_img</item_id>
              <item_title>Background Image</item_title>
              <item_desc>An image that will be used as your website background.</item_desc>
              <item_type>upload</item_type>
              <item_options></item_options>
              <item_sort>12</item_sort>
            </row>
            <row>
              <id>13</id>
              <item_id>bg_style</item_id>
              <item_title>Fixed Background Position</item_title>
              <item_desc>Enable this option if you have one, big background image and you want it to stay &amp;#039;static&amp;#039; while scrolling the page.</item_desc>
              <item_type>checkbox</item_type>
              <item_options>Enable a fixed position</item_options>
              <item_sort>13</item_sort>
            </row>
            <row>
              <id>14</id>
              <item_id>homepage</item_id>
              <item_title>Homepage</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>14</item_sort>
            </row>
            <row>
              <id>15</id>
              <item_id>slider_enable</item_id>
              <item_title>Homepage Slider</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Enable the Homepage Slider.</item_options>
              <item_sort>15</item_sort>
            </row>
            <row>
              <id>16</id>
              <item_id>homepage_cc</item_id>
              <item_title>Homepage Custom Content</item_title>
              <item_desc>This is a place for a custom HTML code that will displayed on your homepage under the Slider. You may easily place a Vimeo, YouTube video or just a static image. Check the Theme Documentation for code examples.</item_desc>
              <item_type>textarea</item_type>
              <item_options>6</item_options>
              <item_sort>16</item_sort>
            </row>
            <row>
              <id>17</id>
              <item_id>homepage_tagline_enable</item_id>
              <item_title>Homepage Tagline</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Enable the homepage tagline.</item_options>
              <item_sort>17</item_sort>
            </row>
            <row>
              <id>18</id>
              <item_id>homepage_tagline</item_id>
              <item_title>Homepage Tagline</item_title>
              <item_desc>This is the homepage tagline text.</item_desc>
              <item_type>textarea</item_type>
              <item_options>5</item_options>
              <item_sort>18</item_sort>
            </row>
            <row>
              <id>19</id>
              <item_id>recent_work</item_id>
              <item_title>Recent Work</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Enable the Recent Work section on the homepage.</item_options>
              <item_sort>19</item_sort>
            </row>
            <row>
              <id>20</id>
              <item_id>recent_work_st</item_id>
              <item_title>Recent Work Settings</item_title>
              <item_desc></item_desc>
              <item_type>radio</item_type>
              <item_options>Three Columns, Four Columns</item_options>
              <item_sort>20</item_sort>
            </row>
            <row>
              <id>21</id>
              <item_id>portfolio_page</item_id>
              <item_title>View More link</item_title>
              <item_desc>Choose a page where people will be redirected after clicking the &amp;#039;View Portfolio&amp;#039; link, located at the bottom of the Recent Work section.</item_desc>
              <item_type>page</item_type>
              <item_options></item_options>
              <item_sort>21</item_sort>
            </row>
            <row>
              <id>22</id>
              <item_id>recent_posts</item_id>
              <item_title>Recent Posts</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Enable the Recent Work section on the homepage.</item_options>
              <item_sort>22</item_sort>
            </row>
            <row>
              <id>23</id>
              <item_id>recent_posts_st</item_id>
              <item_title>Recent Posts Settings</item_title>
              <item_desc></item_desc>
              <item_type>radio</item_type>
              <item_options>Three Columns, Four Columns</item_options>
              <item_sort>23</item_sort>
            </row>
            <row>
              <id>122</id>
              <item_id>recent_posts_thumbs</item_id>
              <item_title>Recent Posts Thumbnails</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Enable Recent Posts Thumbnails</item_options>
              <item_sort>24</item_sort>
            </row>
            <row>
              <id>24</id>
              <item_id>blog</item_id>
              <item_title>Blog</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>25</item_sort>
            </row>
            <row>
              <id>25</id>
              <item_id>blog_template</item_id>
              <item_title>Blog Template</item_title>
              <item_desc></item_desc>
              <item_type>select</item_type>
              <item_options>Right Sidebar 1, Right Sidebar 2, Right Sidebar 3, Left Sidebar 1, Left Sidebar 2, Left Sidebar 3</item_options>
              <item_sort>26</item_sort>
            </row>
            <row>
              <id>26</id>
              <item_id>blog_posts_nr</item_id>
              <item_title>Posts Per Page</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>27</item_sort>
            </row>
            <row>
              <id>27</id>
              <item_id>blog_comments_nr</item_id>
              <item_title>Comments Per Page</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>28</item_sort>
            </row>
            <row>
              <id>28</id>
              <item_id>portfolio</item_id>
              <item_title>Portfolio</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>29</item_sort>
            </row>
            <row>
              <id>29</id>
              <item_id>filter_disabled</item_id>
              <item_title>Filterable Portfolio</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Disable the filterable portfolio effect.</item_options>
              <item_sort>30</item_sort>
            </row>
            <row>
              <id>30</id>
              <item_id>portfolio_post_template</item_id>
              <item_title>Portfolio Post Template</item_title>
              <item_desc></item_desc>
              <item_type>select</item_type>
              <item_options>Right Sidebar,Left Sidebar</item_options>
              <item_sort>31</item_sort>
            </row>
            <row>
              <id>31</id>
              <item_id>all_projects</item_id>
              <item_title>&amp;#039;All Projects&amp;#039; Title</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>32</item_sort>
            </row>
            <row>
              <id>32</id>
              <item_id>footer</item_id>
              <item_title>Footer</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>33</item_sort>
            </row>
            <row>
              <id>33</id>
              <item_id>footer_disabled</item_id>
              <item_title>Disable Footer Widget Area</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Check to disable the footer widget area.</item_options>
              <item_sort>34</item_sort>
            </row>
            <row>
              <id>34</id>
              <item_id>footer_cols</item_id>
              <item_title>Footer Widget Area Columns</item_title>
              <item_desc></item_desc>
              <item_type>radio</item_type>
              <item_options>Three columns,Four columns,Five columns</item_options>
              <item_sort>35</item_sort>
            </row>
            <row>
              <id>35</id>
              <item_id>footer_style</item_id>
              <item_title>Footer Style</item_title>
              <item_desc></item_desc>
              <item_type>radio</item_type>
              <item_options>Footer 1, Footer 2</item_options>
              <item_sort>36</item_sort>
            </row>
            <row>
              <id>36</id>
              <item_id>copyright</item_id>
              <item_title>Copyright Text</item_title>
              <item_desc>The copyright text that appears on the very bottom of your website.</item_desc>
              <item_type>textarea</item_type>
              <item_options>3</item_options>
              <item_sort>37</item_sort>
            </row>
            <row>
              <id>37</id>
              <item_id>social_profiles</item_id>
              <item_title>Social Links</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>38</item_sort>
            </row>
            <row>
              <id>38</id>
              <item_id>social_disabled</item_id>
              <item_title>Disable Social Icons</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Check this to disable social icons in the footer.</item_options>
              <item_sort>39</item_sort>
            </row>
            <row>
              <id>39</id>
              <item_id>social_1</item_id>
              <item_title>Twitter</item_title>
              <item_desc>Address to your Twitter profile.</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>40</item_sort>
            </row>
            <row>
              <id>40</id>
              <item_id>social_2</item_id>
              <item_title>Facebook</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>41</item_sort>
            </row>
            <row>
              <id>41</id>
              <item_id>social_17</item_id>
              <item_title>Google+</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>42</item_sort>
            </row>
            <row>
              <id>42</id>
              <item_id>social_3</item_id>
              <item_title>Dribbble</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>43</item_sort>
            </row>
            <row>
              <id>43</id>
              <item_id>social_4</item_id>
              <item_title>RSS</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>44</item_sort>
            </row>
            <row>
              <id>44</id>
              <item_id>social_5</item_id>
              <item_title>YouTube</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>45</item_sort>
            </row>
            <row>
              <id>45</id>
              <item_id>social_6</item_id>
              <item_title>Vimeo</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>46</item_sort>
            </row>
            <row>
              <id>124</id>
              <item_id>social_19</item_id>
              <item_title>LinkedIn</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>47</item_sort>
            </row>
            <row>
              <id>123</id>
              <item_id>social_18</item_id>
              <item_title>Pinterest</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>48</item_sort>
            </row>
            <row>
              <id>46</id>
              <item_id>social_7</item_id>
              <item_title>Tumblr</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>49</item_sort>
            </row>
            <row>
              <id>47</id>
              <item_id>social_8</item_id>
              <item_title>Digg</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>50</item_sort>
            </row>
            <row>
              <id>48</id>
              <item_id>social_9</item_id>
              <item_title>Dropbox</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>51</item_sort>
            </row>
            <row>
              <id>49</id>
              <item_id>social_10</item_id>
              <item_title>Delicious</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>52</item_sort>
            </row>
            <row>
              <id>50</id>
              <item_id>social_11</item_id>
              <item_title>Myspace</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>53</item_sort>
            </row>
            <row>
              <id>51</id>
              <item_id>social_12</item_id>
              <item_title>Skype</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>54</item_sort>
            </row>
            <row>
              <id>52</id>
              <item_id>social_13</item_id>
              <item_title>Plixi</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>55</item_sort>
            </row>
            <row>
              <id>53</id>
              <item_id>social_14</item_id>
              <item_title>StubleUpon</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>56</item_sort>
            </row>
            <row>
              <id>54</id>
              <item_id>social_15</item_id>
              <item_title>Last.fm</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>57</item_sort>
            </row>
            <row>
              <id>55</id>
              <item_id>social_16</item_id>
              <item_title>Mobypicture</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>58</item_sort>
            </row>
            <row>
              <id>56</id>
              <item_id>slider</item_id>
              <item_title>Slider</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>59</item_sort>
            </row>
            <row>
              <id>57</id>
              <item_id>slider_slider</item_id>
              <item_title>Slider Images</item_title>
              <item_desc></item_desc>
              <item_type>slider</item_type>
              <item_options></item_options>
              <item_sort>60</item_sort>
            </row>
            <row>
              <id>58</id>
              <item_id>slider_height</item_id>
              <item_title>Slider Height</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>61</item_sort>
            </row>
            <row>
              <id>59</id>
              <item_id>slider_pause</item_id>
              <item_title>Pause Time</item_title>
              <item_desc>0 to disable autoplay.</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>62</item_sort>
            </row>
            <row>
              <id>60</id>
              <item_id>slider_speed</item_id>
              <item_title>Animation Speed</item_title>
              <item_desc>Slider animation speed.</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>63</item_sort>
            </row>
            <row>
              <id>61</id>
              <item_id>slider_effect</item_id>
              <item_title>Animation Effect</item_title>
              <item_desc>Slider animation effect.</item_desc>
              <item_type>select</item_type>
              <item_options>fade,slide</item_options>
              <item_sort>64</item_sort>
            </row>
            <row>
              <id>62</id>
              <item_id>slider_direction_nav</item_id>
              <item_title>Direction Nav</item_title>
              <item_desc></item_desc>
              <item_type>radio</item_type>
              <item_options>false,true</item_options>
              <item_sort>65</item_sort>
            </row>
            <row>
              <id>63</id>
              <item_id>contact</item_id>
              <item_title>Contact</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>66</item_sort>
            </row>
            <row>
              <id>64</id>
              <item_id>pr_contact_email</item_id>
              <item_title>E-Mail Address</item_title>
              <item_desc>Your contact E-mail address.</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>67</item_sort>
            </row>
            <row>
              <id>65</id>
              <item_id>pr_form_success</item_id>
              <item_title>Form Success Text</item_title>
              <item_desc>A text that appears after the contact form is succesfully submitted (HTML allowed).</item_desc>
              <item_type>textarea</item_type>
              <item_options>2</item_options>
              <item_sort>68</item_sort>
            </row>
            <row>
              <id>66</id>
              <item_id>tr_submit_contact</item_id>
              <item_title>Contact Form Submit Value</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>69</item_sort>
            </row>
            <row>
              <id>67</id>
              <item_id>font</item_id>
              <item_title>Typography</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>70</item_sort>
            </row>
            <row>
              <id>68</id>
              <item_id>font_size</item_id>
              <item_title>Typography</item_title>
              <item_desc></item_desc>
              <item_type>textblock</item_type>
              <item_options></item_options>
              <item_sort>71</item_sort>
            </row>
            <row>
              <id>120</id>
              <item_id>font_body</item_id>
              <item_title>Body Font</item_title>
              <item_desc>Choose the website body font. &amp;lt;br&amp;gt;Default: Helvetica</item_desc>
              <item_type>select</item_type>
              <item_options>Arvo,Dancing Script,Droid Sans,Droid Serif,Hammersmith One,Helvetica/Arial,Helvetica Neue,Josefin Slab,Kaffeesatz,Lato,Open Sans,Open Sans Condensed,Oswald,PT Sans,Raleway,Times New Roman,Ubuntu,Vollkorn,Yanone</item_options>
              <item_sort>72</item_sort>
            </row>
            <row>
              <id>121</id>
              <item_id>font_heading</item_id>
              <item_title>Heading Font</item_title>
              <item_desc>Choose a font for Headings, Navigation and Page Titles.&amp;lt;br&amp;gt;
          Default: League Gothic</item_desc>
              <item_type>select</item_type>
              <item_options>Arvo,Dancing Script,Droid Sans,Droid Serif,Hammersmith One,Helvetica/Arial,Helvetica Neue,Josefin Slab,Kaffeesatz,Lato,League Gothic,Open Sans,Open Sans Condensed,Oswald,PT Sans,Raleway,Times New Roman,Ubuntu,Vollkorn,Yanone</item_options>
              <item_sort>73</item_sort>
            </row>
            <row>
              <id>69</id>
              <item_id>fs_body</item_id>
              <item_title>Body Font Size</item_title>
              <item_desc>Body (paragraphs) font size given in pixels. Default: 12</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>74</item_sort>
            </row>
            <row>
              <id>70</id>
              <item_id>fs_nav</item_id>
              <item_title>Navigation Bar</item_title>
              <item_desc>Default: 22</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>75</item_sort>
            </row>
            <row>
              <id>71</id>
              <item_id>fs_ht</item_id>
              <item_title>Homepage Tagline</item_title>
              <item_desc>Default: 32</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>76</item_sort>
            </row>
            <row>
              <id>72</id>
              <item_id>fs_h1</item_id>
              <item_title>Heading H1</item_title>
              <item_desc>Default: 30</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>77</item_sort>
            </row>
            <row>
              <id>73</id>
              <item_id>fs_h2</item_id>
              <item_title>Heading H2</item_title>
              <item_desc>Default: 28</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>78</item_sort>
            </row>
            <row>
              <id>74</id>
              <item_id>fs_h3</item_id>
              <item_title>Heading H3</item_title>
              <item_desc>Default: 26</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>79</item_sort>
            </row>
            <row>
              <id>75</id>
              <item_id>fs_h4</item_id>
              <item_title>Heading H4</item_title>
              <item_desc>Default: 22</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>80</item_sort>
            </row>
            <row>
              <id>76</id>
              <item_id>fs_h5</item_id>
              <item_title>Heading H5</item_title>
              <item_desc>Default: 11</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>81</item_sort>
            </row>
            <row>
              <id>77</id>
              <item_id>fs_h6</item_id>
              <item_title>Heading H6</item_title>
              <item_desc>Default: 10</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>82</item_sort>
            </row>
            <row>
              <id>78</id>
              <item_id>translate</item_id>
              <item_title>Translate</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>83</item_sort>
            </row>
            <row>
              <id>79</id>
              <item_id>test</item_id>
              <item_title>Homepage Translate</item_title>
              <item_desc></item_desc>
              <item_type>textblock</item_type>
              <item_options></item_options>
              <item_sort>84</item_sort>
            </row>
            <row>
              <id>80</id>
              <item_id>tr_recent_work_title</item_id>
              <item_title>Recent Work Title</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>85</item_sort>
            </row>
            <row>
              <id>81</id>
              <item_id>tr_recent_work_view</item_id>
              <item_title>Recent Work - Link Title</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>86</item_sort>
            </row>
            <row>
              <id>82</id>
              <item_id>tr_recent_posts_title</item_id>
              <item_title>Recent Posts Title</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>87</item_sort>
            </row>
            <row>
              <id>83</id>
              <item_id>tr_recent_posts_view</item_id>
              <item_title>Recent Posts - Link Title</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>88</item_sort>
            </row>
            <row>
              <id>84</id>
              <item_id>blog_translate</item_id>
              <item_title>Blog Translate</item_title>
              <item_desc></item_desc>
              <item_type>textblock</item_type>
              <item_options></item_options>
              <item_sort>89</item_sort>
            </row>
            <row>
              <id>85</id>
              <item_id>tr_read_more</item_id>
              <item_title>Read More</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>90</item_sort>
            </row>
            <row>
              <id>86</id>
              <item_id>tr_by</item_id>
              <item_title>By</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>91</item_sort>
            </row>
            <row>
              <id>87</id>
              <item_id>tr_in</item_id>
              <item_title>In</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>92</item_sort>
            </row>
            <row>
              <id>88</id>
              <item_id>tr_tags</item_id>
              <item_title>Tags</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>93</item_sort>
            </row>
            <row>
              <id>89</id>
              <item_id>tr_posted_by</item_id>
              <item_title>Posted By</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>94</item_sort>
            </row>
            <row>
              <id>90</id>
              <item_id>tr_posted_in</item_id>
              <item_title>Posted In</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>95</item_sort>
            </row>
            <row>
              <id>91</id>
              <item_id>tr_on</item_id>
              <item_title>On</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>96</item_sort>
            </row>
            <row>
              <id>92</id>
              <item_id>tr_leave_reply</item_id>
              <item_title>Leave Reply</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>97</item_sort>
            </row>
            <row>
              <id>93</id>
              <item_id>tr_cancel_reply</item_id>
              <item_title>Cancel Reply</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>98</item_sort>
            </row>
            <row>
              <id>94</id>
              <item_id>tr_reply</item_id>
              <item_title>Reply</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>99</item_sort>
            </row>
            <row>
              <id>95</id>
              <item_id>tr_comments</item_id>
              <item_title>Comments</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>100</item_sort>
            </row>
            <row>
              <id>96</id>
              <item_id>tr_newer_comments</item_id>
              <item_title>Newer Comments</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>101</item_sort>
            </row>
            <row>
              <id>97</id>
              <item_id>tr_older_comments</item_id>
              <item_title>Older Comments</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>102</item_sort>
            </row>
            <row>
              <id>98</id>
              <item_id>tr_older_posts</item_id>
              <item_title>Older Posts</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>103</item_sort>
            </row>
            <row>
              <id>99</id>
              <item_id>tr_newer_posts</item_id>
              <item_title>Newer Posts</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>104</item_sort>
            </row>
            <row>
              <id>100</id>
              <item_id>forms_translate</item_id>
              <item_title>Forms Translate</item_title>
              <item_desc></item_desc>
              <item_type>textblock</item_type>
              <item_options></item_options>
              <item_sort>105</item_sort>
            </row>
            <row>
              <id>101</id>
              <item_id>tr_name</item_id>
              <item_title>Form &amp;#039;Name&amp;#039;</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>106</item_sort>
            </row>
            <row>
              <id>102</id>
              <item_id>tr_email</item_id>
              <item_title>Form &amp;#039;Email&amp;#039;</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>107</item_sort>
            </row>
            <row>
              <id>103</id>
              <item_id>tr_comment_website</item_id>
              <item_title>Form &amp;#039;Website&amp;#039;</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>108</item_sort>
            </row>
            <row>
              <id>104</id>
              <item_id>tr_contact_subject</item_id>
              <item_title>Form &amp;#039;Subject&amp;#039;</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>109</item_sort>
            </row>
            <row>
              <id>105</id>
              <item_id>tr_comment_msg</item_id>
              <item_title>Comment Form Content</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>110</item_sort>
            </row>
            <row>
              <id>106</id>
              <item_id>tr_comment_submit</item_id>
              <item_title>Submit Comment Form</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>111</item_sort>
            </row>
            <row>
              <id>107</id>
              <item_id>tr_contact_msg</item_id>
              <item_title>Contact Form Content</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>112</item_sort>
            </row>
            <row>
              <id>108</id>
              <item_id>others_translate</item_id>
              <item_title>Others Translate</item_title>
              <item_desc></item_desc>
              <item_type>textblock</item_type>
              <item_options></item_options>
              <item_sort>113</item_sort>
            </row>
            <row>
              <id>109</id>
              <item_id>tr_divider_top</item_id>
              <item_title>Divider &amp;#039;Top&amp;#039;</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>114</item_sort>
            </row>
            <row>
              <id>110</id>
              <item_id>tr_search</item_id>
              <item_title>Search</item_title>
              <item_desc></item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>115</item_sort>
            </row>
            <row>
              <id>111</id>
              <item_id>404_page_template</item_id>
              <item_title>404 Page Template</item_title>
              <item_desc></item_desc>
              <item_type>textblock</item_type>
              <item_options></item_options>
              <item_sort>116</item_sort>
            </row>
            <row>
              <id>112</id>
              <item_id>404_title</item_id>
              <item_title>Page Title</item_title>
              <item_desc>404 page title.</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>117</item_sort>
            </row>
            <row>
              <id>113</id>
              <item_id>404_tagline</item_id>
              <item_title>Page Tagline</item_title>
              <item_desc>Optional 404 page tagline.</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>118</item_sort>
            </row>
            <row>
              <id>114</id>
              <item_id>404_msg</item_id>
              <item_title>Error Message</item_title>
              <item_desc>Error message displayed in the content area - full HTML support.</item_desc>
              <item_type>textarea</item_type>
              <item_options>4</item_options>
              <item_sort>119</item_sort>
            </row>
            <row>
              <id>115</id>
              <item_id>responsive</item_id>
              <item_title>Responsive &amp;amp; Retina</item_title>
              <item_desc></item_desc>
              <item_type>heading</item_type>
              <item_options></item_options>
              <item_sort>120</item_sort>
            </row>
            <row>
              <id>116</id>
              <item_id>theme_responsive</item_id>
              <item_title>Theme Responsiveness</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Disable theme responsiveness</item_options>
              <item_sort>121</item_sort>
            </row>
            <row>
              <id>117</id>
              <item_id>theme_retina</item_id>
              <item_title>Retina Icons</item_title>
              <item_desc></item_desc>
              <item_type>checkbox</item_type>
              <item_options>Disable retina icons</item_options>
              <item_sort>122</item_sort>
            </row>
            <row>
              <id>118</id>
              <item_id>retina_logo</item_id>
              <item_title>Retina Logo</item_title>
              <item_desc>Upload your website logo in higher quality for retina devices</item_desc>
              <item_type>upload</item_type>
              <item_options></item_options>
              <item_sort>123</item_sort>
            </row>
            <row>
              <id>119</id>
              <item_id>retina_logo_width</item_id>
              <item_title>Retina Logo Width</item_title>
              <item_desc>Insert the width value for your retina logo. Basic value: 200</item_desc>
              <item_type>input</item_type>
              <item_options></item_options>
              <item_sort>124</item_sort>
            </row>
          </wp_option_tree>
          ';
          $new_options = new SimpleXMLElement( $rawdata );

          // drop table
          $wpdb->query( "DROP TABLE $this->table_name" );

          // create table
            $wpdb->query( $this->option_tree_table( 'create' ) );

            // insert data
          foreach ( $new_options->row as $value ) 
          {
            $wpdb->insert( $this->table_name, 
              array( 
                'item_id' => $value->item_id,
                'item_title' => $value->item_title,
                'item_desc' => $value->item_desc,
                'item_type' => $value->item_type,
                'item_options' => $value->item_options
              )
            );
          }
          // success redirect
          header("Location: admin.php?page=option_tree&xml=true");
          die();
      }
    }
  }

  /**
   * Import Option Data via AJAX
   *
   * @uses check_ajax_referer()
   * @uses update()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function option_tree_import_data() 
  {
    global $wpdb;

    // check AJAX referer
    check_ajax_referer( '_import_data', '_ajax_nonce' );
	
	$ot_data_file = get_bloginfo('template_url') . "/admin/settings/theme-options.txt";   
	
	$rawdata = 'YToxMTE6e3M6MTU6ImdlbmVyYWxfZGVmYXVsdCI7czo3OiJHZW5lcmFsIjtzOjEwOiJsb2dvX2ltYWdlIjtzOjcwOiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1L2xvZ28ucG5nIjtzOjEwOiJuYXZfbWFyZ2luIjtzOjA6IiI7czoxNDoiY3VzdG9tX2Zhdmljb24iO3M6NzM6Imh0dHA6Ly90aGV0YXVyaXMuY29tL3RoZW1lcy9wdXJpdHkvd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDUvZmF2aWNvbi5wbmciO3M6MTU6Imdsb2JhbF90ZW1wbGF0ZSI7czoxMzoiUmlnaHQgU2lkZWJhciI7czoxMToicHJfdHJhY2tpbmciO3M6MDoiIjtzOjEwOiJhcHBlYXJhbmNlIjtzOjEwOiJBcHBlYXJhbmNlIjtzOjEwOiJ0aGVtZV9za2luIjtzOjU6IkxpZ2h0IjtzOjExOiJ0aGVtZV9jb2xvciI7czo3OiIjZTk3MDE3IjtzOjExOiJob3Zlcl9jb2xvciI7czo0OiIjNDQ0IjtzOjg6ImJnX2NvbG9yIjtzOjA6IiI7czo2OiJiZ19pbWciO3M6MDoiIjtzOjg6ImhvbWVwYWdlIjtzOjg6IkhvbWVwYWdlIjtzOjEzOiJzbGlkZXJfZW5hYmxlIjthOjE6e2k6MDtzOjI3OiJFbmFibGUgdGhlIEhvbWVwYWdlIFNsaWRlci4iO31zOjExOiJob21lcGFnZV9jYyI7czowOiIiO3M6MjM6ImhvbWVwYWdlX3RhZ2xpbmVfZW5hYmxlIjthOjE6e2k6MDtzOjI4OiJFbmFibGUgdGhlIGhvbWVwYWdlIHRhZ2xpbmUuIjt9czoxNjoiaG9tZXBhZ2VfdGFnbGluZSI7czoyMDM6IkhlbGxvIGFuZCBXZWxjb21lIHRvIFB1cml0eSwgYSBOWUMgYmFzZWQgcGhvdG9ncmFwaHkgYWdlbmN5LiA8YnI+IEZlZWwgZnJlZSB0byByZWFkIG1vcmUgPGEgaHJlZj1cIiNcIj5BYm91dCB1czwvYT4gYW5kIGNoZWNrIG91ciA8YSBocmVmPVwiI1wiPlBvcnRmb2xpbzwvYT4uIFF1ZXN0aW9ucz8gPGEgaHJlZj1cIiNcIj5TZW5kIHVzIGEgbWFpbDwvYT4uIjtzOjExOiJyZWNlbnRfd29yayI7YToxOntpOjA7czo0NzoiRW5hYmxlIHRoZSBSZWNlbnQgV29yayBzZWN0aW9uIG9uIHRoZSBob21lcGFnZS4iO31zOjE0OiJyZWNlbnRfd29ya19zdCI7czoxMjoiRm91ciBDb2x1bW5zIjtzOjE0OiJwb3J0Zm9saW9fcGFnZSI7czowOiIiO3M6MTI6InJlY2VudF9wb3N0cyI7YToxOntpOjA7czo0NzoiRW5hYmxlIHRoZSBSZWNlbnQgV29yayBzZWN0aW9uIG9uIHRoZSBob21lcGFnZS4iO31zOjE1OiJyZWNlbnRfcG9zdHNfc3QiO3M6MTI6IkZvdXIgQ29sdW1ucyI7czo0OiJibG9nIjtzOjQ6IkJsb2ciO3M6MTM6ImJsb2dfdGVtcGxhdGUiO3M6MTU6IlJpZ2h0IFNpZGViYXIgMSI7czoxMzoiYmxvZ19wb3N0c19uciI7czoyOiIxMCI7czoxNjoiYmxvZ19jb21tZW50c19uciI7czoyOiIyMCI7czo5OiJwb3J0Zm9saW8iO3M6OToiUG9ydGZvbGlvIjtzOjIzOiJwb3J0Zm9saW9fcG9zdF90ZW1wbGF0ZSI7czoxMjoiTGVmdCBTaWRlYmFyIjtzOjEyOiJhbGxfcHJvamVjdHMiO3M6ODoiU2hvdyBBbGwiO3M6NjoiZm9vdGVyIjtzOjY6IkZvb3RlciI7czoxMToiZm9vdGVyX2NvbHMiO3M6MTI6IkZvdXIgY29sdW1ucyI7czoxMjoiZm9vdGVyX3N0eWxlIjtzOjg6IkZvb3RlciAxIjtzOjk6ImNvcHlyaWdodCI7czo1NToiwqkgMjAxMSA8YSBocmVmPVwiI1wiPlB1cml0eTwvYT4gLSBBbGwgcmlnaHRzIHJlc2VydmVkLiI7czoxNToic29jaWFsX3Byb2ZpbGVzIjtzOjEyOiJTb2NpYWwgTGlua3MiO3M6ODoic29jaWFsXzEiO3M6MToiIyI7czo4OiJzb2NpYWxfMiI7czoxOiIjIjtzOjk6InNvY2lhbF8xNyI7czowOiIiO3M6ODoic29jaWFsXzMiO3M6MToiIyI7czo4OiJzb2NpYWxfNCI7czoxOiIjIjtzOjg6InNvY2lhbF81IjtzOjE6IiMiO3M6ODoic29jaWFsXzYiO3M6MDoiIjtzOjk6InNvY2lhbF8xOSI7czowOiIiO3M6OToic29jaWFsXzE4IjtzOjA6IiI7czo4OiJzb2NpYWxfNyI7czowOiIiO3M6ODoic29jaWFsXzgiO3M6MDoiIjtzOjg6InNvY2lhbF85IjtzOjA6IiI7czo5OiJzb2NpYWxfMTAiO3M6MDoiIjtzOjk6InNvY2lhbF8xMSI7czoxOiIjIjtzOjk6InNvY2lhbF8xMiI7czowOiIiO3M6OToic29jaWFsXzEzIjtzOjA6IiI7czo5OiJzb2NpYWxfMTQiO3M6MDoiIjtzOjk6InNvY2lhbF8xNSI7czowOiIiO3M6OToic29jaWFsXzE2IjtzOjA6IiI7czo2OiJzbGlkZXIiO3M6NjoiU2xpZGVyIjtzOjEzOiJzbGlkZXJfc2xpZGVyIjthOjQ6e2k6MDthOjU6e3M6NToib3JkZXIiO3M6MToiMCI7czo1OiJ0aXRsZSI7czo3OiJTbGlkZSAxIjtzOjU6ImltYWdlIjtzOjY4OiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1LzV3LmpwZyI7czo0OiJsaW5rIjtzOjE6IiMiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjA6IiI7fWk6MTthOjU6e3M6NToib3JkZXIiO3M6MToiMSI7czo1OiJ0aXRsZSI7czo3OiJTbGlkZSAyIjtzOjU6ImltYWdlIjtzOjY5OiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1Lzd3MS5qcGciO3M6NDoibGluayI7czoxOiIjIjtzOjExOiJkZXNjcmlwdGlvbiI7czoyNjoiVGhpcyBpcyBhbiBleGFtcGxlIGNhcHRpb24iO31pOjI7YTo1OntzOjU6Im9yZGVyIjtzOjE6IjIiO3M6NToidGl0bGUiO3M6MDoiIjtzOjU6ImltYWdlIjtzOjY4OiJodHRwOi8vdGhldGF1cmlzLmNvbS90aGVtZXMvcHVyaXR5L3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDEyLzA1Lzh3LmpwZyI7czo0OiJsaW5rIjtzOjE6IiMiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjA6IiI7fWk6MzthOjU6e3M6NToib3JkZXIiO3M6MToiMyI7czo1OiJ0aXRsZSI7czowOiIiO3M6NToiaW1hZ2UiO3M6Njk6Imh0dHA6Ly90aGV0YXVyaXMuY29tL3RoZW1lcy9wdXJpdHkvd3AtY29udGVudC91cGxvYWRzLzIwMTIvMDUvNncxLmpwZyI7czo0OiJsaW5rIjtzOjE6IiMiO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjA6IiI7fX1zOjEzOiJzbGlkZXJfaGVpZ2h0IjtzOjM6IjM4MCI7czoxMjoic2xpZGVyX3BhdXNlIjtzOjQ6IjMwMDAiO3M6MTI6InNsaWRlcl9zcGVlZCI7czozOiI3MDAiO3M6MTM6InNsaWRlcl9lZmZlY3QiO3M6NDoiZmFkZSI7czoyMDoic2xpZGVyX2RpcmVjdGlvbl9uYXYiO3M6NToiZmFsc2UiO3M6NzoiY29udGFjdCI7czo3OiJDb250YWN0IjtzOjE2OiJwcl9jb250YWN0X2VtYWlsIjtzOjE3OiJwcmFmZ29uQGdtYWlsLmNvbSI7czoxNToicHJfZm9ybV9zdWNjZXNzIjtzOjQ3OiI8aDI+VGhhbmsgeW91LCB5b3VyIG1lc3NhZ2UgaGFzIGJlZW4gc2VudC48L2gyPiI7czoxNzoidHJfc3VibWl0X2NvbnRhY3QiO3M6NDoiU2VuZCI7czo0OiJmb250IjtzOjEwOiJUeXBvZ3JhcGh5IjtzOjk6ImZvbnRfYm9keSI7czo5OiJPcGVuIFNhbnMiO3M6MTI6ImZvbnRfaGVhZGluZyI7czo5OiJPcGVuIFNhbnMiO3M6NzoiZnNfYm9keSI7czowOiIiO3M6NjoiZnNfbmF2IjtzOjA6IiI7czo1OiJmc19odCI7czowOiIiO3M6NToiZnNfaDEiO3M6MDoiIjtzOjU6ImZzX2gyIjtzOjA6IiI7czo1OiJmc19oMyI7czowOiIiO3M6NToiZnNfaDQiO3M6MDoiIjtzOjU6ImZzX2g1IjtzOjA6IiI7czo1OiJmc19oNiI7czowOiIiO3M6OToidHJhbnNsYXRlIjtzOjk6IlRyYW5zbGF0ZSI7czoyMDoidHJfcmVjZW50X3dvcmtfdGl0bGUiO3M6MTE6IlJlY2VudCBXb3JrIjtzOjE5OiJ0cl9yZWNlbnRfd29ya192aWV3IjtzOjE4OiJWaWV3IFBvcnRmb2xpbyDihpIiO3M6MjE6InRyX3JlY2VudF9wb3N0c190aXRsZSI7czoxMzoiRnJvbSB0aGUgQmxvZyI7czoyMDoidHJfcmVjZW50X3Bvc3RzX3ZpZXciO3M6MTg6IkdvIHRvIHRoZSBCbG9nIOKGkiI7czoxMjoidHJfcmVhZF9tb3JlIjtzOjk6IlJlYWQgbW9yZSI7czo1OiJ0cl9ieSI7czoyOiJCeSI7czo1OiJ0cl9pbiI7czoyOiJJbiI7czo3OiJ0cl90YWdzIjtzOjQ6IlRhZ3MiO3M6MTI6InRyX3Bvc3RlZF9ieSI7czo5OiJQb3N0ZWQgYnkiO3M6MTI6InRyX3Bvc3RlZF9pbiI7czoyOiJpbiI7czo1OiJ0cl9vbiI7czoyOiJvbiI7czoxNDoidHJfbGVhdmVfcmVwbHkiO3M6MTE6IkxlYXZlIFJlcGx5IjtzOjE1OiJ0cl9jYW5jZWxfcmVwbHkiO3M6MTI6IkNhbmNlbCBSZXBseSI7czo4OiJ0cl9yZXBseSI7czo1OiJSZXBseSI7czoxMToidHJfY29tbWVudHMiO3M6ODoiY29tbWVudHMiO3M6MTc6InRyX25ld2VyX2NvbW1lbnRzIjtzOjE0OiJOZXdlciBDb21tZW50cyI7czoxNzoidHJfb2xkZXJfY29tbWVudHMiO3M6MTQ6Ik9sZGVyIENvbW1lbnRzIjtzOjE0OiJ0cl9vbGRlcl9wb3N0cyI7czoxMToiT2xkZXIgUG9zdHMiO3M6MTQ6InRyX25ld2VyX3Bvc3RzIjtzOjExOiJOZXdlciBQb3N0cyI7czo3OiJ0cl9uYW1lIjtzOjQ6Ik5hbWUiO3M6ODoidHJfZW1haWwiO3M6NjoiRS1NYWlsIjtzOjE4OiJ0cl9jb21tZW50X3dlYnNpdGUiO3M6NzoiV2Vic2l0ZSI7czoxODoidHJfY29udGFjdF9zdWJqZWN0IjtzOjc6IlN1YmplY3QiO3M6MTQ6InRyX2NvbW1lbnRfbXNnIjtzOjc6IkNvbW1lbnQiO3M6MTc6InRyX2NvbW1lbnRfc3VibWl0IjtzOjExOiJMZWF2ZSBSZXBseSI7czoxNDoidHJfY29udGFjdF9tc2ciO3M6NzoiTWVzc2FnZSI7czoxNDoidHJfZGl2aWRlcl90b3AiO3M6MzoiVG9wIjtzOjk6InRyX3NlYXJjaCI7czo4OiJTZWFyY2guLiI7czo5OiI0MDRfdGl0bGUiO3M6MTQ6IjQwNCBQYWdlIEVycm9yIjtzOjExOiI0MDRfdGFnbGluZSI7czoxMzoiTm90aGluZyBGb3VuZCI7czo3OiI0MDRfbXNnIjtzOjcxOiI8aDI+UGFnZSBOb3QgRm91bmQ8L2gyPg0KDQo8cD5QYWdlIHlvdSBhcmUgbG9va2luZyBmb3IgaXNuXCd0IGhlcmUuPC9wPiI7czoxMDoicmVzcG9uc2l2ZSI7czoxOToiUmVzcG9uc2l2ZSAmIFJldGluYSI7czoxMToicmV0aW5hX2xvZ28iO3M6Nzc6Imh0dHA6Ly90aGV0YXVyaXMuY29tL3RoZW1lcy9wdXJpdHkvd3AtY29udGVudC91cGxvYWRzLzIwMTMvMDQvbG9nb19yZXRpbmEucG5nIjtzOjE3OiJyZXRpbmFfbG9nb193aWR0aCI7czozOiIxMDAiO30=';
    $new_options = unserialize( base64_decode( $rawdata ) );
      
	// check if array()
	if ( is_array( $new_options ) )
	{		
	  // delete old options
      delete_option( 'option_tree' );
	  
	  // create new options
	  add_option('option_tree', $new_options);
	  
	  // redirect

      die();
	}    
    // failed
    die(-1);
  }

  function option_tree_add_slider() 
  {
    $count = $_GET['count'] + 1;
    $id = $_GET['slide_id'];
    $image = array(
      'order'       => $count,
      'title'       => '',
      'image'       => '',
      'link'        => '',
      'description' => ''
    );
    option_tree_slider_view( $id, $image, $this->get_option_page_ID('media'), $count );
    die();
  }

  /**
   * Returns the ID of a cutom post tpye
   *
   * @uses get_results()
   *
   * @access public
   * @since 1.0.0
   *
   * @param string $page_title
   *
   * @return int
   */
  function get_option_page_ID( $page_title = '' ) 
  {
    global $wpdb;

    return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '{$page_title}' AND post_type = 'option-tree' AND post_status != 'trash'");
  }

  /**
   * Register custom post type & create two posts
   *
   * @uses get_results()
   *
   * @access public
   * @since 1.0.0
   *
   * @return void
   */
  function create_option_post() 
  {
    register_post_type( 'option-tree', array(
        'labels' => array(
            'name' => __( 'Options' ),
        ),
        'public' => true,
        'show_ui' => false,
        'capability_type' => 'post',
        'exclude_from_search' => true,
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array( 'title', 'editor' ),
        'can_export' => true,
        'show_in_nav_menus' => false,
    ) );

    // create a private page to attach media to
    if ( isset($_GET['page']) && $_GET['page'] == 'option_tree' ) 
    {  
      // look for custom page
      $page_id = $this->get_option_page_ID( 'media' );

      // no page create it
      if ( ! $page_id ) 
      {
        // create post object
        $_p = array();
        $_p['post_title'] = 'Media';
        $_p['post_status'] = 'private';
        $_p['post_type'] = 'option-tree';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';

        // insert the post into the database
        $page_id = wp_insert_post( $_p );
      }
    }

    // create a private page for settings page
    if ( isset($_GET['page']) && $_GET['page'] == 'option_tree_settings' ) 
    {  
      // look for custom page
      $page_id = $this->get_option_page_ID( 'options' );

      // no page create it
      if ( ! $page_id ) 
      {
        // create post object
        $_p = array();
        $_p['post_title'] = 'Options';
        $_p['post_status'] = 'private';
        $_p['post_type'] = 'option-tree';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';

        // insert the post into the database
        $page_id = wp_insert_post( $_p );
      }
    }
  }

  /**
   * Outputs the notice message to say that someone else is editing this post at the moment.
   *
   * @uses get_userdata()
   * @uses get_post_meta()
   * @uses esc_html()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return string
   */
  function option_tree_notice_post_locked( $post_id ) 
  {
    if ( !$post_id )
          return false;

      $last_user = get_userdata( get_post_meta( $post_id, '_edit_last', true ) );
    $last_user_name = $last_user ? $last_user->display_name : __('Somebody');
    $the_page = ( $_GET['page'] == 'option_tree' ) ? __('Theme Options') : __('Settings');

    $message = sprintf( __( 'Warning: %s is currently editing the %s.' ), esc_html( $last_user_name ), $the_page );
    return '<div class="message warning"><span>&nbsp;</span>'.$message.'</div>';
  }

  /**
   * Check to see if the post is currently being edited by another user.
   *
   * @uses get_post_meta()
   * @uses apply_filters()
   * @uses get_current_user_id()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return bool
   */
  function option_tree_check_post_lock( $post_id ) 
  { 
      if ( !$post_id )
          return false;

      $lock = get_post_meta( $post_id, '_edit_lock', true );
      $last = get_post_meta( $post_id, '_edit_last', true );

      $time_window = apply_filters( 'wp_check_post_lock_window', 30 );

      if ( $lock && $lock > time() - $time_window && $last != get_current_user_id() )
          return $last;

      return false;
  }

  /**
   * Mark the post as currently being edited by the current user
   *
   * @uses update_post_meta()
   * @uses get_current_user_id()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return bool
   */
  function option_tree_set_post_lock( $post_id ) 
  {
      if ( !$post_id )
          return false;

      if ( 0 == get_current_user_id() )
          return false;

      $now = time();

      update_post_meta( $post_id, '_edit_lock', $now );
      update_post_meta( $post_id, '_edit_last', get_current_user_id() );
  }

  /**
   * Remove the post lock
   *
   * @uses delete_post_meta()
   *
   * @access public
   * @since 1.0.0
   *
   * @param int $post_id
   *
   * @return bool
   */
  function option_tree_remove_post_lock( $post_id ) 
  {
      if ( !$post_id )
          return false;

      delete_post_meta( $post_id, '_edit_lock' );
      delete_post_meta( $post_id, '_edit_last' );
  }

}