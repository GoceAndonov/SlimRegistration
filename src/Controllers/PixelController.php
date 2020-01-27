<?php
namespace Src\Controllers;
use Src\Models\Pixel;
use Slim\Views\Twig as View;

class PixelController
{
    protected $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function index($request, $response)
    {
        return $this->view->render($response, 'pixel.twig');
    }

    public function storePixel($request, $response)
    {
//        $app = new \Slim\Slim();
//        $app->post('/pixel', function ($request, $response){
            $pixelType = $_POST['pixelType'];
            $userId = $_POST['userId'];
            $occuredOn = $_POST['occuredOn'];
            $portalId = $_POST['portalId'];

            $pixel = Pixel::create([ //store in db
                'userId' => $userId,
                'pixelType' => $pixelType,
                'occuredOn' => $occuredOn,
                'portalId' => $portalId,
            ]);

            checkDuplicate($pixel);

//            header(Status: 200);
//        });
//            return 1 //simulate successful db insert;
            return $response->withJson($pixel);
    }

    public function checkDuplicate($pixel)
    {
        $query = "select * from pixel where userId = $pixel->userId";
        $result = $this->db->prepare($query);
        $result->execute();

        if(!empty($result)){
            if($pixel->userId === $result->userId && $pixel->pixelType === $result->pixelType && $pixel->occuredOn === $result->occuredOn && $pixel->portalId === $result->portalId){
                header("Status: 401"); //Pixel exists
                exit;
            }
            else{
                header("Status: 200");
            }
        }
    }

    public function listPixel($userId)
    {
//        $app = new \Slim\Slim();
//        $app->get('/pixel/list', function ($request, $response){

            $query = "select * from pixel where userId = $userId";
            $result = $this->db->prepare($query);
            $result->execute();

            if(empty($result)){
                http_response_code(404);
            }
            else{
                http_response_code(200);
            }
//        });
    }
}
