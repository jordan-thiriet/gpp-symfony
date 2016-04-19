<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use UserBundle\Form\UserChangePasswordType;

class UserController extends FOSRestController
{

    /**
     * @Get("/user", name="_getUser")
     */
    public function getUserAction()
    {
        return $this->view($this->getUser(), Codes::HTTP_OK);
    }

    /**
     * @Put("/user/change-password", name="_putChangePassword")
     */
    public function putChangePasswordAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $objectManager = $this->get('user.manager');

        $user = $this->getUser();

        if($user === null || $user === false) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }


        $user->setPlainPassword($request->get('password'));

        $userManager->updatePassword($user);

        $objectManager->save($user);

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }

    /**
     * @Put("/user/upload-avatar", name="_postUploadAvatar")
     */
    public function postUploadAvatarAction(Request $request) {

        $user = $this->getUser();
        $imageManager = $this->get('cors.image.manager');
        $imageManager->base64toImg('images/avatar/'.$user->getId().'.png', $request->get('picture'));
        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }
}
