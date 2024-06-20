<?php

namespace App\Controller;

class PhpTemplateEngine
{
	private const TEMPLATES_DIR = '/home/yogurt/Documents/projects/after-pizza-project/src/View';
	public static function render(string $templateName, array $vars = []): string {
		$templatePath = self::TEMPLATES_DIR . '/' . $templateName;
		if (!file_exists($templatePath)) {
			throw new \InvalidArgumentException("Template file '$templatePath' not found.");
		}

		if (!ob_start()) {
			throw new \RuntimeException("Failed to render template: ob_start() failed");
		}
		try {
			extract($vars);
			require_once $templatePath;
			$contents = ob_get_contents();
		} finally {
			ob_end_clean();
		}

		return $contents;
	}
}