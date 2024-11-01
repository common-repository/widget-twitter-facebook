<?php
/*
Plugin Name: Widget TW FB
Plugin URI: http://www.floe.fr
Description: Widget permettant l ajout de deux liens pour votre FB et TW
Author: LaFouine
Version: 1.02
Author URI: http://www.floe.fr/
*/

function widget_tw_fb()
{
	register_widget("class_widget_tw_fb");
}
add_action("widgets_init", "widget_tw_fb");


class class_widget_tw_fb extends WP_Widget
{
	function class_widget_tw_fb()
	{
		$options = array(
			"classname" 	=> "TW-FB-Widget",
			"description"	=> "Logo Twitter et FB en Widget"
			);
		
		parent::WP_Widget(/* Base ID */'TW-FB-Widget', /* Name */'Twitter Facebook Widget', $options);
	}
	
	function widget($arguments, $data)
	{
		$defaut = array(
			'Titre'		=> "Twitter FB Widget",
			'TW'		=> 'TWACTIF',
			'FB'		=> 'FBACTIF',
			'TWValue'	=> true,
			'FBValue'	=> true,
			'TWU'		=> 'TWURL',
			'FBU'		=> 'FBURL',
			'TWPage'	=> '',
			'FBPage'	=> ''
			);
		$data = wp_parse_args($data, $defaut);
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		
		extract($arguments);
		
		echo $before_widget;
		echo $before_title . $data['Titre'] . $after_title;
		// Javascript pour RollOver
		echo "<script>var bttw1=new Image();";
		echo "bttw1.src='/wp-content/plugins/widget-twitter-facebook/btm_twitter.png';";
		echo "var bttw2=new Image();";
		echo "bttw2.src='/wp-content/plugins/widget-twitter-facebook/btm_twitter_1.png';";
		echo "function m_tw(){";
		echo "	document.images.bt_tw.src=bttw2.src;";
		echo "}";
		echo "function c_tw(){";
		echo "	document.images.bt_tw.src=bttw1.src;";
		echo "}";
		echo "var btfb1=new Image();";
		echo "btfb1.src='/wp-content/plugins/widget-twitter-facebook/btm_facebook.png';";
		echo "var btfb2=new Image();";
		echo "btfb2.src='/wp-content/plugins/widget-twitter-facebook/btm_facebook_1.png';";
		echo "function m_fb(){";
		echo "	document.images.bt_fb.src=btfb2.src;";
		echo "}";
		echo "function c_fb(){";
		echo "	document.images.bt_fb.src=btfb1.src;";
		echo "}</script>";
		
		// Affichage du paragraphe Images
		echo "<p>";
		if($data['TWValue'])
			echo "<a href='" . $data['TWPage'] . "' target=_blank onMouseOut='c_tw()' onMouseOver='m_tw()'><img src='/wp-content/plugins/widget-twitter-facebook/btm_twitter.png' name='bt_tw' /></a>";
		if($data['FBValue'])
			echo "<a href='" . $data['FBPage'] . "' target=_blank onMouseOut='c_fb()' onMouseOver='m_fb()'><img src='/wp-content/plugins/widget-twitter-facebook/btm_facebook.png' name='bt_fb' /></a>";
		// Pour Debug
		// echo $data['TWValue'] . " - " .$data['FBValue'];
		echo "</p>";
		echo $after_widget;
	}
	
	function update($content_new, $content_old)
	{
		if($content_new['TW']=='twchk')
			$content_new['TWValue'] = true;
		else
			$content_new['TWValue'] = false;
			
		if($content_new['FB']=='fbchk')
			$content_new['FBValue'] = true;
		else
			$content_new['FBValue'] = false;
			
		$content_new['TWPage'] = $content_new['TWU'];
		$content_new['TWU'] = $content_old['TWU'];
		$content_new['FBPage'] = $content_new['FBU'];
		$content_new['FBU'] = $content_old['FBU'];
		
		$content_new['TW'] = $content_old['TW'];
		$content_new['FB'] = $content_old['FB'];
		return $content_new;
	}
	
	function form($data)
	{
		$defaut = array(
			'Titre'		=> "Twitter FB Widget",
			'TW'		=> 'TWACTIF',
			'FB'		=> 'FBACTIF',
			'TWValue'	=> true,
			'FBValue'	=> true,
			'TWU'		=> 'TWURL',
			'FBU'		=> 'FBURL',
			'TWPage'	=> '',
			'FBPage'	=> ''
			);
		$data = wp_parse_args($data, $defaut);
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		?>
		<p>
			<label for="<?php echo $this->get_field_id('Titre'); ?>">Titre :</label>
			<input value="<?php echo $data['Titre']; ?>" name="<?php echo $this->get_field_name('Titre'); ?>"  id="<?php echo $this->get_field_id('Titre'); ?>" type=text />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('TW'); ?>">Twitter Actif :</label>
			<input value="twchk" name="<?php echo $this->get_field_name('TW'); ?>" id="<?php echo $this->get_field_id('TW'); ?>" type=checkbox <?php if($data['TWValue']) echo "checked=checked "; ?>/>
			<input value="<?php echo $data['TWPage']; ?>" name="<?php echo $this->get_field_name('TWU'); ?>" id="<?php echo $this->get_field_id('TWU'); ?>" type=text />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('FB'); ?>">Facebook Actif :</label>
			<input value="fbchk" name="<?php echo $this->get_field_name('FB'); ?>" id="<?php echo $this->get_field_id('FB'); ?>" type=checkbox <?php if($data['FBValue']) echo "checked=checked "; ?>/>
			<input value="<?php echo $data['FBPage']; ?>" name="<?php echo $this->get_field_name('FBU'); ?>" id="<?php echo $this->get_field_id('FBU'); ?>" type=text />
		</p>
		<?php
	}
}
?>