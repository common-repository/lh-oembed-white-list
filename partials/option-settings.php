<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<form name="lh_oembed_white_list-backend_form" method="post" action="">
<input type="hidden" name="<?php echo $this->hidden_field_name; ?>" value="Y" />
<?php wp_nonce_field( $this->namespace.'-backend_form-nonce', $this->namespace.'-backend_form-nonce' ); ?>
<table class="form-table">
<?php if (isset($this->options[$this->providers_field_name])){     foreach ($this->options[$this->providers_field_name] as $key => $value){ ?>
<tr valign="top">
<th scope="row"><label><?php echo $key; ?></label></th>
<td>
<input name="<?php echo $this->providers_field_name.'['.$key.']';  ?>" type="url" value="<?php echo $value; ?>" /></td>
</tr>
<?php }    }   ?>
<tr valign="top">
<th scope="row"><input name="<?php echo $this->providers_field_name.'-new_format';  ?>" type="text" placeholder="New Provider Format" /></th>
<td><input name="<?php echo $this->providers_field_name.'-new_provider';  ?>" type="url" placeholder="New Provider Endpoint" /></td>
</tr>
</table>
<?php submit_button( 'Save Changes' ); ?>
</form>