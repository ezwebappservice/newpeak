                        <h3 class="sec_title">Hero Section</h3>
                        <p class="col-sm-offset-2 col-sm-9 text-muted">Homepage banner copy, buttons, feature labels, and the portrait card. Portrait image: Home Page Settings → Hero Image.</p>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Eyebrow</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_badge" value="<?php echo esc($page_home['hero_badge'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Heading line 1</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_title_prefix" value="<?php echo esc($page_home['hero_title_prefix'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Heading accent</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_title_highlight" value="<?php echo esc($page_home['hero_title_highlight'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Heading line 3</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_title_suffix" value="<?php echo esc($page_home['hero_title_suffix'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Intro text</label>
                            <div class="col-sm-9"><textarea class="form-control" name="hero_lead" style="height:90px;"><?php echo esc($page_home['hero_lead'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Button 1 Text / URL</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="hero_btn1_text" value="<?php echo esc($page_home['hero_btn1_text'] ?? ''); ?>"></div>
                            <div class="col-sm-5"><input type="text" class="form-control" name="hero_btn1_url" value="<?php echo esc($page_home['hero_btn1_url'] ?? ''); ?>" placeholder="customer-enquiry-form"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Button 2 Text / URL</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="hero_btn2_text" value="<?php echo esc($page_home['hero_btn2_text'] ?? ''); ?>"></div>
                            <div class="col-sm-5"><input type="text" class="form-control" name="hero_btn2_url" value="<?php echo esc($page_home['hero_btn2_url'] ?? ''); ?>" placeholder="contact-us"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Feature 1</label>
                            <div class="col-sm-3"><textarea class="form-control" name="hero_feature_1_title" rows="2"><?php echo esc($page_home['hero_feature_1_title'] ?? ''); ?></textarea></div>
                            <label class="col-sm-2 control-label">Feature 2</label>
                            <div class="col-sm-3"><textarea class="form-control" name="hero_feature_2_title" rows="2"><?php echo esc($page_home['hero_feature_2_title'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Feature 3</label>
                            <div class="col-sm-3"><textarea class="form-control" name="hero_feature_3_title" rows="2"><?php echo esc($page_home['hero_feature_3_title'] ?? ''); ?></textarea></div>
                            <label class="col-sm-2 control-label">Book tab text</label>
                            <div class="col-sm-3"><input type="text" class="form-control" name="hero_tab_text" value="<?php echo esc($page_home['hero_tab_text'] ?? ''); ?>"></div>
                        </div>
                        <h4 class="col-sm-offset-2 col-sm-9" style="margin:10px 0;">Portrait card</h4>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="hero_card_name" value="<?php echo esc($page_home['hero_card_name'] ?? ''); ?>"></div>
                            <label class="col-sm-1 control-label">Role</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="hero_card_role" value="<?php echo esc($page_home['hero_card_role'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Organisation</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_card_org" value="<?php echo esc($page_home['hero_card_org'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Badge text</label>
                            <div class="col-sm-9"><textarea class="form-control" name="hero_card_badge" rows="2"><?php echo esc($page_home['hero_card_badge'] ?? ''); ?></textarea></div>
                        </div>
