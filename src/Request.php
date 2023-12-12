<?php
namespace MiniSpeed;

class Request {
    public function post(string $name, int $filter = FILTER_DEFAULT): mixed {
        if (isset($_POST[$name])) {
            return is_array($_POST[$name])
                ? filter_input(INPUT_POST, $name, $filter, FILTER_REQUIRE_ARRAY)
                : filter_input(INPUT_POST, $name, $filter);
        } else {
            return null;
        }
    }

    public function file(string $name, int $filter = FILTER_DEFAULT): mixed {
        return isset($_FILES[$name]) ? $_FILES[$name] : false;
    }

    public function switchTipe(mixed $value) : int {
        return match ($value) {
            is_int($value) => FILTER_VALIDATE_INT,
            is_string($value) => FILTER_SANITIZE_STRING,
            is_bool($value) => FILTER_VALIDATE_BOOLEAN,
            default => FILTER_DEFAULT,
        };
    }

    public function get(string $name, int $filter = FILTER_DEFAULT): mixed {
        return isset($_GET[$name]) ? filter_var($_GET[$name], $this->switchTipe($name)) : null;
    }

    public function server(string $name, int $filter = FILTER_DEFAULT): mixed {
        return filter_input(INPUT_SERVER, $name, $filter);
    }

    public function method(): string {
        return $this->server('REQUEST_METHOD') ?? '';
    }

    public function raw(string $format = ''): mixed {
        $raw = file_get_contents('php://input');
        if ($format === 'json') {
            return json_decode($raw);
        }
        if ($format === 'json_assoc') {
            return json_decode($raw, true);
        }
        return $raw;
    }

    public function header(string $name = ''): mixed {
        $headers = getallheaders();
        if ($name === '') {
            return $headers;
        } else {
            return $headers[$name] ?? null;
        }
    }
}
