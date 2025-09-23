<div>
    <div class="welcomTextDiv">
        <h2>
            <?php
                if ($clientID == 1) {
                    echo 'مرحبا بك في';
                }else{
                    echo 'ברוך הבא אל';
                }
            ?>
        </h2>
        <h2>
            <?php
                if ($clientID != 1) {
                    $displayNone = 'display:none';
                    echo $clientInfo['client_name'];
                }else{
                    echo 'كنيسة القديس جوارجيوس الأرثوذكسية أبوسنان';
                }
            ?>
        </h2>
        <p style="margin-top: 15px;">
            <?php
            if ($clientID != 1) {
                echo $clientInfo['description'];
            }else{
                echo 'كنيسة القديس جيورجيوس للروم الأرثوذكس في قرية أبوسنان - الجليل الغربي في الأراضي المقدسة';
            }
           ?>
        </p>
    </div>
</div>
<div style="<?=$displayNone?>">
    <div class="elementor-element elementor-element-5d2bb6d elementor-widget-divider--view-line_icon elementor-widget-divider--separator-type-pattern elementor-widget-divider--no-spacing elementor-view-default elementor-widget-divider--element-align-center elementor-widget elementor-widget-divider" data-id="5d2bb6d" data-element_type="widget" data-widget_type="divider.default">
                    <div class="elementor-widget-container" style="width: 100%; ">
                <style>
    .elementor-widget-divider{--divider-border-style:none;--divider-border-width:1px;--divider-color:#0c0d0e;--divider-icon-size:20px;--divider-element-spacing:10px;--divider-pattern-height:24px;--divider-pattern-size:20px;--divider-pattern-url:none;--divider-pattern-repeat:repeat-x}.elementor-widget-divider .elementor-divider{display:flex}.elementor-widget-divider .elementor-divider__text{font-size:15px;line-height:1;max-width:95%}.elementor-widget-divider .elementor-divider__element{margin:0 var(--divider-element-spacing);flex-shrink:0}.elementor-widget-divider .elementor-icon{font-size:var(--divider-icon-size)}.elementor-widget-divider .elementor-divider-separator{display:flex;margin:0;direction:ltr}.elementor-widget-divider--view-line_icon .elementor-divider-separator,.elementor-widget-divider--view-line_text .elementor-divider-separator{align-items:center}.elementor-widget-divider--view-line_icon .elementor-divider-separator:after,.elementor-widget-divider--view-line_icon .elementor-divider-separator:before,.elementor-widget-divider--view-line_text .elementor-divider-separator:after,.elementor-widget-divider--view-line_text .elementor-divider-separator:before{display:block;content:"";border-block-end:0;flex-grow:1;border-block-start:var(--divider-border-width) var(--divider-border-style) var(--divider-color)}.elementor-widget-divider--element-align-left .elementor-divider .elementor-divider-separator>.elementor-divider__svg:first-of-type{flex-grow:0;flex-shrink:100}.elementor-widget-divider--element-align-left .elementor-divider-separator:before{content:none}.elementor-widget-divider--element-align-left .elementor-divider__element{margin-left:0}.elementor-widget-divider--element-align-right .elementor-divider .elementor-divider-separator>.elementor-divider__svg:last-of-type{flex-grow:0;flex-shrink:100}.elementor-widget-divider--element-align-right .elementor-divider-separator:after{content:none}.elementor-widget-divider--element-align-right .elementor-divider__element{margin-right:0}.elementor-widget-divider--element-align-start .elementor-divider .elementor-divider-separator>.elementor-divider__svg:first-of-type{flex-grow:0;flex-shrink:100}.elementor-widget-divider--element-align-start .elementor-divider-separator:before{content:none}.elementor-widget-divider--element-align-start .elementor-divider__element{margin-inline-start:0}.elementor-widget-divider--element-align-end .elementor-divider .elementor-divider-separator>.elementor-divider__svg:last-of-type{flex-grow:0;flex-shrink:100}.elementor-widget-divider--element-align-end .elementor-divider-separator:after{content:none}.elementor-widget-divider--element-align-end .elementor-divider__element{margin-inline-end:0}.elementor-widget-divider:not(.elementor-widget-divider--view-line_text):not(.elementor-widget-divider--view-line_icon) .elementor-divider-separator{border-block-start:var(--divider-border-width) var(--divider-border-style) var(--divider-color)}.elementor-widget-divider--separator-type-pattern{--divider-border-style:none}.elementor-widget-divider--separator-type-pattern.elementor-widget-divider--view-line .elementor-divider-separator,.elementor-widget-divider--separator-type-pattern:not(.elementor-widget-divider--view-line) .elementor-divider-separator:after,.elementor-widget-divider--separator-type-pattern:not(.elementor-widget-divider--view-line) .elementor-divider-separator:before,.elementor-widget-divider--separator-type-pattern:not([class*=elementor-widget-divider--view]) .elementor-divider-separator{width:100%;min-height:var(--divider-pattern-height);-webkit-mask-size:var(--divider-pattern-size) 100%;mask-size:var(--divider-pattern-size) 100%;-webkit-mask-repeat:var(--divider-pattern-repeat);mask-repeat:var(--divider-pattern-repeat);background-color:var(--divider-color);-webkit-mask-image:var(--divider-pattern-url);mask-image:var(--divider-pattern-url)}.elementor-widget-divider--no-spacing{--divider-pattern-size:auto}.elementor-widget-divider--bg-round{--divider-pattern-repeat:round}.rtl .elementor-widget-divider .elementor-divider__text{direction:rtl}.e-con-inner>.elementor-widget-divider,.e-con>.elementor-widget-divider{width:var(--container-widget-width,100%);--flex-grow:var(--container-widget-flex-grow)}
    </style>		
    <div class="elementor-divider" style="margin: 20px auto;--divider-pattern-url: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='none' overflow='visible' height='100%' viewBox='0 0 24 24' fill='black' stroke='none'%3E%3Cpath d='M24,8v12H0V8H24z M24,4v1H0V4H24z'/%3E%3C/svg%3E&quot;);">
                <span class="elementor-divider-separator" style="width: 80%;margin: 0 auto;max-width: 350px;">
                                <div class="elementor-icon elementor-divider__element">
                        <svg aria-hidden="true" style="vertical-align: middle;
                                                    fill: black;
                                                    width: 1em;
                                                    height: 1em;
                                                    position: relative;
                                                    display: block;" class="e-font-icon-svg e-fas-cross" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path d="M352 128h-96V32c0-17.67-14.33-32-32-32h-64c-17.67 0-32 14.33-32 32v96H32c-17.67 0-32 14.33-32 32v64c0 17.67 14.33 32 32 32h96v224c0 17.67 14.33 32 32 32h64c17.67 0 32-14.33 32-32V256h96c17.67 0 32-14.33 32-32v-64c0-17.67-14.33-32-32-32z"></path></svg></div>
                            </span>
            </div>
        </div>
    </div>

    <div class="elementor-element elementor-element-9bc7b97 elementor-widget elementor-widget-text-editor" data-id="9bc7b97" data-element_type="widget" data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                                <blockquote><p style="text-align: center;"><b>وَتَعْرِفُونَ الْحَقَّ، وَالْحَقُّ يُحَرِّرُكُمْ</b></p></blockquote><p style="text-align: center;"><strong>يوحنا 8: 32</strong></p>						</div>
    </div>
</div>
