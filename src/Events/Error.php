<?php

namespace Hotrush\Events;

use Hotrush\Context\ContextsRegistry;

/**
 *
 * Event Bean for Error wrapping
 *
 * @link https://www.elastic.co/guide/en/apm/server/master/error-api.html
 *
 */
class Error extends EventBean implements \JsonSerializable
{

    /**
     * Error | Exception
     *
     * @link http://php.net/manual/en/class.throwable.php
     *
     * @var \Throwable
     */
    private $throwable;

    /**
     * @param \Throwable        $throwable
     * @param ContextsRegistry  $contextsRegistry
     */
    public function __construct(\Throwable $throwable, ContextsRegistry $contextsRegistry = null)
    {
        parent::__construct($contextsRegistry);
        $this->throwable = $throwable;
    }

    /**
     * Serialize Error Event
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'timestamp' => $this->getTimestamp(),
            'context' => $this->getContext(),
            'culprit' => sprintf('%s:%d', $this->throwable->getFile(), $this->throwable->getLine()),
            'exception' => [
                'message' => $this->throwable->getMessage(),
                'type' => get_class($this->throwable),
                'code' => $this->throwable->getCode(),
                'stacktrace' => $this->mapStacktrace(),
            ]
        ];
    }

    /**
     * Map the Stacktrace to Schema
     *
     * @return array
     */
    private function mapStacktrace(): array
    {
        $stacktrace = [];

        foreach ($this->throwable->getTrace() as $trace) {
            $item = [
                'function' => $trace['function'] ?? '(closure)'
            ];
            if (isset($trace['line'])) {
                $item['lineno'] = $trace['line'];
            }
            if (isset($trace['file'])) {
                $item += [
                    'filename' => basename($trace['file']),
                    'abs_path' => $trace['file']
                ];
            }
            if (isset($trace['class'])) {
                $item['module'] = $trace['class'];
            }
            if (isset($trace['type'])) {
                $item['type'] = $trace['type'];
            }

            if (!isset($item['lineno'])) {
                $item['lineno'] = 0;
            }

            if (!isset($item['filename'])) {
                $item['filename'] = '(anonymous)';
            }

            array_push($stacktrace, $item);
        }

        return $stacktrace;
    }

}
