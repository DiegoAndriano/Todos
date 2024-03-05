<?php

namespace App\Services;

use App\Actions\Plantillas\IPlantilla;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isInstanceOf;

class CreateTodoService implements ICreateTodoService {

    private IPlantilla $concreteStrategy;

    public function resolve(string $strategy): array
    {
        $files = File::allFiles(app_path('Actions/Plantillas'));

        foreach($files as $file){
            if(str_contains($file->getFilename(), $strategy)) {
                $this->concreteStrategy = new ('App\Actions\Plantillas\\' .  str_replace('.php', '', $strategy));
            }
        }

        if(! isset($this->concreteStrategy)){
            return ['error' => true];
        }

        return ['error' => false];
    }

    public function execute(): array
    {
        $this->concreteStrategy->execute();

        return ['error' => false];
    }
}
