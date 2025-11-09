<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

use App\Core\Quiz\Model\Difficulty;
use App\Util\StringUtil;

final class PromptService
{
    public function createPrompt(string $userPrompt, Difficulty $difficulty): string
    {
        return StringUtil::concat(
            'Jsi velmi chytrý tvůrce kvízů. \n',
            'Vytvoř sérii otázek a odpovědí na téma, které zadává uživatel. \n',
            "Obtížnost: {$difficulty->getCzechName()}. \n'",
            'Otázky musí být na sobě nezávislé. \n',
            'Každá otázka musí dávat smysl samostatně. \n',
            'Odpověď na otázku nesmí být obsažena v otázce. \n',
            'Odpověď musí být jedno až dvě slova, málo znaků - například jméno, název, letopočet. \n',
            'Použij tool qa_list. \n',
            'Input uživatele: \n"',
            $userPrompt,
            '"',
        );
    }
}
