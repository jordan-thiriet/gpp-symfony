<?php
namespace CorsBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $path = $event->getRequest()->getRequestUri();
        if (strpos($path, '/api/') === 0) {
            return;
        }

        $exception = $event->getException();
        switch(get_class($exception)) {
            case 'Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException':
                $status = 405;
                $message = 'method_not_allowed';
                break;
            case 'Symfony\Component\HttpKernel\Exception\NotFoundHttpException':
                $status = 404;
                $message = $exception->getMessage();
                break;
            default:
                $status = 500;
                $message = $exception;
                break;

        }
        $response = new JsonResponse(array('status'=>$status,'data'=> array('error'=>$message)), $status);
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }

        $event->setResponse($response);
    }
}