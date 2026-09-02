<?php

namespace App\Libraries;

use Config\Services;

/**
 * CodeIgniter 3 style form validation wrapper for CI4.
 */
class CI3FormValidation
{
    protected $validation;

    /** @var array<string, string> */
    protected array $labels = [];

    /** @var array<string, string> */
    protected array $rawRules = [];

    /** @var list<string> */
    protected array $trimFields = [];

    public function __construct()
    {
        // Non-shared instance so rules never leak between requests or callers.
        $this->validation = Services::validation(null, false);
    }

    public function set_rules(string $field, string $label, string $rules): self
    {
        $this->labels[$field] = $label;
        $this->rawRules[$field] = $rules;

        if (preg_match('/\btrim\b/', $rules)) {
            $this->trimFields[] = $field;
        }

        return $this;
    }

    public function run(?array $data = null): bool
    {
        $this->validation->reset();

        foreach ($this->rawRules as $field => $rulesString) {
            $this->validation->setRule(
                $field,
                $this->labels[$field] ?? ucfirst(str_replace('_', ' ', $field)),
                $this->mapRules($rulesString)
            );
        }

        $data ??= $_POST;
        $data = $this->applyTrim($data);

        $passed = $this->validation->run($data);

        if (! $passed) {
            session()->setFlashdata('_ci_validation_errors', $this->validation->getErrors());
        }

        return $passed;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function applyTrim(array $data): array
    {
        foreach ($this->trimFields as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = trim($data[$field]);
            }
        }

        return $data;
    }

    protected function mapRules(string $rules): string
    {
        $mapped = [];

        foreach (explode('|', $rules) as $rule) {
            $rule = trim($rule);

            if ($rule === '' || $rule === 'trim') {
                continue;
            }

            // Never pass CI3-style label[...] through as a rule.
            if (str_starts_with($rule, 'label[')) {
                continue;
            }

            if (str_starts_with($rule, 'matches[')) {
                $target = rtrim(substr($rule, 8), ']');
                $mapped[] = "matches[{$target}]";

                continue;
            }

            $mapped[] = match ($rule) {
                'valid_email' => 'valid_email',
                'numeric'     => 'numeric',
                'integer'     => 'integer',
                'required'    => 'required',
                default       => $rule,
            };
        }

        return implode('|', $mapped);
    }
}
