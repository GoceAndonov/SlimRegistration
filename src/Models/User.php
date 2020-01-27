<?php
namespace Src\Models;
require __DIR__ . '/../../vendor/autoload.php';
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Query\Builder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

	protected $table = 'users';
    private $view;
    private $logger;

    protected $fillable = [
		'name',
        'email',
		'password',
        'verified',
	];

    public function getall($request, $response)
    {
        $users = $this->container->db->table('users')->get();
        foreach ($users as $user){
            echo $user->name . "</br>";
            echo $user->email . "</br>";
        }
    }

//    public function __construct(
//        Twig $view,
//        LoggerInterface $logger,
//        Builder $table
//    ) {
//        $this->view = $view;
//        $this->logger = $logger;
//        $this->table = $table;
//    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $users = $this->table->get();

        $this->view->render($response, 'app/index.twig', [
            'users' => $users
        ]);

        return $response;
    }




}