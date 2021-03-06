<?php
$muhSSL = false;
if(isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on")
{
    $muhSSL = true;
}
else
{
    if(FORCE_SSL)
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo get_setting('fs_gen_site_title'); ?> <?php echo _('Control panel') ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/admin/account.css" rel="stylesheet" type="text/css" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="<?php echo site_url() ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo site_url() ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            function slideDown(item) { jQuery(item).slideDown(); }
            function slideUp(item) { jQuery(item).slideUp(); }
            function slideToggle(item) { jQuery(item).slideToggle(); }
            function confirmPlug(href, text, item)
            {
                if(text != "") var plug = confirm(text);
				else plug = true;
				
                if (plug)
                {
					jQuery(item).addClass('loading');
                    jQuery.post(href, function(result){
						jQuery(item).removeClass('loading');
						if(location.href == result.href) window.location.reload(true);
						location.href = result.href;
					}, 'json');
                }
            }
			
            function addField(e)
            {
				if(jQuery(e).val().length > 0)
				{
					jQuery(e).clone().val('').insertAfter(e);
					jQuery(e).attr('onKeyUp', '');
					jQuery(e).attr('onChange', '');
				}
            }
			
			jQuery(document).ready(function(){
<?php
$CI = & get_instance();
if ($CI->agent->is_browser('MSIE'))
{
	?>

				// Let's make placeholders work on IE and old browsers too
				jQuery('[placeholder]').focus(function() {
					var input = jQuery(this);
					if (input.val() == input.attr('placeholder')) {
						input.val('');
						input.removeClass('placeholder');
					}
				}).blur(function() {
					var input = jQuery(this);
					if (input.val() == '' || input.val() == input.attr('placeholder')) {
						input.addClass('placeholder');
						input.val(input.attr('placeholder'));
					}
				}).blur().parents('form').submit(function() {
					jQuery(this).find('[placeholder]').each(function() {
						var input =jQuery(this);
						if (input.val() == input.attr('placeholder')) {
							input.val('');
						}
					})
				}); <?php } ?>
		});
        </script>

	</head>



	<body style="background: url('<?php echo base_url() ?>assets/images/admin_background.jpg') no-repeat center center fixed" class="noselect">

		<div class="wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nvb" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="<?php echo site_url('admin') ?>">
                      <?php if (isset($this->tank_auth))
					echo get_setting('fs_gen_site_title'); ?> - <?php
                        if ($this->tank_auth->is_logged_in())
                        {
                            echo $this->tank_auth->get_username() . ': ';
                        }
                        echo $function_title
                    ?></a>
                    </div>
                    <div class="collapse navbar-collapse" id="nvb">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?php echo site_url(); ?>">
                                    <i class="fa fa-book"></i>
                                    <?php echo _("Reader") ?></a>
                            </li>
                            <?php if (isset($this->tank_auth) && $this->tank_auth->is_allowed())
                            { ?><li>
                                    <a href="<?php echo site_url('admin'); ?>">
                                        <i class="fa fa-cogs"></i>
                                        <?php echo _("Admin panel") ?></a>
                                </li>
                            <?php } ?>
                            <?php if (isset($this->tank_auth) && $this->tank_auth->is_logged_in())
                            { ?><li>
                                    <a href="<?php echo site_url('/account/auth/logout'); ?>">
                                        <i class="fa fa-sign-out"></i>
                                        <?php echo _("Logout") ?> <?php echo $this->tank_auth->get_username(); ?></a>
                                </li>
				<?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>

			<!--<div id="header"> TODO: REMOVE

				<div class="title"><?php if (isset($this->tank_auth))
					echo get_setting('fs_gen_site_title'); ?></div>

				<div class="subtitle"><?php
					if ($this->tank_auth->is_logged_in())
					{
						echo '<img src="'.get_gravatar($user_email, 16).'" /> ';
						echo $this->tank_auth->get_username() . ': ';
					}
					echo $function_title
				?></div>

				<?php
				if (isset($navbar))
				{
					echo '<div id="navbar">';
					echo $navbar;
					echo '</div>';
				}
				?>
			</div>-->

			<div id="content_wrap">


				<div class="spacer"></div>


				<div id="center">

					<div class="content">
						<div class="errors">
							<?php
                            if(!$muhSSL)
                            {
                                echo '<div class="alert alert-warning"><i class="fa fa-unlock-alt" aria-hidden="true"></i> '._("Potentially insecure connection, data could be intercepted.").'</div>';
                            }
							if (isset($this->notices))
								foreach ($this->notices as $key => $value)
								{
									if ($value["type"] == 'error')
										$color = 'red';
									if ($value["type"] == 'warn')
										$color = 'yellow';
									if ($value["type"] == 'notice')
										$color = 'green';
									if ($value["message"])
										echo '<div class="alert ' . $color . '">' . $value["message"] . '</div>';
								}
							if (isset($this->tank_auth))
							{

								$flashdata = $this->session->flashdata('notices');
								if (!empty($flashdata))
									foreach ($flashdata as $key => $value)
									{
										if ($value["type"] == 'error')
											$color = 'red';
										if ($value["type"] == 'warn')
											$color = 'yellow';
										if ($value["type"] == 'notice')
											$color = 'green';
										if ($value["message"])
											echo '<div class="alert ' . $color . '">' . $value["message"] . '</div>';
									}
							}
							?>
						</div>

<?php echo $main_content_view; ?>

					</div></div>
				<div class="clearer"></div>
			</div>

		</div>

		<div id="footer"><div class="text">Art by <a href="//viperxtr.deviantart.com/">Emert X Repiv (ViperXTR)</a></div></div>
	</body>

</html>