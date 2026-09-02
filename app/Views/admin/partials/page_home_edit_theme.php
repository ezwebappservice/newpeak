                        <h3 class="sec_title">Vision &amp; Mission</h3>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Vision Title / Text</label>
                            <div class="col-sm-3"><input type="text" class="form-control" name="home_vision_title" value="<?php echo esc($page_home['home_vision_title'] ?? ''); ?>"></div>
                            <div class="col-sm-6"><textarea class="form-control" name="home_vision_text" style="height:70px;"><?php echo esc($page_home['home_vision_text'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mission Title / Text</label>
                            <div class="col-sm-3"><input type="text" class="form-control" name="home_mission_title" value="<?php echo esc($page_home['home_mission_title'] ?? ''); ?>"></div>
                            <div class="col-sm-6"><textarea class="form-control" name="home_mission_text" style="height:70px;"><?php echo esc($page_home['home_mission_text'] ?? ''); ?></textarea></div>
                        </div>

                        <h3 class="sec_title">Section Intros &amp; Partners</h3>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Products Intro</label>
                            <div class="col-sm-9"><textarea class="form-control" name="home_service_intro" style="height:70px;"><?php echo esc($page_home['home_service_intro'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Industries Intro</label>
                            <div class="col-sm-9"><textarea class="form-control" name="home_feature_intro" style="height:70px;"><?php echo esc($page_home['home_feature_intro'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Why Choose Intro</label>
                            <div class="col-sm-9"><textarea class="form-control" name="home_why_choose_intro" style="height:70px;"><?php echo esc($page_home['home_why_choose_intro'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Partners Tagline</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="home_partners_tagline" value="<?php echo esc($page_home['home_partners_tagline'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Certifications Title / Subtitle</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="home_cert_title" value="<?php echo esc($page_home['home_cert_title'] ?? ''); ?>"></div>
                            <div class="col-sm-5"><input type="text" class="form-control" name="home_cert_subtitle" value="<?php echo esc($page_home['home_cert_subtitle'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Certifications Intro</label>
                            <div class="col-sm-9"><textarea class="form-control" name="home_cert_intro" style="height:70px;"><?php echo esc($page_home['home_cert_intro'] ?? ''); ?></textarea></div>
                        </div>
                        <p class="col-sm-offset-2 col-sm-9 text-muted">Certification cards: Admin → Homepage Sections → Certifications.</p>

                        <h3 class="sec_title">Why Choose Feature Cards</h3>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Card 1 Title / Icon</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="home_feature_mini1_title" value="<?php echo esc($page_home['home_feature_mini1_title'] ?? ''); ?>"></div>
                            <div class="col-sm-3"><input type="text" class="form-control" name="home_feature_mini1_icon" value="<?php echo esc($page_home['home_feature_mini1_icon'] ?? ''); ?>" placeholder="bi bi-geo-alt"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Card 1 Text</label>
                            <div class="col-sm-9"><textarea class="form-control" name="home_feature_mini1_text" style="height:60px;"><?php echo esc($page_home['home_feature_mini1_text'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Card 2 Title / Icon</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="home_feature_mini2_title" value="<?php echo esc($page_home['home_feature_mini2_title'] ?? ''); ?>"></div>
                            <div class="col-sm-3"><input type="text" class="form-control" name="home_feature_mini2_icon" value="<?php echo esc($page_home['home_feature_mini2_icon'] ?? ''); ?>" placeholder="bi bi-graph-up-arrow"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Card 2 Text</label>
                            <div class="col-sm-9"><textarea class="form-control" name="home_feature_mini2_text" style="height:60px;"><?php echo esc($page_home['home_feature_mini2_text'] ?? ''); ?></textarea></div>
                        </div>
