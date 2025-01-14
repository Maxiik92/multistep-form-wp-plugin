<div class="wrap">
  <h1>Multistep Form Settings</h1>
  <form method="post" action="options.php" class="row g-3">
    <?php
    settings_fields('multistep_form_settings');
    do_settings_sections('multistep_form_settings');
    ?>
    <div class="row">
      <div class="col-md-6">
        <label class="form-label" for="multistep_form_steps">
          Number of Steps
          <span class="dashicons dashicons-info-outline" data-bs-toggle="tooltip"
            data-bs-title="Number of steps into which the form is devided"></span>
        </label>
        <input type="number" name="multistep_form_steps" id="multistep_form_steps" class="form-control" min="1" max="10"
          value="<?php echo esc_attr(get_option('multistep_form_steps', 3)); ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <label class="form-label" for="multistep_form_email">
          E-mail
          <span class="dashicons dashicons-info-outline" data-bs-toggle="tooltip"
            data-bs-title="Email address for form submission"></span>
        </label>
        <input type="email" name="multistep_form_email" id="multistep_form_email" class="form-control"
          value="<?php echo esc_attr(get_option('multistep_form_email', '')) ?>">
      </div>
    </div>
    <?php submit_button(); ?>
  </form>
</div>