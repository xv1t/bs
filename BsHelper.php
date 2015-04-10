<?php
/*
 * Bootstrap Helper
 * testing Bootstrap: 3.3.4
 * 
 * version: 2015-04-10
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

define('BOOTSTRAP_STATE_ACTIVE', 'active');
define('BOOTSTRAP_STATE_DISABLED', 'disabled');

App::uses('Helper', 'View');
class BsHelper extends AppHelper {

    var $helpers = array(
        'Html',
        'Form',
        'Js'
    );
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
            $options = $this->Html->addClass($options, 'text-' . $options['text']);
            unset($options['text']);
        }
        
        if (!empty($options['bg']))
        {
            $options = $this->Html->addClass($options, 'bg-' . $options['bg']);
            unset($options['bg']);
        }

        if ($this->hasClass($options, 'btn-group')){
            if (isset($options['sized'])){
                $options = $this->Html->addClass($options, 'btn-group-' . $options['sized']);
                unset($options['sized']);
            }
        }

        if ($this->hasClass($options, 'btn-group-vertical')){
            if (isset($options['sized'])){
                $options = $this->Html->addClass($options, 'btn-group-' . $options['sized']);
                unset($options['sized']);
            }
        }
        
        if ($this->hasClass($options, 'panel')){
            if (!empty($options['styled']))
            {
                $options = $this->Html->addClass($options, 'panel-' . $options['styled']);
                unset($options['styled']);
            }            
        }
        
        if ($tagName == 'span' && $this->hasClass($options, 'label')){
            if (isset($options['styled']))
            {
                $options = $this->Html->addClass($options, 'label-' . $options['styled']);
                unset($options['styled']);
            }
        }
        
        if ($tagName == 'span' && $this->hasClass($options, 'badge')){
            if (isset($options['styled']))
            {
                $options = $this->Html->addClass($options, 'badge-' . $options['styled']);
                unset($options['styled']);
            }
        }
        
        if ($tagName == 'p'){
            if (!empty($options['lead'])){
                $options = $this->Html->addClass($options, 'lead');
                unset($options['lead']);
            }
        }
        
        if ($this->hasClass($options, 'btn')){
            if (isset($options['sized']))
            {
                $options = $this->Html->addClass($options, 'btn-' . $options['sized']);
                unset($options['sized']);
              //  debug($options);
            }
            
            if (isset($options['styled']))
            {
                $options = $this->Html->addClass($options, 'btn-' . $options['styled']);
                unset($options['styled']);
            }
        }
        
        return $options;
    }
    
    private function hasClass($options, $class){
        if (empty($options['class']))
            return false;
        
        return in_array($class, explode(' ', $options['class']));
    }

    /**
     * 
     * $body, 
     * $title = null, 
     * $footer = null
     * 
     * Bw::panel('Text');
     * <div class="panel panel-default">
     *    <div class="panel-body">Text</div>
     * </div>
     * 
     * Bs::panel('Text', 'Title');
     * <div class="panel panel-default">
     *    <div class="panel-heading">
     *      <h3 class="panel-title">Title</h3>
     *    </div>
     *    <div class="panel-body">Text</div>
     * </div>
     * 
     * Bs::panel('Text', 'Title', 'Footer');
     * <div class="panel panel-default">
     *    <div class="panel-heading">
     *      <h3 class="panel-title">Title</h3>
     *    </div>
     *    <div class="panel-body">Text</div>
     *    <div class="panel-footer">Footer</div>
     * </div>
     * 
     * Bs::panel(array(
     *          'title' => array(
     *                  'h1',
     *                  'Title',
     *                  array('class' => 'text-success')
     *              )
     *          'body' => array('Body text', array('class' => 'text-danger')),
     *          'footer' => array('Footer text', array('class' => 'text-info')),
     *      ), array(
     *          'id' => 'my_uid_234534hg345',
     *          'class' => 'panel-primary'
     *      ));
     * 
     * 
     */
    public function panel($body, $title = null, $footer = null) {

        $_options = array(
            'title' => null,
            'body' => null,
            'footer' => null,
        );

        $panel_options = array();

        if (is_array($body))
            $_options = $body;

        if (is_array($title))
            $panel_options = $title;

        if (is_string($title))
            $_options['title'] = $title;

        if (is_string($body))
            $_options['body'] = $body;

        if (is_string($footer))
            $_options['footer'] = $footer;

        /*
         * main panel options
         */
        $panel_options = $this->Html->addClass($panel_options, 'panel panel-default');

        $panel_heading = $panel_body = $panel_footer = null;

        if (is_string($_options['title']))
            $panel_heading = $this->div(
                    $this->tag(
                            'h3', $_options['title'], array('class' => 'panel-title')
                    ), array(
                'class' => 'panel-heading')
            );

        if (is_array($_options['title']))
            $panel_heading = $this->div(
                    $this->tagFromArray($_options['title']), array(
                'class' => 'panel-heading')
            );

        if (is_string($_options['body']))
            $panel_body = $this->div(
                    $_options['body'], array('class' => 'panel-body')
            );

        if (is_array($_options['body']))
            $panel_body = $this->div(
                    $_options['body'][0], $this->Html->addClass($_options['body'][1], 'panel-body')
            );

        if (is_string($_options['footer']))
            $panel_footer = $this->div(
                    $_options['footer'], array('class' => 'panel-footer')
            );

        if (is_array($_options['footer']))
            $panel_footer = $this->div(
                    $_options['footer'][0], $this->Html->addClass($_options['footer'][1], 'panel-footer')
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

    public function icon($icon, $options = array()){
        if (is_string($icon))
            $options = $this->Html->addClass($options, $icon);
        
        if (strpos($options['class'], 'fa-') !== false)
             if (!$this->hasClass($options, 'fa'))   
               $options = $this->Html->addClass($options, 'fa');      
        
        
        
        if (is_array($icon)){
            
        }
        
        return $this->tag('i', '', $options);
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
                    $tab['pane'] = $this->Html->addClass($tab['pane'], 'fade');
                
            if (!empty($tab['active']))
            {
                $tab['li'] = $this->Html->addClass($tab['li'], 'active');
                $tab['pane'] = $this->Html->addClass($tab['pane'], 'active');
                
                if (!empty($container_options['fade']))
                    $tab['pane'] = $this->Html->addClass($tab['pane'], 'in');
            }
            
            $tab['pane']['id'] = $tab['id'];
            $tab['pane']['role'] = 'tabpanel';
            $tab['pane'] = $this->Html->addClass($tab['pane'], 'tab-pane');

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
        
        $navtab_options = $this->Html->addClass($navtab_options, 'nav nav-tabs');
        $tab_content_options = $this->Html->addClass($tab_content_options, 'tab-content');

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

    public function tag($tagName, $content = null, $options) {

        if (!isset($options['escape']))
            $options['escape'] = false;

        return $this->Html->tag($tagName, $content, $this->contextualClasses($options, $tagName));
    }

    
    private function a($content = null, $options) {
        return $this->tag('a', $content, $options);
    }
    
    private function li($content = null, $options) {
        return $this->tag('li', $content, $options);
    }
    
    public function label($content, $type = 'default', $options = array()){
        if (is_array($type))
        {
            $options = $type;
            $type = 'default';
        }
        $options['styled'] = $type;
        $options = $this->Html->addClass($options, 'label');
        
        return $this->tag('span', $content, $options);
    }
    
    public function badge($content, $options = array()){

        $options = $this->Html->addClass($options, 'badge');        
        return $this->tag('span', $content, $options);
    }
    
    private function ul($content = null, $options) {
        return $this->tag('ul', $content, $options);
    }

    private function div($content = null, $options) {
        return $this->tag('div', $content, $options);
    }
    
     
    public function button($title, $btn_options = array()){
       
        $btn_options = $this->Html->addClass($btn_options, 'btn');
        
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
                            $btn_options = $this->Html->addClass($btn_options, 'active');

                            break;

                        default:
                            break;
                    }

                    break;

                default:
                    $btn_options = $this->Html->addClass($btn_options, $btn_options['state']);
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
        
        $btn_toolbar_options = $this->Html->addClass($btn_toolbar_options, 'btn-toolbar');
        
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
         
         
         $btn_group_options['role'] = 'group';
         
         if (!empty($btn_group_options['vertical']))
             $btn_group_options = $this->Html->addClass($btn_group_options, 'btn-group-vertical');
         else
             $btn_group_options = $this->Html->addClass($btn_group_options, 'btn-group');
         
         if (!$buttons_content)
             return null;
         
         return $this->div(
                 $buttons_content,
                 $btn_group_options
                 );
        
        
    }


    public function dropdown($title, $items, $dropdown_options = array(), $button_options = array(), $ul_options = array()){
        $button_content = null;
        $_items = array();
        
        if (empty($button_options['class']))
            $button_options = $this->Html->addClass($button_options, 'btn btn-default');
        
        $button_options = $this->Html->addClass($button_options, 'dropdown-toggle');
        
        $button_options = $button_options + array(
            'type' => 'button',
            'data-toggle' => 'dropdown',
            'aria-expanded'=>"true"
        );
        
        $ul_options = $this->Html->addClass($ul_options, 'dropdown-menu');
        $ul_options = $ul_options + array(
            'role' => 'menu'
                
        );

        if (empty($dropdown_options['class']))
        {         
            $dropdown_options = $this->Html->addClass($dropdown_options, 'dropdown');  
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
                
                $_items[] = $this->li(
                    !empty($item['divider'])
                        ? ''
                        : $this->a(
                            $item['title'],
                            $item['a']),
                    $item['li']
                    );
          }
        
          if (!empty($dropdown_options['btn-group']))              
          
                return
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
                    ));
          
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
