<div class="page-wrapper">
  <h2>Multi-step Formulár</h2>
  <div class="wrapper">
    <!-- progress bar -->
    <?php if ($steps > 1): ?>
      <div id="progress-container">
        <div class="progress-wrapper d-flex justify-content-between align-items-center">
          <?php for ($i = 1; $i <= $steps; $i++): ?>
            <!-- step number -->
            <div class="progress-step <?php if ($i == $steps)
              echo 'last' ?>">
                <div class="circle <?php if ($i == 1)
              echo 'active' ?>">
                <?php echo $i ?>
              </div>
              <?php if ($i < $steps): ?>
                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="0" aria-valuemin="0"
                  aria-valuemax="100">
                  <div class="progress-bar bg-success"></div>
                </div>
              <?php endif; ?>
            </div>
          <?php endfor ?>
        </div>
      </div>

      <hr>
    <?php endif; ?>

    <!-- formular -->
    <form id="multistep-form">
      <?php
      $currentStep = 1;
      $fieldCount = 0;
      $orderInStep = 1;

      foreach ($inputs as $key => $field):
        $isFirstFieldInStep = $fieldCount % $inputsPerStep === 0;
        $isLastFieldInStep = ($fieldCount + 1) % $inputsPerStep === 0 || $fieldCount === count($inputs) - 1;

        if ($isFirstFieldInStep): ?>
          <div class="form-step <?php echo $currentStep === 1 ? 'active' : '' ?>" data-step="<?php echo $currentStep ?>">
          <?php endif; ?>

          <?php if ($orderInStep % 2 !== 0): ?>
            <div class="row">
            <?php endif; ?>
            <div class="form-group col-md-6 mb-3">
              <label for="<?php echo $key ?>"><?php echo $field['name'] ?></label>
              <?php echo $field['html'] ?>
            </div>

            <?php if ($orderInStep % 2 === 0 || $isLastFieldInStep): ?>
            </div>
          <?php endif; ?>

          <?php if ($isLastFieldInStep):
            $currentStep++;
            $orderInStep = 0;
            ?>
          </div>
        <?php endif;
          $orderInStep++;
          $fieldCount++;
      endforeach ?>
    </form>
  </div>
</div>
<div class="buttons">
  <button data-trigger="previous" type="button" class="btn btn-primary custom-btn hidden prev-step">
    Previous step
  </button>
  <button data-trigger="next" type="button" class="btn btn-primary custom-btn next-step">
    Next step
  </button>
  <button data-trigger="submit" type="button" disabled="true" class="btn btn-primary custom-btn submit-form hidden">
    Submit
  </button>
</div>
</div>