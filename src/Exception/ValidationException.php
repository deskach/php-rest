<?php
/**
 * Created by PhpStorm.
 * User: dzianis
 * Date: 13/8/18
 * Time: 8:37 AM
 */

namespace App\Exception;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends HttpException
{
    public function __construct(ConstraintViolationListInterface $errors)
    {
        $message = [];

        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $message[$error->getPropertyPath()] = $error->getMessage();
        }

        parent::__construct(422, json_encode($message));
    }
}