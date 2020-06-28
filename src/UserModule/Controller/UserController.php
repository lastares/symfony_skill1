<?php

namespace App\UserModule\Controller;

use App\Exception\FormValidateFailedException;
use App\UserModule\Validate\UserCreateForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     *
     * @Route(
     *     path="/user/create",
     *     name="user_create",
     *     methods={"POST"}
     * )
     *
     * @param Request $request
     * @return Response
     * @throws FormValidateFailedException
     */
    public function create(Request $request): Response
    {

        // 构建form表单对象
        $form = $this->createForm(UserCreateForm::class);

        // 提交表单
        $form->submit(json_decode($request->getContent(), true));

        // 校验表单字段
        if (!$form->isValid()) {
            throw new FormValidateFailedException($form);
        }

        // 返回接送响应
        return $this->json([
            'code' => 0,
            'data' => $form->getData()
        ]);
    }

    /**
     * @Route(
     *     path="/user/test",
     *     name="user_test",
     *     methods={"POST"}
     * )
     *
     * @param Request $request
     * @throws FormValidateFailedException
     */
    public function test(Request $request): void
    {
        dump('dump function test');
        dd('dd function test');
        echo 'hello, world';
    }

}