<?php
/*
 * Bootstrap Helper
 * testing Bootstrap: 3.3.4
 * 
 * version: 2015-04-26
 */

//define constants
define('BOOTSTRAP_STYLE_DEFAULT', 'default');
define('BOOTSTRAP_STYLE_PRIMARY', 'primary');
define('BOOTSTRAP_STYLE_INFO', 'info');
define('BOOTSTRAP_STYLE_SUCCESS', 'success');
define('BOOTSTRAP_STYLE_DANGER', 'danger');
define('BOOTSTRAP_STYLE_WARNING', 'warning');
define('BOOTSTRAP_STYLE_MUTED', 'muted');
define('BOOTSTRAP_STYLE_LINK', 'link');

define('BOOTSTRAP_SIZE_LARGE', 'lg');
define('BOOTSTRAP_SIZE_DEFAULT', '');
define('BOOTSTRAP_SIZE_SMALL', 'sm');
define('BOOTSTRAP_SIZE_EXTRA_SMALL', 'xs');

define('BOOTSTRAP_TOP', 'top');
define('BOOTSTRAP_BOTTOM', 'bottom');

define('BOOTSTRAP_STATE_ACTIVE', 'active');
define('BOOTSTRAP_STATE_DISABLED', 'disabled');

define('BOOTSTRAP_COLUMN_1', 1);
define('BOOTSTRAP_COLUMN_2', 2);
define('BOOTSTRAP_COLUMN_3', 3);
define('BOOTSTRAP_COLUMN_4', 4);
define('BOOTSTRAP_COLUMN_6', 6);
define('BOOTSTRAP_COLUMN_12', 12);

App::uses('Helper', 'View');
class BsHelper extends AppHelper {

    var $helpers = array(
        'Html',
        'Form',
        'Js',
        'Paginator'
    );
    
    var $schema = array();
    /**
     * 
     * Apply contextual classes
     * by options
     * @param type $options
     * @param type $tagName
     * @return type
     */
    private function contextualClasses($options, $tagName = null){
        if (!empty($options['text']))
        {
            $options = $this->addClass($options, 'text-' . $options['text']);
            unset($options['text']);
        }
        
        if (!empty($options['bg']))
        {
            $options = $this->addClass($options, 'bg-' . $options['bg']);
            unset($options['bg']);
        }
        
        if (!empty($options['active']))
        {
            $options = $this->addClass($options, 'active');
            unset($options['active']);
        }

        if ($this->hasClass($options, 'btn-group')){
            if (isset($options['sized'])){
                $options = $this->addClass($options, 'btn-group-' . $options['sized']);
                unset($options['sized']);
            }
        }
        
        if (isset($options['right'])){
            if ($options['right'])
                $options = $this->addClass($options, 'pull-right');
            unset($options['right']);
        }

        if ($this->hasClass($options, 'btn-group-vertical')){
            if (isset($options['sized'])){
                $options = $this->addClass($options, 'btn-group-' . $options['sized']);
                unset($options['sized']);
            }
        }
        
        if ($this->hasClass($options, 'panel')){
            if (!empty($options['styled']))
            {
                $options = $this->addClass($options, 'panel-' . $options['styled']);
                unset($options['styled']);
            }            
        }
        
        if ($tagName == 'span' && $this->hasClass($options, 'label')){
            if (isset($options['styled']))
            {
                $options = $this->addClass($options, 'label-' . $options['styled']);
                unset($options['styled']);
            }
        }
        
        if ($this->hasClass($options, 'alert')){
            if (isset($options['styled']))
            {
                $options = $this->addClass($options, 'alert-' . $options['styled']);
                unset($options['styled']);
            }
        }
        
        if ($tagName == 'span' && $this->hasClass($options, 'badge')){
            if (isset($options['styled']))
            {
                $options = $this->addClass($options, 'badge-' . $options['styled']);
                unset($options['styled']);
            }
        }
        
        if ($tagName == 'a'){
            if (empty($options['href']))
                $options['href'] = '#';
        }
        
        if ($tagName == 'p'){
            if (!empty($options['lead'])){
                $options = $this->addClass($options, 'lead');
                unset($options['lead']);
            }
        }
        
        if ($tagName == 'i'){
            if ($this->hasClass($options, 'fa')){
                if (isset($options['styled'])){
                    $options = $this->addClass($options, 'text-' . $options['styled']);
                    unset($options['styled']);
                }
            }
        }
        
        if ($this->hasClass($options, 'pagination')){
            if (isset($options['sized']))
            {
                $options = $this->addClass($options, 'pagination-' . $options['sized']);
                unset($options['sized']);
              //  debug($options);
            }

        }
        
        if ($this->hasClass($options, 'btn')){
            if (isset($options['sized']))
            {
                $options = $this->addClass($options, 'btn-' . $options['sized']);
                unset($options['sized']);
              //  debug($options);
            }
            
            if (isset($options['styled']))
            {
                $options = $this->addClass($options, 'btn-' . $options['styled']);
                unset($options['styled']);
            }
        }
        
        return $options;
    }
    
