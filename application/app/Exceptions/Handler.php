<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;

// use Exception;
// use Illuminate\Validation\ValidationException;
// use Illuminate\Auth\Access\AuthorizationException;
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Log;

//use KamranAhmed\Faulty\Handler as FaultyHandler;

//class Handler extends FaultyHandler {

class Handler extends ExceptionHandler{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */

    protected $dontReport = [
        // AuthorizationException::class,
        // HttpException::class,
        // ModelNotFoundException::class,
        // ValidationException::class
    ];



    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */

    public function report(Exception $e)
    {
        parent::report($e);
    } 

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    //zach
    //TODO: ajustar para tratar o wantsJson 
/*    
    public function render($request, Exception $e)
    {
        // If the request wants JSON (AJAX doesn't always want JSON)
//        if ($request->wantsJson())
//        {
            // Define the response
            $response = [
                'errors' => 'Sorry, something went wrong.'
            ];

            // If the app is in debug mode
            if (config('app.debug'))
            {
                // Add the exception class name, message and stack trace to response
                $response['exception'] = get_class($e); // Reflection might be better here
                $response['message'] = $e->getMessage();
                $response['trace'] = $e->getTrace();
            }

            // Default response of 400
            $status = 400;

            // If this exception is an instance of HttpException
            if ($this->isHttpException($e))
            {
                // Grab the HTTP status code from the Exception
                $status = $e->getStatusCode();
            }

            // Return a JSON response with the response array and status code
            return response()->json($response, $status);
//        }

        // Default to the parent class' implementation of handler
//        return parent::render($request, $e);
    }
*/


public function render($request, Exception $e)
{
    // if (env('APP_DEBUG')) {
    //   return parent::render($request, $e);
    // }

    $success = false;
    $response = null;
    $status = Response::HTTP_INTERNAL_SERVER_ERROR;
    $return = array();

    Log::info('class:'.get_class($e). 'Mensagem:'.$e->getMessage());

    if ($e instanceof ValidationException) {
      $status = Response::HTTP_BAD_REQUEST;
      $response = $e->getResponse();
    } elseif ($e instanceof HttpResponseException) {
      $status = Response::HTTP_INTERNAL_SERVER_ERROR;
      $response = $e->getResponse();
    } elseif ($e instanceof MethodNotAllowedHttpException) {
      $status = Response::HTTP_METHOD_NOT_ALLOWED;
      $e = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);
    } elseif ($e instanceof NotFoundHttpException) {
      $status = Response::HTTP_NOT_FOUND;
      $e = new NotFoundHttpException('HTTP_NOT_FOUND', $e);
    } elseif ($e instanceof AuthorizationException) {
      $status = Response::HTTP_FORBIDDEN;
      $e = new AuthorizationException('HTTP_FORBIDDEN', $status);
    } elseif ($e instanceof \Dotenv\Exception\ValidationException && $e->getResponse()) {
      $status = Response::HTTP_BAD_REQUEST;
      $e = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $status, $e);
      $response = $e->getResponse();
    } elseif ($e) {
      $e = new HttpException($status, 'HTTP_INTERNAL_SERVER_ERROR');
    }

    $return['success'] = $success;
    $return['status'] = $status;
    $return['message'] = $e->getMessage();

    if (env('APP_DEBUG',true)){
        $return['exception'] = get_class($e);
        $return['response']  = $response;
    }

    if (env('APP_TRACE',true)){
        $return['trace']     = $e->getTrace();
    }    

    return response()->json($return, $status);
}



/*

    public function render($request, Exception $e)
    {

        
        $response['status']  = false; 
        $response['message'] = $e->getMessage();
        $code                = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

        if (env('APP_DEBUG',true)){
            $response['exception'] = get_class($e); // Reflection might be better here
        }

        if (env('APP_TRACE',true)){
            $response['trace']     = $e->getTrace();
        }

        return response()->json($response, $code);

//        if ($request->ajax() || $request->wantsJson()) {
//            $message = $e->getMessage();
//            if (is_object($message)){ 
//                $message = $message->toArray();
//            }

//            return new JsonResponse($message, 422);

//        }else {

//            return parent::render($request, $e);
//        }

//-----------------

//        if ($request->wantsJson())
//                return response()->json(
//                    ['status' => false, 'message' => $e->getMessage()],
//                    method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);

//
//        return parent::render($request, $e);
       
    }


*/

/*
    public function render($request, Exception $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(
                          $this->getJsonMessage($e), 
                          $this->getExceptionHTTPStatusCode($e)
                        );
        }
        return parent::render($request, $e);
    }

    protected function getJsonMessage($e){
        // You may add in the code, but it's duplication
        return [
                  'status' => 'false',
                  'message' => $e->getMessage()
               ];
    }

    protected function getExceptionHTTPStatusCode($e){
        // Not all Exceptions have a http status code
        // We will give Error 500 if none found
        return method_exists($e, 'getStatusCode') ? 
                         $e->getStatusCode() : 500;
    }
*/

}
