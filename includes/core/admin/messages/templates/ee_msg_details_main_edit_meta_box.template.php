<div id="admin-primary-mbox-dv" class="admin-primary-mbox-dv">
	
	<h4 class="admin-primary-mbox-h4"><?php echo ($event_name) ? $event_name . ' Custom Template' : ''; ?></h4>

	<!-- todo: temp putting context swticher here .. will have to figure out how to put it at the top later (or maybe in a sidebar?) -->
	<form method="get" action="<?php echo $context_swticher_url; ?>" id="ee-msg-context-switcher-frm">
		<select name="context">
			<?php if ( $context_templates = $message_template->context_templates() && is_array($context_templates) ) :
					foreach ( $context_templates as $context => $template_fields ) :
			?>
			<option value="<?php echo $context; ?>"><?php echo $context; ?></option>
			<?php endforeach; endif; ?>
		</select>
		<input id="submit-msg-context-switcher-sbmt" class="button-secondary" type="submit" value="Switch Context">
	</form>

	<form method="post" action"<?php 
</div> <!-- end #admin-primary-mbox-dv -->
