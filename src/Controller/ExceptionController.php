<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 13/8/18
 * Time: 8:49 AM
 */

namespace App\Controller;



use App\Exception\ValidationException;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController extends Controller
{
    use ControllerTrait;

    /**
     * @param Request $request
     * @param $exception
     * @param DebugLoggerInterface|null $logger
     * @return View
     */
    public function showAction(Request $request, $exception, DebugLoggerInterface $logger = null) {
        if ($exception instanceof ValidationException) {
            return $this->getView($exception->getStatusCode(), json_decode($exception->getMessage(), true));
        } elseif ($exception instanceof HttpException) {
            return $this->getView($exception->getStatusCode(), json_decode($exception->getMessage()));
        }

        return $this->getView(null, 'Unexpected error has occurred');
    }

    /**
     * @param int|null $statusCode
     * @param $message
     * @return View
     */
    private function getView(?int $statusCode, $message): View
    {
        $code = $statusCode ?? 500;
        $data = [ 'code' => $code, 'messages' => $message ];

        return $this->view($data, $code);
    }
}