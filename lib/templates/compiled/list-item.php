<?php
use \LightnCandy\SafeString as SafeString;use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
    $helpers = array(            'tolowercase' => function( $string ){
          if( is_string( $string ) ){
            return strtolower( $string );
          } else {
            return false;
          }
        },
);
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
    return '<div class="related-posts">
'.LR::sec($cx, (($inary && isset($in['items'])) ? $in['items'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '    <div class="list-item '.htmlspecialchars((string)LR::hbch($cx, 'tolowercase', array(array(((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['resource_type'])) ? $in['terms']['resource_type'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' '.htmlspecialchars((string)LR::hbch($cx, 'tolowercase', array(array(((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['news_category'])) ? $in['terms']['news_category'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'">
      <a href="'.htmlspecialchars((string)(($inary && isset($in['permalink'])) ? $in['permalink'] : null), ENT_QUOTES, 'UTF-8').'">
        <div class="list-content post '.htmlspecialchars((string)LR::hbch($cx, 'tolowercase', array(array(((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['resource_type'])) ? $in['terms']['resource_type'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' '.htmlspecialchars((string)LR::hbch($cx, 'tolowercase', array(array(((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['news_category'])) ? $in['terms']['news_category'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'">
          <div class="overlay" style="background-image: url('.htmlspecialchars((string)(($inary && isset($in['thumbnail'])) ? $in['thumbnail'] : null), ENT_QUOTES, 'UTF-8').')">
            <div class="ribbon '.htmlspecialchars((string)LR::hbch($cx, 'tolowercase', array(array(((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['resource_type'])) ? $in['terms']['resource_type'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' '.htmlspecialchars((string)LR::hbch($cx, 'tolowercase', array(array(((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['news_category'])) ? $in['terms']['news_category'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'"></div>
            <div class="blue-overlay"></div>
            <div class="category-overlay">
'.((LR::ifvar($cx, ((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['news_category'])) ? $in['terms']['news_category'] : null), false)) ? '              '.htmlspecialchars((string)((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['news_category'])) ? $in['terms']['news_category'] : null), ENT_QUOTES, 'UTF-8').'
' : '              '.htmlspecialchars((string)((isset($in['terms']) && is_array($in['terms']) && isset($in['terms']['resource_type'])) ? $in['terms']['resource_type'] : null), ENT_QUOTES, 'UTF-8').'
').'            </div>
          </div>
          <p class="meta">'.htmlspecialchars((string)(($inary && isset($in['meta'])) ? $in['meta'] : null), ENT_QUOTES, 'UTF-8').'</p>
          <h3 class="title">'.htmlspecialchars((string)(($inary && isset($in['title'])) ? $in['title'] : null), ENT_QUOTES, 'UTF-8').'</h3>
        </div>
      </a>
    </div>
';}).'</div>';
};
?>