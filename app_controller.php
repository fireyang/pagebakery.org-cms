<?php
class AppController extends Controller {

    public $components = array('Auth', 'RequestHandler', 'Cookie');

    public $helpers = array('Form', 'Html', 'Javascript', 'Navigation');

    public function beforeFilter() {
        //if there is a core error, just show it
        if( $this->action == null ) {
            return false;
        }

        App::import('Core', 'Sanitize');

        $this->Cookie->path = '/';

        // set json contenttype
        $this->RequestHandler->setContent('json', 'text/x-json');

        if( isset($this->Auth) ) {
            $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => true);
            $this->Auth->logoutAction = array('controller' => 'users', 'action' => 'logout', 'admin' => true);
            $this->Auth->autoRedirect = false;
        }

        if( isset($this->params['admin']) && $this->params['admin'] == 1 ) {
            $this->layout = 'admin_default';
        }
        
        $this->addBreadcrumb(array('Home', array('controller' => 'dashboard', 'action' => 'index')));
    }

    public function beforeRender() {
        // render the error layout if an error occurs
        if ( $this->viewPath == 'errors' ) {
           // $this->layout = 'error';
        }
        // automatically use json view if the request expects json
        if( $this->RequestHandler->responseType() == 'json' ) {
            $this->view = 'json';
        }
    }
    
    protected function addBreadcrumb($breadcrumb = array()) {
        if( !empty($breadcrumb) ) {
            $this->params['breadcrumbs'][] = $breadcrumb;
        }
    }

}
?>