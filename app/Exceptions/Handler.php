<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use League\OAuth2\Server\Exception\InvalidRequestException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exception\HttpResponseException;

use League\OAuth2\Server\Exception\OAuthException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
	    AuthorizationException::class,
	    HttpException::class,
	    ModelNotFoundException::class,
	    ValidationException::class,
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
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		
		if($e instanceof OAuthException)
		{
			$data = [
                'error' => $e->errorType,
                'error_description' => $e->getMessage(),
            ];
			return response()->json($data, $e->httpStatusCode, $e->getHttpHeaders());
		}

		if($e instanceof HttpResponseException)
		{
			return $e->getResponse();
		}

		if($e instanceof NotFoundHttpException)
		{
			return response()->json(['message' => 'Bad request, please verify your request route', 'code' => 400], 400);
		}
		else
		{
			return response()->json(['message' => 'Unexpected error, try again later', 'code' => 500], 500);
		}
	}

}
