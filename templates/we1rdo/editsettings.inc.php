<?php
if (!empty($editsettingsresult)) {
	if ($editsettingsresult['result'] == 'success') {
		$tplHelper->redirect($http_referer);
		return ;
	} # if
} # if

require "includes/header.inc.php";
include "includes/form-messages.inc.php";
$nntp_nzb = $this->_settings->get('nntp_nzb');
$nntp_hdr = $this->_settings->get('nntp_hdr');
$nntp_post = $this->_settings->get('nntp_post');
if (($retrieve_newer_than = $this->_settings->get('retrieve_newer_than')) < 1230789600) {
	$retrieve_newer_than = 1230789600; // 2009-01-01
} # if
?>
</div>
	<div id='toolbar'>
		<div class="closeeditsettings"><p><a class='toggle' href='<?php echo $tplHelper->makeBaseUrl('path');?>'><?php echo _('Back to mainview'); ?></a></p></div>
	</div>
<form class="editsettingsform" name="editsettingsform" action="<?php echo $tplHelper->makeEditSettingsAction(); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="editsettingsform[xsrfid]" value="<?php echo $tplHelper->generateXsrfCookie('editsettingsform'); ?>">
	<input type="hidden" name="editsettingsform[http_referer]" value="<?php echo $http_referer; ?>">
	<input type="hidden" name="editsettingsform[buttonpressed]" value="">
	
	<div id="edituserpreferencetabs" class="ui-tabs">
		<ul>
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_view_spotweb_updates, '')) { ?>
			<li><a href="?page=versioncheck" title="<?php echo _('Spotweb updates'); ?>"><span><?php echo _('Spotweb updates');?></span></a></li>
<?php }
if ($tplHelper->allowed(SpotSecurity::spotsec_edit_settings, '')) { ?>
			<li><a href="#editsettingstab-1"><span><?php echo _('General'); ?></span></a></li>
			<li><a href="#editsettingstab-2"><span><?php echo _('Newsservers'); ?></span></a></li>
			<li><a href="#editsettingstab-3"><span><?php echo _('Retrieve'); ?></span></a></li>
			<li><a href="#editsettingstab-4"><span><?php echo _('Performance'); ?></span></a></li>
<?php } ?>
		</ul>
			
