<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function () {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
		
		// ob_start(function ($buffer) {
            // $search = array(
                // '/\n/',      // replace end of line by a <del>space</del> nothing , if you want space make it down ' ' instead of ''
                // '/\>[^\S ]+/s',    // strip whitespaces after tags, except space
                // '/[^\S ]+\</s',    // strip whitespaces before tags, except space
                // '/(\s)+/s',    // shorten multiple whitespace sequences
                // '/<!--(.|\s)*?-->/' //remove HTML comments
            // );

            // $replace = array(
                // '',
                // '>',
                // '<',
                // '\\1',
                // ''
            // );

            // $buffer = preg_replace($search, $replace, $buffer);
            // return $buffer;
        // });
		
		$minify = false;
		if ($minify) {
			ob_start(function ($buffer) {
				
				$buffer = preg_replace('~<!--(?!<!)[^\[>].*?-->~s','',$buffer);

				if ($s1=='blog'&&!empty ($s2)){

					'';
					$script = '|script';

				}else{
					$buffer = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/','',$buffer);
					$script = '';
				}

				$re = '%# Collapse whitespace everywhere but in blacklisted elements.
				(?>             # Match all whitespans other than single space.
				  [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
				| \s{2,}        # or two or more consecutive-any-whitespace.
				) # Note: The remaining regex consumes no text at all...
				(?=             # Ensure we are not in a blacklist tag.
				  [^<]*+        # Either zero or more non-"<" {normal*}
				  (?:           # Begin {(special normal*)*} construct
					<           # or a < starting a non-blacklist tag.
					(?!/?(?:textarea|pre|ins|blockquote'.$script.')\b)
					[^<]*+      # more non-"<" {normal*}
				  )*+           # Finish "unrolling-the-loop"
				  (?:           # Begin alternation group.
					<           # Either a blacklist start tag.
					(?>textarea|pre|ins|blockquote'.$script.')\b
				  | \z          # or end of file.
				  )             # End alternation group.
				)  # If we made it here, we are not in a blacklist tag.
				%Six';

				$new_buffer = preg_replace($re, " ", $buffer);

				
				if ($new_buffer === null)
				{
						$new_buffer = $buffer;
				}
				
				return $new_buffer;
				
			});
		}

    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        Services::toolbar()->respond();
    }
});
