<?php


namespace app\Http\Middleware;

use Closure;
use SoapBox\Formatter\Formatter;

/**
 * This Class is used to return a response in
 * format given by request. Alternative is use the
 * default format defined in .env
 *
 * Class FormatMiddleware
 * @package app\Http\Middleware
 */
class FormatMiddleware
{
    /**
     * Handle an incoming request and return the corresponding format.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $type = $request->get('type');

        $response = $next($request);

        if(strtolower($type) === Formatter::XML){
            $formatter = Formatter::make($response->getContent(), 'json');
            $xmlData = $formatter->toXml();
            $response->setContent($xmlData);
            $response->header('content-type', 'application/xml');
        }

        return $response;
    }
}