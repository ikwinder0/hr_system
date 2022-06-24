<div class="container">
  <div class="row justify-content-md-center">
    <div class="card ">
      <div class="card-header">
        <h5>
          <?= lang('Membership.xin_how_can_we_help');?>
        </h5>
      </div>
      <div class="card-body">
        <div class="alert alert-primary">
          <div class="media align-items-center"> <i class="feather icon-alert-circle h2"></i>
            <div class="media-body ml-3">
              <?= lang('Membership.xin_ask_a_question_text');?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="demo-text-input" class="col-form-label">
                <?= lang('Dashboard.xin_category');?>
              </label>
              <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Dashboard.xin_category');?>">
                <option value="General">
                <?= lang('Membership.xin_general');?>
                </option>
                <option value="Technical">
                <?= lang('Membership.xin_technical');?>
                </option>
                <option value="Billing">
                <?= lang('Membership.xin_billing');?>
                </option>
                <option value="Other">
                <?= lang('Membership.xin_other');?>
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="demo-number-input" class="col-form-label">
                <?= lang('Projects.xin_p_priority');?>
              </label>
              <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?= lang('Projects.xin_p_priority');?>">
                <option value="Normal">
                <?= lang('Projects.xin_normal');?>
                </option>
                <option value="Important">
                <?= lang('Membership.xin_important');?>
                </option>
                <option value="High">
                <?= lang('Membership.xin_high_priority');?>
                </option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="demo-tel-input" class="col-form-label">
            <?= lang('Membership.xin_describe_your_problem');?>
          </label>
          <input class="form-control" type="text" placeholder="<?= lang('Membership.xin_write_your_problem');?>... " id="demo-tel-input">
        </div>
        <div class="form-group">
          <label for="demo-email-input" class="col-form-label">
            <?= lang('Membership.xin_give_us_details');?>
          </label>
          <textarea class="form-control" id="exampleTextarea" placeholder="<?= lang('Membership.xin_give_us_details_placeholder');?>..." rows="3"></textarea>
        </div>
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary">
        <?= lang('Membership.xin_email_us');?>
        </button>
      </div>
    </div>
  </div>
</div>