    public function cols($elements = array(), $cols = 1, $options = array()){
       for ($i = count($elements) - 1; $i >= 0; $i--)
            if ($elements[$i] === false)
                unset($elements[$i]);
            
            $rows = array_chunk($elements, $cols);
            
            $class_name = 'col-md-' . 12 / $cols;
            $html = '';
            foreach ($rows as $row){
                $row_html = '';
                foreach ($row as $el){
                    $row_html .= $this->div($el, $class_name);
                }
                $html .= $this->row($row_html);
            }
            
            return $html;
    }
    
    public function small($content, $options = array()){
        return $this->tag('small', $content, $options);
    }
    
    private function h($level = 2, $content, $options = array()){
        
        if (!empty($options['small'])){
            $content .= ' ' . $this->tag('small', $options['small']);
            unset($options['small']);
        }
        return $this->tag("h$level", $content, $options);
    }
    
    private function hasClass($options, $class){
        if (empty($options['class']))
            return false;
        
        return in_array($class, explode(' ', $options['class']));
    }

    public function pagination($pagination_options = array()){
        
         $pagination_content = $this->Paginator->numbers(array(
           // 'model' => $modelName,
            'tag' => 'li',
            'separator' => null,
            'currentTag' => 'a',
            'currentClass' => 'active',
            'first' => 1,
            'last' => 1,
            'ellipsis' => null,
        ));
         
         $pagination_options = $this->addClass($pagination_options, 'pagination');
         
         return $this->tag('nav',
                 $this->ul(
                         $pagination_content,
                         $pagination_options
                      )
                 );
    }
    
