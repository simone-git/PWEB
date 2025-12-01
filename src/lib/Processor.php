<?php

namespace Library;


class Processor {
    private string $path;

    private array $placeholders;

    private const PATTERN = '/{{\s*(\w+)\s*}}/';


    public function __construct(string $path) {
        $this->placeholders = [];
        $this->path = $path;
    }


    public function add(string $key, string $value): void {
        $key = strtoupper($key);
        $this->placeholders[$key] = $value;
    }
    
    public function render(string $name, array $params = []): string {
        $fullPath = $this->path . '/' . $name . '.html';
        if(!is_file($fullPath)) return '';
        
        $content = file_get_contents($fullPath);
        if(!$content) return '';
        
        return $this->process($content, array_merge($this->placeholders, $params));
    }

    private function process(string $template, array $data) {
        return preg_replace_callback(self::PATTERN, function($matches) use ($data) {
            $key = strtoupper($matches[1]);

            return isset($data[$key]) ? $data[$key] : '';
        }, $template);
    }
}
