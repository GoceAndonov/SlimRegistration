<?php
namespace Src\Controllers;
use Src\Models\User;
use Slim\Views\Twig as View;

class LoginController
{
	protected $view;
	
	public function __construct(View $view)
	{		
		$this->view = $view;
	}
		
	public function index($request, $response)
	{
		return $this->view->render($response, 'login.twig');
	}
	
	public function checkUser($request, $response)
	{
        $email 	= $request->getParam('txtEmail');
		$userpwd 	= md5($request->getParam('txtPwd'));
		$users 		= User::where('password', '=', $userpwd)
							->where('email', '=', $email)->get();
		
		if(sizeof($users) > 0)
		{
			$message = "Success";
			$code	 = "success";
		}
		else
		{
			$message = "Not Valid, Try Again!!";
			$code	 = "error";
		}
		return $this->view->render($response, 'login.twig', [
			'errors' => $message,
			'code' => $code
			]);			
	}
}