    public function panel($body, $title = null, $footer = null, $panel_options = array()) {

        $_options = array(
            'title' => null,
            'body' => null,
            'footer' => null,
            'toolbar' => null
        );

        //debug(compact('_options', 'panel_options', 'body', 'title', 'footer'));

        if (is_array($body))
            $_options = $body;

        if (is_array($title))
            $panel_options = $title;

        if (is_array($footer))
            $panel_options = $footer;

        if (is_string($title))
            $_options['title'] = $title;

        if (is_string($body))
            $_options['body'] = $body;

        if (is_string($footer))
            $_options['footer'] = $footer;

        
        
        
        if (is_array($footer))
            $panel_options = $footer;
        

        if (isset($panel_options['options']))
        {
            $_options = $panel_options['options'] + $_options;
            unset($panel_options['options']);
        }        

        //debug(compact('_options', 'panel_options'));
        
        /*
         * main panel options
         */
        $panel_options = $this->addClass($panel_options, 'panel panel-default');

        $panel_heading = $panel_body = $panel_footer = $panel_toolbar = null;

        /*
         * toolbar
         */
        
        if (isset($_options['toolbar'])){
            if (is_string($_options['toolbar']))
                $panel_toolbar = $_options['toolbar'];
            else {
                $panel_toolbar = $this->btn_group($_options['toolbar'], array(                    
                    'right' => true,
                    'sized' => BOOTSTRAP_SIZE_EXTRA_SMALL,
                    'style' => 'margin-top: -5px; margin-right: -10px;'
                ));
            }
        }        
        
        if (is_string($_options['title']))
            $panel_heading = $this->div(
                    $panel_toolbar .
                    $this->tag(
                            'h3', $_options['title'], array('class' => 'panel-title')
                    ), array(
                'class' => 'panel-heading')
            );

        if (is_array($_options['title']))
            $panel_heading = $this->div(
                    $this->tagFromArray($_options['title']) . $panel_toolbar, array(
                'class' => 'panel-heading')
            );

        if (is_string($_options['body']))
            $panel_body = $this->div(
                    $_options['body'], array('class' => 'panel-body')
            );

        if (is_array($_options['body']))
            $panel_body = $this->div(
                    $_options['body'][0], $this->addClass($_options['body'][1], 'panel-body')
            );

        if (is_string($_options['footer']))
            $panel_footer = $this->div(
                    $_options['footer'], array('class' => 'panel-footer')
            );

        if (is_array($_options['footer']))
            $panel_footer = $this->div(
                    $_options['footer'][0], $this->addClass($_options['footer'][1], 'panel-footer')
            );
        


        return $this->div(
                        implode(array(
                            empty($_options['before_heading']) ? null : $_options['before_heading'],
                            empty($_options['before']['heading']) ? null : $_options['before']['heading'],
                            $panel_heading,
                            empty($_options['after_heading']) ? null : $_options['after_heading'],
                            empty($_options['after']['heading']) ? null : $_options['after']['heading'],
                            empty($_options['before_body']) ? null : $_options['before_body'],
                            empty($_options['before']['body']) ? null : $_options['before']['body'],
                            $panel_body,
                            empty($_options['after_body']) ? null : $_options['after_body'],
                            empty($_options['after']['body']) ? null : $_options['after']['body'],
                            empty($_options['before_footer']) ? null : $_options['before_footer'],
                            empty($_options['before']['footer']) ? null : $_options['before']['footer'],
                            $panel_footer,
                            empty($_options['after_footer']) ? null : $_options['after_footer'],
                            empty($_options['after']['footer']) ? null : $_options['after']['footer'],
                        )), $panel_options
        );
    }

    public function jumbotron($title, $content, $button){
        
        
        return $this->div(
                
                );
        /*
<div class="jumbotron">
  <h1>Hello, world!</h1>
  <p>...</p>
  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
</div>
         */
    }
    public function icon($icon, $options = array()){
        if (is_string($icon))
            $options = $this->addClass($options, $icon);
        
        if (strpos($options['class'], 'fa-') !== false)
             if (!$this->hasClass($options, 'fa'))   
               $options = $this->addClass($options, 'fa');      
        
        
        
        if (is_array($icon)){
            
        }
        
        return $this->tag('i', '', $options);
    }
    
    /*
     * Check array
     * tag properties or custom user array
     */
    public function is_tag($options = array()){
        if (!is_array($options))
            return false;
        
        /*
         * check numeric array or associative
         */
        
        if (!empty($options[0]))
            return false;
        
        /*
         * More popular tag's attributes
         */
        $attrs = array(
            'href', 'class', 'id', 'type', 'role', 'name', 'style', 'data-toggle'            
        );
        
        return (bool) array_intersect(array_keys($options), $attrs);
    }
    
    /*
     * Check string - is clear text or <tagged> exists
     */
    private function no_tags($string){
        return
            strpos($string, '>') === false &&
            strpos($string, '<') === false;
    }
    
