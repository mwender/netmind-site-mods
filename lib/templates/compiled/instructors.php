<?php
use \LightnCandy\SafeString as SafeString;use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
    $helpers = array();
    $partials = array();
    $cx = array(
        'flags' => array(
            'jstrue' => false,
            'jsobj' => false,
            'jslen' => false,
            'spvar' => true,
            'prop' => false,
            'method' => false,
            'lambda' => false,
            'mustlok' => false,
            'mustlam' => false,
            'mustsec' => false,
            'echo' => false,
            'partnc' => false,
            'knohlp' => false,
            'debug' => isset($options['debug']) ? $options['debug'] : 1,
        ),
        'constants' => array(),
        'helpers' => isset($options['helpers']) ? array_merge($helpers, $options['helpers']) : $helpers,
        'partials' => isset($options['partials']) ? array_merge($partials, $options['partials']) : $partials,
        'scopes' => array(),
        'sp_vars' => isset($options['data']) ? array_merge(array('root' => $in), $options['data']) : array('root' => $in),
        'blparam' => array(),
        'partialid' => 0,
        'runtime' => '\LightnCandy\Runtime',
    );
    
    $inary=is_array($in);
    return '<style>
.instructors .elementor-image-box-description{
  font-size: 16px;
}
.instructors .elementor-image-box-img img{
  width: 154px;
  height: 154px;
  border-radius: 50%;
}
</style>
'.LR::sec($cx, (($inary && isset($in['rows'])) ? $in['rows'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '<section class="elementor-section elementor-top-section elementor-element elementor-element-39c098ca elementor-section-boxed elementor-section-height-default elementor-section-height-default">
  <div class="elementor-container elementor-column-gap-default">
    <div class="elementor-row instructors">
'.LR::sec($cx, (($inary && isset($in['instructors'])) ? $in['instructors'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '        <div class="elementor-column elementor-col-25 elementor-top-column elementor-element" data-element_type="column">
          <div class="elementor-column-wrap elementor-element-populated">
            <div class="elementor-widget-wrap">
              <div class="elementor-element elementor-position-top elementor-vertical-align-top elementor-widget elementor-widget-image-box" data-element_type="widget" data-widget_type="image-box.default">
                <div class="elementor-widget-container">
                  <div class="elementor-image-box-wrapper">
                    <figure class="elementor-image-box-img">
                      <img src="'.htmlspecialchars((string)(($inary && isset($in['thumbnail'])) ? $in['thumbnail'] : null), ENT_QUOTES, 'UTF-8').'" class="attachment-full size-full" alt="'.htmlspecialchars((string)(($inary && isset($in['name'])) ? $in['name'] : null), ENT_QUOTES, 'UTF-8').'" loading="lazy" '.htmlspecialchars((string)(($inary && isset($in['srcset'])) ? $in['srcset'] : null), ENT_QUOTES, 'UTF-8').'>
                    </figure>
                    <div class="elementor-image-box-content">
                      <h4 class="elementor-image-box-title">'.htmlspecialchars((string)(($inary && isset($in['name'])) ? $in['name'] : null), ENT_QUOTES, 'UTF-8').'</h4>
                      <p class="elementor-image-box-description">'.htmlspecialchars((string)(($inary && isset($in['title'])) ? $in['title'] : null), ENT_QUOTES, 'UTF-8').'</p>
                    </div><!-- .elementor-image-box-content -->
                  </div><!-- .elementor-image-box-wrapper -->
                </div><!-- .elementor-widget-container -->
              </div><!-- .elementor-widget-image-box -->
            </div><!-- .elementor-widget-wrap -->
          </div><!-- .elementor-column-wrap.elementor-element-populated -->
        </div><!-- .elementor-column.elementor-col-25.elementor-top-column.elementor-element -->
';}).'    </div><!-- .elementor-row.instructors -->
  </div><!-- .elementor-container.elementor-column-gap-default -->
</section>
';}).'';
};
?>