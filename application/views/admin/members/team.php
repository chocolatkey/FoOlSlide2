<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>

<div class="table">
	<h3 style="float: left"><?php echo _('Team Information'); ?></h3>
	<span style="float: right; padding: 5px"><?php echo buttoner(); ?></span>
	<hr class="clear"/>
	<?php
		echo form_open("", array('class' => 'form-stacked'));
		echo $table;
		echo form_close();
	?>
</div>

<br/>

<?php
// Check for admin has already been done in controller
if ($no_leader) {
	echo _("Make an user a leader by submitting his username:");
	echo form_open("/admin/members/make_team_leader_username/".$team->id);
	echo '<table class="form"><tr><td>';
	echo form_input(array('name' => 'username', 'placeholder' => 'Username'));
	echo '</td><td>';
	echo form_submit('save', 'Save');
	echo form_close();
	echo '</td></tr></table>';
}
?>
<div class="section"><?php echo _("Members") ?>:</div><br/>
<?php
echo $members;