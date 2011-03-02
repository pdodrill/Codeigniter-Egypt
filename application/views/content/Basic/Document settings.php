<?php if( $mode=='config' ): ?>
background attributes:if you specified a background image all the related attributes would be wrriten as well in the rendered HTML otherwise they will be ignored
background_image :  
	type : file 
repeat :  
	type : dropdown
	options :
		no-repeat:no-repeat
		repeat:repeat
		repeat-x:repeat-x
		repeat-y:repeat-y
	default : 0 
attachment :  
	type : dropdown 
	options : 
		scroll:scroll
		fixed:fixed 
	default: 0 
horizontal_position :  
	type : textbox 
	default : left 
vertical_position :  
	type : textbox 
	default : top 
style sheets: you can include Reset and Text stylesheets from here 
Resetstyle:
	type:checkbox
Textstyle:
	type:checkbox
extra attributs:you can specify extra body classes and style
class:
	type:textbox
style:
	type:textarea
favIcon:
	type:file
javascript_files : 
	type:file list
css_files : 
	type:file list
<?php elseif( $mode=='layout' ): ?>
0
<?php elseif( $mode=='view' ): ?>

<?php 
$ci =& get_instance();
if( $ci->system->mode()=='edit' )
{
	$c = new Content();
	$c->get_by_id( $id );
	
	if( $ci->ion_auth->is_admin() )
	{
		$ci->load->library( 'gui' );
		echo $ci->gui->info( 'Document settings here' );
	}
}

?>

<?php
	$local = base_url();
	
	if( $info->Resetstyle ) theme_add( 'assets/style/reset.css' );
	if( $info->Textstyle ) theme_add( 'assets/style/text.css' );
	if( !empty($info->favIcon) ) theme_add('<link rel="icon" href="'.base_url().$info->favIcon.'">');
	theme_add(explode("\n",$info->javascript_files));
	theme_add(explode("\n",$info->css_files));
	
	$style = '';
	if( $info->background_image != '' )
	{
		$style .= "background-image: url({$local}{$info->background_image});";
		$style .= "background-position: {$info->horizontal_position} {$info->vertical_position};";
		$style .= "background-repeat: {$info->repeat};";
		$style .= "background-attachment: {$info->attachment};";
	}
	$style .= $info->style;
	if( $style!='' )
	{
		theme_add("
<style>
body{
	{$style}
}
</style>

		");
		if(!empty($info->class))
		{ 
			theme_add('jquery/jquery.js');
			theme_add(
<<<EOT
<script language="javascript" >
	$(function(){
		$(document).addClass('{$info->class}');
	});
</script>
EOT
			);
		}
	}
?>
<?php endif; ?>
