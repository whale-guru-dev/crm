<?php

namespace App\Http\Middleware\Bap;
use Mews\Purifier\Facades\Purifier;

/**
 * XSS Protection Middleware
 *
 * Class XSSProtection
 * @package App\Http\Middleware\Bap
 */
class XSSProtection
{

    private static $purifier;

    public static function clear($value){

        return self::getPurifier()->purify($value);

    }


    private static function getPurifier() {

        if (is_null(self::$purifier)) {
            //Find full HTML5 config : https://github.com/kennberg/php-htmlpurfier-html5
            $config = \HTMLPurifier_Config::createDefault();
            $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
            $config->set('HTML.SafeIframe', true);

            // Set some HTML5 properties
            $config->set('HTML.DefinitionID', 'html5-definitions'); // unqiue id
            $config->set('HTML.DefinitionRev', 1);
            if ($def = $config->maybeGetRawHTMLDefinition()) {
                // http://developers.whatwg.org/the-video-element.html#the-video-element
                $def->addElement('video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common', array(
                    'src'      => 'URI',
                    'type'     => 'Text',
                    'width'    => 'Length',
                    'height'   => 'Length',
                    'poster'   => 'URI',
                    'preload'  => 'Enum#auto,metadata,none',
                    'controls' => 'Bool',
                ));
            }
            self::$purifier = new \HTMLPurifier($config);

        }

        return self::$purifier;
    }

    /**
     * The following method loops through all request input and strips out all tags from
     * the request. This to ensure that users are unable to set ANY HTML within the form
     * submissions, but also cleans up input.
     *
     * @param $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (!in_array(strtolower($request->method()), ['put', 'post', 'patch'])) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function (&$input) {
            // $input = strip_tags($input, config('bap.xss_protection_available_html_tags')); // Old

            $input = $this->clear($input); // New
        });

        $request->merge($input);

        return $next($request);
    }
}