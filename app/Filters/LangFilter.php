<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LangFilter implements FilterInterface
{
    private const VALID = ['es', 'en', 'fr'];

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $uri     = service('uri');
        $segment = $uri->getSegment(1);

        if (in_array($segment, self::VALID, true)) {
            $session->set('lang', $segment);
        } elseif (!$session->get('lang')) {
            // Detect from Accept-Language header
            $accept = $request->getHeaderLine('Accept-Language');
            $lang   = 'es';
            foreach (self::VALID as $code) {
                if (str_contains($accept, $code)) {
                    $lang = $code;
                    break;
                }
            }
            $session->set('lang', $lang);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
