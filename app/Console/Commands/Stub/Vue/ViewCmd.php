<?php

namespace App\Console\Commands\Stub\Vue;

use Illuminate\Console\Command;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ViewCmd extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create View Files Index, Forms, Details, etc..';

    protected $type = 'Vue';

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        // First we need to ensure that the given name is not a reserved word within the PHP
        // language and that the class name will actually be valid. If it is not valid we
        // can error now and prevent from polluting the filesystem using invalid files.
        if ($this->isReservedName($this->getNameInput())) {
            $this->error('The name "'.$this->getNameInput().'" is reserved by PHP.');

            return false;
        }

        $names = explode(',', $this->getNameInput());

        foreach ($names as $_name) {
            $name = $this->qualifyClass(trim($_name));

            $path = $this->getPath($name);
            // Next, We will check to see if the class already exists. If it does, we don't want
            // to create the class and overwrite the user's code. So, we will bail out so the
            // code is untouched. Otherwise, we will continue generating this class' files.
            if ((! $this->hasOption('force') ||
                 ! $this->option('force')) &&
                $this->alreadyExists($this->getNameInput())) {
                $this->error($this->type.' already exists!');

                return false;
            }

            // Next, we will generate the path to the location where this class' file should get
            // written. Then, we will build the class and make the proper replacements on the
            // stub files so that it gets the correctly formatted namespace and class name.
            $this->makeDirectory($path);

            $this->files->put($path, $this->sortImports($this->buildClass($name)));

            $this->info($this->type.' created successfully.');

            if (in_array(CreatesMatchingTest::class, class_uses_recursive($this))) {
                $this->handleTestCreation($path);
            }
        }
    }

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        $name = class_basename(str_replace('\\', '/', $rawName));

        $path = "{$this->laravel['path']}/../resources/js/" . config('jetstream.project_view') . "/{$rawName}.vue";

        return file_exists($path);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/vue.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $name = class_basename(str_replace('\\', '/', $name));

        $stub = str_replace('{{ name }}', $name, $stub);

        return $this;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path("resources/js/") . config('jetstream.project_view') . '/' . str_replace('\\', '/', $name).'.vue';
    }

    private function partialsDir($nameSpace)
    {
        $a = explode('/', $nameSpace);

        $nameSpace = str_replace('\\', '/', Str::replaceFirst(array_pop($a), '', $nameSpace));

        return base_path("resources/js/") . config('jetstream.project_view') . "/{$nameSpace}Partials/";
    }
}
