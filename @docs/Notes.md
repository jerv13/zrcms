NOTES
=====



### HTTP ### 

- Handlers for request status
    - This may require our own pipe
    - injectable middleware the says what to do on non-200 status codes

### Tracking ###

- Tracking: who (userId) - what (action) - why(reason)


                // @todo Logger::warning()
                trigger_error(
                    "Tag section is not defined: ({$section}) "
                    . " in: " . json_encode($sections),
                    E_USER_WARNING
                );


\ContentCore\View\ => \ContentCore\View\

\ContentCore\View\