    public function navbar($options){
        
        $navbar_header = $navbar_content = $navbar_content_right = null;
        
        if (empty($options['id']))
            $options['id'] = 'navbar-collapse-' . uniqid ();
        
        if (isset($options['header'])){
            
            $options['header']['toggle'] = isset($options['header']['toggle'])
                    ? $options['header']['toggle']
                    : true;
            
            $options['header']['brand'] = isset($options['header']['brand'])
                    ? $options['header']['brand']
                    : false;
            
            $header_toggle_content = $header_brand_content = null;
            
            if ($options['header']['toggle']){
                if (empty($options['header']['toggle_title']))
                    $options['header']['toggle_title'] = 'Toggle navigation';
                
                $header_toggle_content = $this->tag('button',
                        $this->span($options['header']['toggle_title'], 'sr-only') .
                        $this->icon('icon-bar') .
                        $this->icon('icon-bar') .
                        $this->icon('icon-bar'),
                        array(
                            'type'=>"button" ,
                            'class'=>"navbar-toggle collapsed" ,
                            'data-toggle'=>"collapse" ,
                            'data-target'=>"#" . $options['id'],
                        ));
            }
            
            if ($options['header']['brand']){
                if (is_string($options['header']['brand'])){
                    if ($this->no_tags($options['header']['brand'])){
                        
                        $header_brand_icon = null;
                        if (!empty($options['header']['icon']))
                            $header_brand_icon .= $this->icon($options['header']['icon']). ' ';
                        
                        if (!empty($options['header']['image']))
                             $header_brand_icon .= $options['header']['image'];   
                        
                        $header_brand_options = array(
                            'class' => 'navbar-brand',
                            'href' => empty($options['header']['href'])
                                ? '#'
                                : $options['header']['href']
                                
                        );
                        
                        $header_brand_content = $this->tag(
                                'a', 
                                $header_brand_icon .
                                $options['header']['brand'], 
                                $header_brand_options);
                    } else {
                        $header_brand_content = $options['header']['brand'];
                    }
                }
                if (is_array($options['header']['brand'])){
                    $brand_options = array();
                    
                    $brand_title = $options['header']['brand'][0];
                    
                    if (!empty($options['header']['brand'][1]))
                        $brand_options = $options['header']['brand'][1];
                    
                    $brand_options = $this->addClass('navbar-brand');                   
                    
                    
                    $header_brand_content = $this->tag(
                            'a', 
                            $brand_title, 
                            $brand_options
                            );
                }
            }
            
            $navbar_header = $this->div(
                    $header_toggle_content . 
                    $header_brand_content,
                    'navbar-header'
                    );
        } //header        
            
       
            
        $navbar_options = array();
        $navbar_options = $this->addClass($navbar_options, 'navbar navbar-default');
        if (!isset($options['content']))
            $options['content'] = false;
        
        /*
         * content
         */
        
        if (is_string($options['content'])){
            if ( $this->no_tags($options['content']))
                $navbar_content = $this->tag('p', $options['content'], 'navbar-text');
            else 
                $navbar_content = 
                    $this->li($options['content']);
        } else {
            if (is_array($options['content'])){
                /*
                 * content items
                 */
                $tmp_content = null;
                foreach ($options['content'] as $item0 => $item0_options){
                    
                    if (is_numeric($item0) && is_string($item0_options)){
                        $tmp_content .= $this->li($item0_options);
                    }
                    
                    if (is_string($item0) && is_string($item0_options)){
                        /*
                         * title => href
                         */
                        $tmp_content .= $this->li(
                                $this->a(
                                        $item0,
                                        array(
                                            'href' => $item0_options
                                        )
                                    )
                                );
                    }
                    
                    if (is_string($item0) && is_array($item0_options)){
                        if ($this->is_tag($item0_options)){
                            /*
                             * title => array(options)
                             */
                            
                            $icon = null;
                            
                            if (isset($item0_options['icon']))
                            {
                                $icon = $this->icon($item0_options['icon']) . ' ';
                                unset($item0_options['icon']);
                            }
                            
                            $tmp_content .= $this->li(
                                $this->a(
                                        $icon . $item0,
                                        $item0_options
                                        
                                    )
                                );
                        } else {
                            /*
                             * Drop down menu
                             */
                            $tmp_content .= $this->li(
                                    $this->dropdown($item0, $item0_options,  false, array('tag' => 'a', 'btn' => false))
                                    , 'dropdown');
                        }
                    }
                }
                $navbar_content = $tmp_content;
            }
        }
        
        $padding = isset($options['padding']) ? $options['padding'] : 70;
        
        if (isset($options['fixed'])) {            
            $navbar_options = $this->addClass($navbar_options, 'navbar-fixed-' . $options['fixed']);
            if ($padding !== false) {
                $this->_View->start('css');
                if ($options['fixed'] == 'top')                    
                    echo "<style>body{padding-top: {$padding}px}</style>";
                if ($options['fixed'] == 'bottom')                    
                    echo "<style>body{padding-bottom: {$padding}px}</style>";
                $this->_View->end();    
                
            }
        } 
        
        if (isset($options['inverse'])) {            
            if ($options['inverse'] === true)
                $navbar_options = $this->addClass($navbar_options, 'navbar-inverse');
        } else 
            $navbar_options = $this->addClass($navbar_options, 'navbar-default');
        
        if (isset($options['static'])) {            
            $navbar_options = $this->addClass($navbar_options, 'navbar-static-' . $options['static']);
        } 
          
        if ($navbar_content)
            $navbar_content = $this->ul($navbar_content, 'nav navbar-nav');
          
        if ($navbar_content_right)
            $navbar_content_right = $this->ul($navbar_content_right, 'nav navbar-nav navbar-right');
        
        return $this->tag('nav',
                $this->div(
                        $navbar_header .
                        $this->div(
                               $navbar_content .
                               $navbar_content_right
                                ,
                                array(
                                    'id' => $options['id'],
                                    'class' => 'collapse navbar-collapse'
                                )
                             ),
                        
                        'container-fluid'                       
                     ),
                $navbar_options
                );
    }
    /**
     * 
     * @param type $tabs
     * @param type $navtab_options
     * @param type $tab_content_options
     */
    public function navtabs($tabs = array(), $container_options = array(), $navtab_options = array(), $tab_content_options = array()) {
        $_tabs = array();
        if (empty($tabs[0])) {
            /*
             * simpole assoiative
             */
            foreach ($tabs as $tab_name => $tab_content) {
                $_tabs[] = array(
                    'title' => $tab_name,
                    'content' => $tab_content
                );
            }
        } else {
            /*
             * numeric array
             */            
            $_tabs = $tabs;

        }
        
        $navtabs_content = $tab_content = null;
        
        $active_tab = 0;
        
        if (isset($container_options['active']))
            $active_tab = $container_options['active'];        
        
        for ($i = 0; $i < count($_tabs); $i++) {
            $tab = $_tabs[$i];
            if (!empty($tab['active']))
            {
                $active_tab = $i;
                break;
            }
        }
                
        $_tabs[$active_tab]['active'] = true;

        for ($i = 0; $i < count($_tabs); $i++) {
            $tab = $_tabs[$i];

            if (empty($tab['id']))
                $tab['id'] = 'tab' . uniqid();

            if (is_array($tab['title'])) {
                $tab['title'] = $this->tagFromArray($tab['title']);
            }
            if (empty($tab['li']))    
                $tab['li'] = array();
            
            if (empty($tab['pane']))
                $tab['pane'] = array();
            
            if (empty($tab['a']))
                $tab['a'] = array();
           
            $tab['a'] = array(
                'data-toggle' => 'tab',
                'href' => "#{$tab['id']}",
                'aria-expanded'=>"true",
                'for' => $tab['id']
            ) + $tab['a'];
            
                if (!empty($container_options['fade']))
                    $tab['pane'] = $this->addClass($tab['pane'], 'fade');
                
            if (!empty($tab['active']))
            {
                $tab['li'] = $this->addClass($tab['li'], 'active');
                $tab['pane'] = $this->addClass($tab['pane'], 'active');
                
                if (!empty($container_options['fade']))
                    $tab['pane'] = $this->addClass($tab['pane'], 'in');
            }
            
            $tab['pane']['id'] = $tab['id'];
            $tab['pane']['role'] = 'tabpanel';
            $tab['pane'] = $this->addClass($tab['pane'], 'tab-pane');

            $navtabs_content .= $this->tag(
                    'li',
                    $this->tag(
                            'a', 
                            $tab['title'], 
                            $tab['a']),
                    $tab['li']
                    );
            
            $tab_content .= $this->div(
                    $tab['content'],
                    $tab['pane']
                    );
            /*
             * Js events
             */
            
            foreach (array(
                'show.bs.tab', 
                'shown.bs.tab', 
                'hide.bs.tab', 
                'hidden.bs.tab') as $tab_event)
                if (!empty($tab[ $tab_event ]))
                    $this->Js->get("a[for='{$tab['id']}']")->event($tab_event, $tab[$tab_event]);                
            
            $_tabs[$i] = $tab;
        }
        
        if (!empty($container_options['fade']))
            unset($container_options['fade']);
        
        $navtab_options = $this->addClass($navtab_options, 'nav nav-tabs');
        $tab_content_options = $this->addClass($tab_content_options, 'tab-content');

        $container_options['role'] = 'tabpanel';
        
        return $this->div(
            implode(array(
                $this->tag(
                        'ul', $navtabs_content, $navtab_options
                ),
                $this->div(
                        $tab_content, $tab_content_options
                ),
            )), $container_options
        );

    }

