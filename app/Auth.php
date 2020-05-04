<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth extends Controller
{
    function __construct()
    {
        parent::__construct();

        $this->lib('session');
        $this->lib('input');
        $this->lib('database');

        $this->view = new View();
        $this->input = new input();
        
        $this->session = new Session();

    }

    function login()
    {
        if(!empty(userdata('id'))){ $this->redirect(''); }
        $this->view->render('auth/login');
    }

    function logout()
    {
        session_destroy();
        $this->redirect('');
    }

    function login_post()
    {
        $email = $this->input->post('email',true,FILTER_VALIDATE_EMAIL);
        $pass = $this->input->post('pass',false);
        $db = new Database();
        $user = $db->select('users',['id','email','password','username'],['email="'.$email.'"']);
        if(!empty($user)){
            
        $pass = sha1(md5($pass));
            if($user[0]['password']==$pass){
                $this->session->auth(true);
                userdata('id',$user[0]['id']);
                userdata('email',$user[0]['email']);
                userdata('username',$user[0]['username']);
                $this->redirect('');
            } else {

                flash('login','User or Password didnot match.');
                $this->session->auth();
                
            }

        } else {

            flash('login','User Not Found');
            $this->session->auth();

        }
    }

    public function signup()
    {
        $this->view->render('auth/register');
    }

    public function resend_v_email()
    {

        $v_code = $this->input->get('code');
        if($v_code){
            $db = new Database();

            $user = $db->select('users',['*'],['v_code="'.$v_code.'"'],'limit 1');

            if(!empty($user)){
                $user = $user[0];

                if($user['status']==0){
                $mail = new PHPMailer(true);

                try {

                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'mail.dagar.in';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'verify@dagar.in';                     // SMTP username
                    $mail->Password   = 'admin@dagar';                               // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
                    //Recipients
                    $mail->setFrom('verify@dagar.in', 'Verify');
                         // Add a recipient
                    $mail->addAddress($user['email']);    
                               // Name is optional
                    $mail->addReplyTo('no-reply@dagar.com', 'No-reply');
    
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Welcome to Chatie. | Verifiy Email';
                    $mail->Body    = $this->emailtemplate($this->env('appUrl').'v?code='.$v_code);
    
                    $mail->send();
    
                } catch (Exception $e) {
                    echo 'retry';
                }
            }
    
            }

            

        }

        $this->redirect('notverified');

    }
    
    public function verify_email()
    {
        $v_code = $this->input->get('code');
        
        $db = new Database();
        $user = $db->select('users',['id','v_code','status'],['v_code="'.$v_code.'"'],'limit 1');
        if(!empty($user)){
            
            if($user[0]['v_code']==$v_code && $user[0]['status'] == '0'){
                
                $db->update('users',
                    [
                        'v_code=""','status="1"'
                    ],
                    ['id="'.$user[0]['id'].'"']
                );
                $this->redirect('');

            } else {

                flash('verify_email','Somthing went wrong.');
                $this->redirect('notverified');
                   
            }

        } else {

            flash('verify_email','User Not Found');
            $this->redirect('notverified');

        }
    }

    public function register()
    {

        $email = $this->input->post('email',true,FILTER_VALIDATE_EMAIL);
        $name = $this->input->post('name');
        $gender = $this->input->post('gender');
        $pass = $this->input->post('pass',false);
        $cpass = $this->input->post('cpass',false);

        try {
            
            $db = new Database();
            $user = $db->select('users',['id','email','password','username'],['email="'.$email.'"']);
            if(empty($user)){
                
                if($pass==$cpass){
                    
                    $username = microtime();
                    $pass =  sha1(md5($pass));
                    $v_code =  sha1(md5($pass));
                    $db->insert('users',
                            ['email','password','username','gender','name','v_code'],
                            [$email,$pass,$username,$gender,$name,$v_code]);
                    
                    $user = $db->select('users',['id','email','password','username'],['email="'.$email.'"']);
                    
                    $this->session->auth(true);
                    userdata('id',$user[0]['id']);
                    userdata('email',$user[0]['email']);
                    userdata('username',$user[0]['username']);
                    userdata('intro',true);
                    $_GET['code'] = $v_code;
                    $this->resend_v_email();
                    $this->redirect('');

                } else {

                    flash('register','Password And Confirm Password do not match.');
                    $this->session->auth();
                    
                }

            } else {

                flash('register','User Alerdy Registered');
                $this->session->auth();

            }

        } catch (\Throwable $th) {
            //throw $th;
        }
        
        
    }

    public function emailtemplate(string $link)
    {
        return $link;
    }

}
