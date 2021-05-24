<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Login (LoginController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->helper('cias_helper');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }

    /**
     * This function is used to open error /404 not found page
     */
    public function error()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            $process = 'Error';
            $processFunction = 'Login/error';
            $this->logrecord($process,$processFunction);
            redirect('pageNotFound');
        }
    }

    /**
     * This function is used to access denied page
     */
    public function noaccess() {
        
        $this->global['pageTitle'] = 'XCRUD : Access Denied';
        $this->datas();

        $this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );
    }

    public function addNewLoginPage()
    {
          
        $email = $this->security->xss_clean($this->input->post('email'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fullname','Full Name','trim|required|max_length[60]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('rpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        if($this->form_validation->run() == FALSE)
        {
            echo "validation_error";exit;
        }
        if($this->user_model->isexist($email))
        {
            echo "exist";exit;
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fullname'))));
            $password = $this->input->post('password');
            $roleId = $this->user_model->getRoleId();
            $roleNewId = $roleId[0]->roleid;
            $mobile = '';
            
            $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleNewId, 'name'=> $name,
                                'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                                
            $result = $this->user_model->addNewUser($userInfo);
            
            if($result > 0)
            {
                //$process = 'Add User';
                //$processFunction = 'Admin/addNewUser';
                //$this->logrecord($process,$processFunction);
                echo "success";exit;
            }
            else
            {
                echo "no";exit;
            }
        }
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {/**/
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('/welcome');
        }/* */

    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {    
        // $this->load->view('welcome_message');                                     
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            $result = $this->login_model->loginMe($email, $password);
            
            if(count($result) > 0)
            {
                foreach ($result as $res)   
                {
                    $lastLogin = $this->login_model->lastLoginInfo($res->userId);
                         
                    $process = 'Login';
                    $processFunction = 'Login/loginMe';

                    $sessionArray = array('userId'=>$res->userId,                    
                                            'role'=>$res->roleId,
                                            'roleText'=>$res->role,
                                            'name'=>$res->name,
                                            'lastLogin'=> $lastLogin->createdDtm,
                                            'status'=> $res->status,
                                            'isLoggedIn' => TRUE
                                    );
                    if($res->status == '0' || $res->state == '0')
                    {
                        echo "accessno";
                    }
                    else
                    {
                        $this->session->set_userdata($sessionArray);
                        unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                        $this->logrecord($process,$processFunction);
                        redirect('welcome');
                        var_dump("true");
                        // redirect('/welcome');
                        // $this->load->view('welcome_message');
                        // echo json_encode(array("status" => TRUE));                
                    }
                    exit;
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Email address or password is incorrect.');
                redirect('/login');
                // echo json_encode(array("status" => FALSE));  
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('forgotPassword');
        }
        else
        {
            redirect('/welcome');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->security->xss_clean($this->input->post('login_email'));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    $process = 'Password Reset Request';
                    $processFunction = 'Login/resetPasswordUser';
                    $this->logrecord($process,$processFunction);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Your password reset link has been sent successfully, please check your mail.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email sending failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "There was an error sending your information, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "Your email address is not registered in the system.");
            }
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }

    
    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {               
                $this->login_model->createPasswordUser($email, $password);
                
                $process = 'Password Reset';
                $processFunction = 'Login/createPasswordUser';
                $this->logrecord($process,$processFunction);

                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Failed to change password';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }
}

?>