    private function tagFromArray($array) {
        return $this->tag(
                        $array[0], empty($array[1]) ? null : $array[1], empty($array[2]) ? null : $array[2]
        );
    }

    public function thumbnail($content = null, $options = array()) {
        $options = $this->Html->addClass($options, 'thumbnail');
        return $this->tag('div', $content, $options);
    }
    
    public function tag($tagName, $content = null, $options = array()) {

        
        if ($options === false)
        {
            return $content;
        }
        
        if (is_string($options))
            $options = array(
                'class' => $options
            );

        if (!isset($options['escape']))
            $options['escape'] = false;        
        
        if (is_string($options))
            $options = array(
                'class' => $options
            );

        return $this->Html->tag($tagName, $content, $this->contextualClasses($options, $tagName));
    }

    
    private function a($content = null, $options = array()) {
        return $this->tag('a', $content, $options);
    }
    
    public function close($tagName) {
        return "</$tagName>";
    }
    
    public function list_group_item($content = null, $options = array()) {
        $options = $this->addClass($options, 'list-group-item');
        return $this->tag('li', $content, $options);
    }
    
    public function row($content = null, $options = array()) {
        $options = $this->addClass($options, 'row');
        return $this->div($content, $options);
    }
    

    public function li($content = null, $options = array()) {
        return $this->tag('li', $content, $options);
    }
    
