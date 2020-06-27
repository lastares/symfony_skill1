<?php

namespace App\EventListener;

use App\Exception\FormValidateFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExceptionListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(
        TranslatorInterface $translator
    )
    {
        $this->translator = $translator;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event)
    {
        // 设置自定义的header的头的status code
        $event->allowCustomResponseCode();

        // You get the exception object from the received event
        $exception = $event->getThrowable();

        // Customize your response object to display the exception details
        $response = new JsonResponse();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) { // 路由、请求方式、地址错误
            $response->setData([
                'code' => Response::HTTP_NOT_FOUND,
                'msg' => $exception->getMessage()
            ]);
            $response->setStatusCode(Response::HTTP_OK);
        } elseif ($exception instanceof FormValidateFailedException) { // 表单验证错误
            $formErrors = $exception->getForm()->getErrors(true);
            foreach ($formErrors as $error) {
                $filedChineseName = $this->translator->trans($error->getOrigin()->getName());
                $response->setData([
                    'code' => -1,
                    'msg' => $filedChineseName . $error->getMessage()
                ]);
                break;
            }
        } else { // 致命错误，程序运行将会中断
            $response->setData([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => $this->translator->trans('Http internal server error.')
            ]);
            $response->setStatusCode(Response::HTTP_OK);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}