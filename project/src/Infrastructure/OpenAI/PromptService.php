<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

use App\Util\StringUtil;

final class PromptService
{
    public function createPrompt(string $userPrompt): string {
        return StringUtil::concat(
            'Jsi automat na otázky. ',
            'Vytvoř sérii otázek a odpovědí na téma, které zadává uživatel.',
            'Počet otázek musí být cca 2-3, nikdy ne víc, než 5',
            'Otázky musí být na sobě nezávislé.',
            'Odpověď musí být jedno až dvě slova, málo znaků - například jméno, název. ',
            'Input uživatele: "',
            $userPrompt,
            '"'
        );
    }
}