    public function label($content, $type = 'default', $options = array()){
        if (is_array($type))
        {
            $options = $type;
            $type = 'default';
        }
        $options['styled'] = $type;
        $options = $this->addClass($options, 'label');
        
        return $this->tag('span', $content, $options);
    }
    
    public function badge($content, $options = array()){

        $options = $this->addClass($options, 'badge');        
        return $this->tag('span', $content, $options);
    }
    
    public function ul($content = null, $options) {
        return $this->tag('ul', $content, $options);
    }

    private function span($content = null, $options) {
        return $this->tag('span', $content, $options);
    }

    public function div($content = null, $options = array()) {
        return $this->tag('div', $content, $options);
    }
    
    public function input($fieldName, $options = array()){

        
        $field = $fieldName;
        $model = $this->Form->defaultModel;
        
        if (strpos('.', $fieldName) !== false){
            list($model, $field) = explode('.', $fieldName);
        }
        
        if (empty($this->schema[$model]))
            $this->schema[$model] = ClassRegistry::init($model)->schema();
        
        $comment = empty($this->schema[$model][$field]['comment']) ? false : $this->schema[$model][$field]['comment'];
        
        if ($comment)
            $options['label'] = $comment;
        
        if (!isset($options['div']))
             $options['div'] = array();
        
        $element_type = 'text';
        
        if (isset($options['options'])){
            $element_type = 'select';
        }
        
        if (!empty($this->schema[$model][$field]['type'])){
            if ($this->schema[$model][$field]['type'] == 'boolean')
                $element_type = 'checkbox';
            if ($this->schema[$model][$field]['type'] == 'date')
               $options['type'] = 'text';
            
        }
        
        

        switch ($element_type) {
            
            case 'checkbox':
                $options['div'] = false;
                $options['label'] = false;
                break;
            case 'select':
                $options = $this->addClass($options, 'form-control');
              //  debug($options);

                break;
            default:
                $options['div'] = $this->addClass($options['div'], 'form-group');
                $options = $this->addClass($options, 'form-control');                
                break;
        }
        
                if (!empty($options['select2'])){
                    $options = $this->addClass($options, 'hide form-control');
                    $options['style'] = 'width: 100%';
                }

        $input_content = $this->Form->input($fieldName, $options);
        
        /*
         * post process
         */
        
        if (!empty($this->schema[$model][$field]['type']))
        
        switch ($this->schema[$model][$field]['type']) {
            case 'date':
                $input_content = str_replace('type="text"', 'type="date"',
                                $input_content);

                break;
            case 'boolean':
                
                $input_content = $this->div(
                        $this->tag('label',
                                implode(array(
                                    $input_content,
                                    ' ',
                                    $comment ? $comment : $fieldName
                                ))
                                ),
                        'checkbox');
                
                break;

            default:
                break;
        }
        

            
        
        return $input_content;
    }
     
