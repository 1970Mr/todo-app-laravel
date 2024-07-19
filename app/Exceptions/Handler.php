<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

  public function render($request, Throwable $exception)
  {
    $response = parent::render($request, $exception);

    if ($response->status() === 419) {
      return back()->with([
        'expired_message' => 'The page expired, please try again.',
      ]);
    }

    return $response;
  }
}
