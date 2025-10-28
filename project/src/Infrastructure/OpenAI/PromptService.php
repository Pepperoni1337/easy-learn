<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

use App\Util\StringUtil;

final class PromptService
{
    public function createPrompt(string $userPrompt): string {
        return StringUtil::concat(
            'Jsi tvůrce kvízů. ',
            'Vytvoř sérii otázek a odpovědí na téma, které zadává uživatel. ',
            'Otázky musí být na sobě nezávislé. ',
            'Každá otázka musí dávat smysl samostatně. ',
            'Odpověď na otázku nesmí být obsažena v otázce. ',
            'Odpověď musí být jedno až dvě slova, málo znaků - například jméno, název. ',
            'Input uživatele: ',
            $userPrompt,
        );
    }
}