    public function submit($title, $btn_options = array()){
        
        $btn_options['tag'] = 'button';
        $btn_options['type'] = 'submit';
        
        if (empty($btn_options['styled']))
            $btn_options['styled'] = BOOTSTRAP_STYLE_PRIMARY;
        
               
        
        return $this->button($title, $btn_options);
    }
    
    public function clearfix(){
        return $this->div('', 'clearfix');
    }
    
    public function button($title, $btn_options = array()){
        $btn = true;
        if (isset($btn_options['btn']))
        {
            $btn = $btn_options['btn'];
            unset($btn_options['btn']);
        }
        if ($btn) 
            $btn_options = $this->addClass($btn_options, 'btn');
        
        if (empty($btn_options['styled']))
            $btn_options['styled'] = 'default';

        $tagName = 'div';
         
        if (isset($btn_options['tag']))
        {
            $tagName = $btn_options['tag'];
            unset($btn_options['tag']);        
        }

        $btn_options['role'] = 'button';

        /*
         * State
         */
        if (isset($btn_options['state'])){
            switch ($tagName) {
                case 'button':
                    switch ($btn_options['state']) {
                        case 'disabled':
                            $btn_options['disabled'] = true;

                            break;
                        case 'active':
                            $btn_options = $this->addClass($btn_options, 'active');

                            break;

                        default:
                            break;
                    }

                    break;

                default:
                    $btn_options = $this->addClass($btn_options, $btn_options['state']);
                    break;
            }
            unset($btn_options['state']);
        }
       
        return $this->tag($tagName, $title, $btn_options);
    }
    
    public function btn_toolbar($btn_groups, $btn_toolbar_options = array()){
        $content = null;
        
        if (is_string($btn_groups))           
            $content = $btn_groups;
        
        if (is_array($btn_groups))           
        
            foreach ($btn_groups as $btn_group){
                $buttons = $btn_group[0];
                $btn_group_options = empty($btn_group[1]) ? array() : $btn_group[1];
                $btn_group_options['role'] = 'group';

                $content .= $this->btn_group($buttons, $btn_group_options);
            }
        
        $btn_toolbar_options = $this->addClass($btn_toolbar_options, 'btn-toolbar');
        
        return $this->div($content, $btn_toolbar_options);
    }
    
