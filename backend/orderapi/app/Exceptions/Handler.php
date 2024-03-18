<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
        private $url = ['causal', 'observation', 'type_activity', 'technician',
                            'activity', 'order', 'user'];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (NotFoundHttpException $e, $request)
         {
            //añade el preijo api/ a la lista de urls
            $urlFinal = preg_filter('/^/', 'api/', $this->url);
            //añade el sufijo /* a la lista de urls
            $urlFinal = preg_filter('/$/', '/*', $this->url);

            if($request->if($urlFinal)){
                return response()->json([
                 'message' => 'URL No encontrada'
                ], Response::HTTP_NOT_FOUND);
            }

        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request)
        {

           if($request->if()){
               return response()->json([
                'message' => 'Metodo no encontrado o soportado'
               ], Response::HTTP_METHOD_NOT_ALLOWED);
           }

       });
    }
    public function render ($request, Throwable $exeption)
    {
        if ($exeption instanceof AuthorizationException)
        {
            return response()->json([
                'mesagge' => 'Acceso prohibido al recurso'
     ], Response::HTTP_FORBIDDEN);
    }

    if ($exeption instanceof RouteNotFoundException)
    {
        return response()->json([
            'mesagge' => 'Debe Iniciar Sesion'
 ], Response::HTTP_UNAUTHORIZED);
    }
    return parent::render($request, $exeption);
}
}
