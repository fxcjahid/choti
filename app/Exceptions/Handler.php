<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array<int, class-string<Throwable>>
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array<int, string>
	 */
	protected $dontFlash = [
		'current_password',
		'password',
		'password_confirmation',
	];

	/**
	 * Register the exception handling callbacks for the application.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->reportable(function (Throwable $e) {
			//
		});
	}


	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Throwable $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Throwable $exception)
	{
		if (
			$exception  instanceof NotFoundHttpException ||
			$exception instanceof ModelNotFoundException
		) {
			return response()->view('public.components.errors.404', [], 404);
		}

		return parent::render($request, $exception);
	}
}