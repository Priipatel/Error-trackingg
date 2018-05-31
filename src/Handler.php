<?php 

namespace Errorlog\errortrack;

use Exception;
use Log;
use Request;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Validation\ValidationException as ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Throwable;

class Handler
{
    /** @var CorsService $cors */
    protected $cors;

    /** @var Dispatcher $events */
    protected $events;

    public function __construct(CorsService $cors, Dispatcher $events)
    {
        $this->cors = $cors;
        $this->events = $events;
    }

    /**
	 * Handle an incoming request. Based on Asm89\Stack\Cors by asm89
	 * @see https://github.com/asm89/stack-cors/blob/master/src/Asm89/Stack/Cors.php
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if (! $this->cors->isCorsRequest($request)) {
            return $next($request);
        }

        if ($this->cors->isPreflightRequest($request)) {
            return $this->cors->handlePreflightRequest($request);
        }

		if ( ! $this->cors->isActualRequestAllowed($request)) {
			return new Response('Not allowed.', 403);
		}

		// Add the headers on the Request Handled event as fallback in case of exceptions
		if (class_exists(RequestHandled::class)) {
            $this->events->listen(RequestHandled::class, function(RequestHandled $event) {
                $this->addHeaders($event->request, $event->response);
            });
        } else {
            $this->events->listen('kernel.handled', function(Request $request, Response $response) {
                $this->addHeaders($request, $response);
            });
        }

        $response = $next($request);

        return $this->addHeaders($request, $response);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
	protected function addHeaders(Request $request, Response $response)
    {
        // Prevent double checking
        if ( ! $response->headers->has('Access-Control-Allow-Origin')) {
            $response = $this->cors->addActualRequestHeaders($response, $request);
        }

        return $response;
    }
}