    public function btn_group($buttons, $btn_group_options = array()){
        $buttons_content = null;
        
         if (is_string($buttons))
             $buttons_content = $buttons;
         else {
             foreach ($buttons as $one => $two){
                 $button_options = array();
                 $button_title = null;
                 
                 if (is_string($one) && is_array($two)){
                     $button_title = $one;
                     $button_options = $two;
                 }
                 
                 if (is_numeric($one) && is_string($two)){
                     $buttons_content .= $two;
                 }
                 
                 if (is_numeric($one) && is_array($two)){
                     $button_title = 
                             empty($two[0]) 
                                ? null
                                : $two[0];
                     
                     $button_options = 
                             empty($two[1]) 
                                ? null
                                : $two[1];
                                
                 }
                 
                 if (is_string($one) && is_string($two)){
                    $button_title = $one;
                    $button_options['tag'] = 'a';
                    $button_options['href'] = $two;
                 }
                 
                 
                 if ($button_options && $button_title)
                     $buttons_content .= $this->button ($button_title, $button_options);
                     
             }
         }
         
         
         if (is_array($btn_group_options)){
            $btn_group_options['role'] = 'group';

            if (!empty($btn_group_options['vertical']))
                $btn_group_options = $this->addClass($btn_group_options, 'btn-group-vertical');
            else
                $btn_group_options = $this->addClass($btn_group_options, 'btn-group');
         }
         
         if (!$buttons_content)
             return null;
         
         return $this->div(
                 $buttons_content,
                 $btn_group_options
                 );
    }
    
    public function addClass($options, $class){
        return $this->Html->addClass($options, $class);
    }

    public function alert($content, $type = 'warning', $options = array()){

        $options = $this->addClass($options, 'alert');
        $options['role'] = 'alert';
        $close_button = null;
        
        if (empty($options['styled']))
            $options['styled'] = $type;
        
        if (!empty($options['close'])){
            $options = $this->addClass($options, 'alert-dismissible');
            $close_button = $this->tag('button', 
                    $this->span('&times', array(
                        'aria-hidden' => 'true'
                    ))
                    , array(
                'class' => 'close',
                'type' => 'button',
                'data-dismiss' => 'alert',
                'aria-label' => 'Close'
            ));
            unset($options['close']);
        }
        
        return $this->div($close_button . $content, $options);
    }

    public function dropdown($title, $items, $dropdown_options = array(), $button_options = array(), $ul_options = array()){
        $button_content = null;
        $_items = array();
        
        $btn = true;
        
        if (isset($button_options['btn']))
        {
            $btn = $button_options['btn'];
        }
        
        if (empty($button_options['class']) && $btn)
            $button_options = $this->addClass($button_options, 'btn btn-default');
        
        $button_options = $this->addClass($button_options, 'dropdown-toggle');
        
        $button_options = $button_options + array(
            'type' => 'button',
            'data-toggle' => 'dropdown',
            'aria-expanded'=>"true"
        );
        
        $ul_options = $this->addClass($ul_options, 'dropdown-menu');
        $ul_options = $ul_options + array(
            'role' => 'menu'
                
        );

        
        if (is_array($dropdown_options))
        {         
            $dropdown_options = $this->addClass($dropdown_options, 'dropdown');  
        }
        
            foreach ($items as $one => $two){
                $item = array(
                    'a' => array(
                        'href' => '#'
                    ),
                    'li' => array(),
                    'divider' => false
                );
                $li_options = array();
                $divider = false;
                
                if (is_numeric($one) && is_string($two)){
                    /*
                     * divider
                     */
                    $item['divider'] = true;
                    $item['li']['class'] = 'divider';
                }
                if (is_numeric($one) && is_array($two)){
                    $item = $two + $item;
                    if (!empty($item['href']))
                        $item['a']['href'] = $item['href'];
                }
                if (is_string($one) && is_array($two)){
                    $item['title'] = $one;
                    $item['a'] = $two;
                }
                
                if (is_string($one) && is_string($two)){
                   $item['title'] = $one;
                   $item['a']['href'] = $two;
                }
                
                if (empty($item['a']['href']))
                    $item['a']['href'] = '#';
                
                if (!empty($item['divider']))
                    $item['li']['class'] = 'divider';
                if ($two !== false)
                        $_items[] = $this->li(
                            !empty($item['divider'])
                                ? ''
                                : $this->a(
                                    $item['title'],
                                    $item['a']),
                            $item['li']
                            );
          }
          
          
        return $this->div(
            implode(array(
                $this->button(                            
                        //'button',
                        $title .  ' <span class="caret"></span>',
                        $button_options
                        ),
                $this->ul(
                        implode($_items),
                        $ul_options
                     )
            )),
            $dropdown_options
           );
    }

}
