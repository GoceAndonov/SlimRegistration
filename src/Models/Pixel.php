<?php
namespace Src\Models;
require __DIR__ . '/../../vendor/autoload.php';
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Query\Builder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Eloquent\Model;

class Pixel extends Model
{

	protected $table = 'pixels';
    private $view;
    private $logger;

    protected $fillable = [
		'userId',
        '$ixelType',
		'occuredOn',
        'portalId',
	];

    public function getall($request, $response)
    {
        $pixels = $this->container->db->table('pixel')->get();
        foreach ($pixels as $user){
            echo $pixels->userId . "</br>";
            echo $pixels->pixelType . "</br>";
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
        $pixels = $this->table->get();

        $this->view->render($response, 'app/index.twig', [
            'pixels' => $pixels
        ]);

        return $response;
    }




}