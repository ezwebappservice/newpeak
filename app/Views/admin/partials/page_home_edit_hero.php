                        <h3 class="sec_title">Hero Section</h3>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Badge</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_badge" value="<?php echo esc($page_home['hero_badge'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title Prefix</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_title_prefix" value="<?php echo esc($page_home['hero_title_prefix'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Title Highlight</label>
                            <div class="col-sm-9"><input type="text" class="form-control" name="hero_title_highlight" value="<?php echo esc($page_home['hero_title_highlight'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lead Text</label>
                            <div class="col-sm-9"><textarea class="form-control" name="hero_lead" style="height:90px;"><?php echo esc($page_home['hero_lead'] ?? ''); ?></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Button 1 Text / URL</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="hero_btn1_text" value="<?php echo esc($page_home['hero_btn1_text'] ?? ''); ?>"></div>
                            <div class="col-sm-5"><input type="text" class="form-control" name="hero_btn1_url" value="<?php echo esc($page_home['hero_btn1_url'] ?? ''); ?>"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Button 2 Text / URL</label>
                            <div class="col-sm-4"><input type="text" class="form-control" name="hero_btn2_text" value="<?php echo esc($page_home['hero_btn2_text'] ?? ''); ?>"></div>
                            <div class="col-sm-5"><input type="text" class="form-control" name="hero_btn2_url" value="<?php echo esc($page_home['hero_btn2_url'] ?? ''); ?>"></div>
                        </div>
                        <p class="col-sm-offset-2 col-sm-9 text-muted">Background slideshow images: Admin → Page Settings → Hero Background Slides (upload one image per slide). Hero text and buttons are edited here.</p>
