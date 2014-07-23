<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        $authAdapter = $this->getAuthAdapter();
        //Zend_Debug::dump($authAdapter->getDBSelect());


        //replace this with vars from from
        $email = 'kokovasquez@gmail.com';
        $password  = 'chocheraz1';

        //passing login credentials to adapther
        $authAdapter->setIdentity($email)
                    ->setCredential($password);

        //do the authentication using an instance of Zend Auth
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        if($result->isValid()) {
        	//get the whole ROW the the specific user
    		$identity = $authAdapter->getResultRowObject();
    		//store to persistent storage mechanism User identity for available global
    		$authStorage = $auth->getStorage();
    		$authStorage->write($identity);
    		
    		//redirect to the homepage
    		$this->_redirect('index/index');
  
        } else {
            echo "Auth INVALID";
        }

    }

    public function logoutAction()
    {
        // action body
    }

    private function getAuthAdapter() 
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('user')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('password')
                    ->setCredentialTreatment('SHA1(?)');

        return $authAdapter;
    }

} 