<?php if ($tplHelper->allowed(SpotSecurity::spotsec_edit_settings, '')) { ?>		
		<div id="editsettingstab-1" class="ui-tabs-hide">
			<fieldset>
				<dl>
					<dt><label for="editsettingsform[deny_robots]"><?php echo _('Try to prevent robots from indexing this installation'); ?></label></dt>
					<dd><input type="checkbox" name="editsettingsform[deny_robots]" <?php if ($this->_settings->get('deny_robots')) { echo 'checked="checked"'; } ?>></dd>
				</dl>
			</fieldset>
		</div>

		<div id="editsettingstab-2" class="ui-tabs-hide">
			<fieldset>
				<dl>
					<dt><label for="editsettingsform[nntp_nzb][host]"><?php echo _('Hostname'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_nzb][host]" value="<?php echo $nntp_nzb['host']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_nzb][user]"><?php echo _('Username'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_nzb][user]" value="<?php echo $nntp_nzb['user']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_nzb][pass]"><?php echo _('Password'); ?></label></dt>
					<dd><input type="password" name="editsettingsform[nntp_nzb][pass]" value="<?php echo $nntp_nzb['pass']; ?>"></dd>

					<dt><label for="use_encryption_nzb"><?php echo _('Encryption'); ?></label></dt>
					<dd><input type="checkbox" class="enabler" name="editsettingsform[nntp_nzb][enc][switch]" id="use_encryption_nzb" <?php if ($nntp_nzb['enc']) { echo 'checked="checked"'; } ?>></dd>
					<fieldset id="content_use_encryption_nzb">
						<select name="editsettingsform[nntp_nzb][enc][select]">
							<option <?php if ($nntp_nzb['enc'] == 'ssl') { echo 'selected="selected"'; } ?> value="ssl">SSL</option>
							<option <?php if ($nntp_nzb['enc'] == 'tls') { echo 'selected="selected"'; } ?> value="tls">TLS</option>
						</select>					
					</fieldset>

					<dt><label for="editsettingsform[nntp_nzb][port]"><?php echo _('Port'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_nzb][port]" value="<?php echo $nntp_nzb['port']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_nzb][buggy]"><?php echo _('Buggy (Some newsservers lose messages once in a while)'); ?></label></dt>
					<dd><input type="checkbox" name="editsettingsform[nntp_nzb][buggy]" <?php if ($nntp_nzb['buggy']) { echo 'checked="checked"'; } ?>></dd>
				</dl>
			</fieldset>

			<dt><label for="use_nntp_hdr"><?php echo _('Use different server for headers?'); ?></label></dt>
			<dd><input type="checkbox" class="enabler" name="editsettingsform[nntp_hdr][use]" id="use_nntp_hdr" <?php if (!isset($nntp_hdr['isadummy'])) { echo 'checked="checked"'; } ?>></dd>
			<fieldset id="content_use_nntp_hdr">
				<dl>
					<dt><label for="editsettingsform[nntp_hdr][host]"><?php echo _('Hostname'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_hdr][host]" value="<?php echo $nntp_hdr['host']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_hdr][user]"><?php echo _('Username'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_hdr][user]" value="<?php echo $nntp_hdr['user']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_hdr][pass]"><?php echo _('Password'); ?></label></dt>
					<dd><input type="password" name="editsettingsform[nntp_hdr][pass]" value="<?php echo $nntp_hdr['pass']; ?>"></dd>

					<dt><label for="use_encryption_hdr"><?php echo _('Encryption'); ?></label></dt>
					<dd><input type="checkbox" class="enabler" name="editsettingsform[nntp_hdr][enc][switch]" id="use_encryption_hdr" <?php if ($nntp_hdr['enc']) { echo 'checked="checked"'; } ?>></dd>
					<fieldset id="content_use_encryption_hdr">
						<select name="editsettingsform[nntp_hdr][enc][select]">
							<option <?php if ($nntp_hdr['enc'] == 'ssl') { echo 'selected="selected"'; } ?> value="ssl">SSL</option>
							<option <?php if ($nntp_hdr['enc'] == 'tls') { echo 'selected="selected"'; } ?> value="tls">TLS</option>
						</select>					
					</fieldset>

					<dt><label for="editsettingsform[nntp_hdr][port]"><?php echo _('Port'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_hdr][port]" value="<?php echo $nntp_hdr['port']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_hdr][buggy]"><?php echo _('Buggy (Some newsservers lose messages once in a while)'); ?></label></dt>
					<dd><input type="checkbox" name="editsettingsform[nntp_hdr][buggy]" <?php if ($nntp_hdr['buggy']) { echo 'checked="checked"'; } ?>></dd>
				</dl>
			</fieldset>

			<dt><label for="use_nntp_post"><?php echo _('Use different server for posting?'); ?></label></dt>
			<dd><input type="checkbox" class="enabler" name="editsettingsform[nntp_post][use]" id="use_nntp_post" <?php if (!isset($nntp_post['isadummy'])) { echo 'checked="checked"'; } ?>></dd>
			<fieldset id="content_use_nntp_post">
				<dl>
					<dt><label for="editsettingsform[nntp_post][host]"><?php echo _('Hostname'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_post][host]" value="<?php echo $nntp_post['host']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_post][user]"><?php echo _('Username'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_post][user]" value="<?php echo $nntp_post['user']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_post][pass]"><?php echo _('Password'); ?></label></dt>
					<dd><input type="password" name="editsettingsform[nntp_post][pass]" value="<?php echo $nntp_post['pass']; ?>"></dd>

					<dt><label for="use_encryption_post"><?php echo _('Encryption'); ?></label></dt>
					<dd><input type="checkbox" class="enabler" name="editsettingsform[nntp_post][enc][switch]" id="use_encryption_post" <?php if ($nntp_post['enc']) { echo 'checked="checked"'; } ?>></dd>
					<fieldset id="content_use_encryption_post">
						<select name="editsettingsform[nntp_post][enc][select]">
							<option <?php if ($nntp_post['enc'] == 'ssl') { echo 'selected="selected"'; } ?> value="ssl">SSL</option>
							<option <?php if ($nntp_post['enc'] == 'tls') { echo 'selected="selected"'; } ?> value="tls">TLS</option>
						</select>					
					</fieldset>

					<dt><label for="editsettingsform[nntp_post][port]"><?php echo _('Port'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[nntp_post][port]" value="<?php echo $nntp_post['port']; ?>"></dd>

					<dt><label for="editsettingsform[nntp_post][buggy]"><?php echo _('Buggy (Some newsservers lose messages once in a while)'); ?></label></dt>
					<dd><input type="checkbox" name="editsettingsform[nntp_post][buggy]" <?php if ($nntp_post['buggy']) { echo 'checked="checked"'; } ?>></dd>
				</dl>
			</fieldset>
			</div>

		<div id="editsettingstab-3" class="ui-tabs-hide">
			<fieldset>
				<dl>
					<dt><label for="editsettingsform[retention]"><?php echo _('Retention on spots (in days). Older spots will be erased. Select 0 to keep all spots.'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[retention]" value="<?php echo $this->_settings->get('retention'); ?>"></dd>

					<dt><label for="editsettingsform[retrieve_newer_than]"><?php echo _('Retrieve spots after... Select 0 to fetch all spots'); ?><br /><?php echo _('To skip all FTD spots set this to November 24, 2010'); ?></label></dt>
					<dd><div id="datepicker"></div><input type="hidden" id="retrieve_newer_than" name="editsettingsform[retrieve_newer_than]"></dd>

					<dt><label for="editsettingsform[retrieve_full]"><?php echo _('Retrieve full spots'); ?></label></dt>
					<dd><input type="checkbox" class="enabler" name="editsettingsform[retrieve_full]" id="use_retrieve_full" <?php if ($this->_settings->get('retrieve_full')) { echo 'checked="checked"'; } ?>></dd>
					<fieldset id="content_use_retrieve_full">
						<dt><label for="editsettingsform[prefetch_image]"><?php echo _('Prefetch images'); ?></label></dt>
						<dd><input type="checkbox" name="editsettingsform[prefetch_image]" <?php if ($this->_settings->get('prefetch_image')) { echo 'checked="checked"'; } ?>></dd>

						<dt><label for="editsettingsform[prefetch_nzb]"><?php echo _('Prefetch NZB files'); ?></label></dt>
						<dd><input type="checkbox" name="editsettingsform[prefetch_nzb]" <?php if ($this->_settings->get('prefetch_nzb')) { echo 'checked="checked"'; } ?>></dd>
					</fieldset>

					<dt><label for="editsettingsform[retrieve_comments]"><?php echo _('Retrieve comments'); ?></label></dt>
					<dd><input type="checkbox" class="enabler" name="editsettingsform[retrieve_comments]" id="use_retrieve_comments" <?php if ($this->_settings->get('retrieve_comments')) { echo 'checked="checked"'; } ?>></dd>
					<fieldset id="content_use_retrieve_comments">
						<dt><label for="editsettingsform[retrieve_full_comments]"><?php echo _('Retrieve full comments'); ?></label></dt>
						<dd><input type="checkbox" name="editsettingsform[retrieve_full_comments]" <?php if ($this->_settings->get('retrieve_full_comments')) { echo 'checked="checked"'; } ?>></dd>
					</fieldset>

					<dt><label for="editsettingsform[retrieve_reports]"><?php echo _('Retrieve reports'); ?></label></dt>
					<dd><input type="checkbox" name="editsettingsform[retrieve_reports]" <?php if ($this->_settings->get('retrieve_reports')) { echo 'checked="checked"'; } ?>></dd>
				</dl>
			</fieldset>
		</div>

		<div id="editsettingstab-4" class="ui-tabs-hide">
			<fieldset>
				<dl>
					<dt><label for="editsettingsform[retrieve_increment]"><?php echo _('Retrieve increment'); ?><br /><?php echo _('Lower this if you get timeouts during retrieve'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[retrieve_increment]" value="<?php echo $this->_settings->get('retrieve_increment'); ?>"></dd>

					<dt><label for="editsettingsform[max_newcount]"><?php echo _('Maximum amount of new spots that will show up as new'); ?></label></dt>
					<dd><input type="text" name="editsettingsform[max_newcount]" value="<?php echo $this->_settings->get('max_newcount'); ?>"></dd>

					<dt><label for="editsettingsform[spot_moderation]"><?php echo _('Handling of moderation messages'); ?></label></dt>
					<select name="editsettingsform[spot_moderation]">
						<option <?php if ($this->_settings->get('spot_moderation') == 'disable') { echo 'selected="selected"'; } ?> value="disable"><?php echo _('Do nothing'); ?></option>
						<option <?php if ($this->_settings->get('spot_moderation') == 'act') { echo 'selected="selected"'; } ?> value="act"><?php echo _('Delete moderated spots'); ?></option>
						<option <?php if ($this->_settings->get('spot_moderation') == 'markspot') { echo 'selected="selected"'; } ?> value="markspot"><?php echo _('Mark moderated spots as moderated'); ?></option>
					</select>

					<dt><label for="editsettingsform[prepare_statistics]"><?php echo _('Prepare statistics during retrieve'); ?></label></dt>
					<dd><input type="checkbox" name="editsettingsform[prepare_statistics]" <?php if ($this->_settings->get('prepare_statistics')) { echo 'checked="checked"'; } ?>></dd>

					<dt><label for="editsettingsform[external_blacklist]"><?php echo _('Fetch the external blacklist during retrieve'); ?></label></dt>
					<dd><input type="checkbox" name="editsettingsform[external_blacklist]" <?php if ($this->_settings->get('external_blacklist')) { echo 'checked="checked"'; } ?>></dd>
				</dl>
			</fieldset>
		</div>
<?php } ?>

<script>
$(function() {
	$( "#datepicker" ).datepicker({ altField: "#retrieve_newer_than",
									dateFormat: "yy-mm-dd",
									defaultDate: "<?php echo date("Y-m-d", $retrieve_newer_than); ?>",
									dayNamesMin: ['<?php echo _('Su'); ?>', '<?php echo _('Mo'); ?>', '<?php echo _('Tu'); ?>', '<?php echo _('We'); ?>', '<?php echo _('Th'); ?>', '<?php echo _('Fr'); ?>', '<?php echo _('Sa'); ?>'],
									monthNamesShort: ['<?php echo _('Jan'); ?>', '<?php echo _('Feb'); ?>', '<?php echo _('Mar'); ?>', '<?php echo _('Apr'); ?>', '<?php echo _('May'); ?>', '<?php echo _('Jun'); ?>', '<?php echo _('Jul'); ?>', '<?php echo _('Aug'); ?>', '<?php echo _('Sep'); ?>', '<?php echo _('Oct'); ?>', '<?php echo _('Nov'); ?>', '<?php echo _('Dec'); ?>'],
									prevText: '<?php echo _('Previous'); ?>',
									nextText: '<?php echo _('Next'); ?>',
									numberOfMonths: 3,
									stepMonths: 3,
									minDate: new Date(2009, 0, 1),
									maxDate: "today" });
});
</script>

		<div class="editSettingsButtons">
			<input class="greyButton" type="submit" name="editsettingsform[submitedit]" value="<?php echo _('Change'); ?>">
			<input class="greyButton" type="submit" name="editsettingsform[submitcancel]" value="<?php echo _('Cancel'); ?>">
			<div class="clear"></div>
		</div>
	</div>
</form>
<?php
	require_once "includes/footer.inc.php";